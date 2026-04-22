<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PickingDetail;

class SyncInvoicesFromERP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza pickings con facturas desde ERP';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info('Inicio Sync ERP: '.now());

        PickingDetail::whereNull('invoiced_at')
            ->where('created_at', '>=', now()->subDays(90))
            ->chunk(500, function ($details) {

                $pedidos = $details
                    ->pluck('CFNUMPED')
                    ->unique()
                    ->values()
                    ->toArray();

                if (empty($pedidos)) {
                    return;
                }

                $facturas = \DB::connection('sqlsrv')
                    ->table('FACCAB as f')
                    ->join('FACDET as df', function($join) {
                        $join->on('f.CFTD', '=', 'df.DFTD')
                             ->on('f.CFNUMSER', '=', 'df.DFNUMSER')
                             ->on('f.CFNUMDOC', '=', 'df.DFNUMDOC');
                    })
                    ->where('f.CFTD', '!=', 'NC')
                    ->where('f.CFESTADO', 'V')
                    ->whereIn('f.CFNROPED', $pedidos)
                    ->select('f.CFNROPED', 'df.DFCODIGO', 'df.DFCANTID', 'f.CFFECDOC', 'f.CFNUMSER', 'f.CFNUMDOC')
                    ->get();

                $index = [];

                foreach ($facturas as $f) {
                    $key = $f->CFNROPED.'_'.$f->DFCODIGO;
                    $index[$key] = $f;
                }

                foreach ($details as $detail) {
                    $key = $detail->CFNUMPED.'_'.$detail->codigo;
                    if (isset($index[$key])) {
                        $factura = $index[$key];
                        $detail->quantity_invoiced = $factura->DFCANTID;
                        $detail->quantity_pending_billing = $detail->quantity - $detail->quantity_invoiced;
                        $detail->invoiced_at = $factura->CFFECDOC;
                        $detail->invoice = $factura->CFNUMSER."-". $factura->CFNUMDOC;
                        $detail->save();
                    }
                }
            });

        \Log::info('Fin Sync ERP: '.now());
    }
}
