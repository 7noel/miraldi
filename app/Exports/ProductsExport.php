<?php

namespace App\Exports;

use App\Modules\Storage\Product;
use App\Modules\Storage\Stock;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('exports.stocks', [
            'stocks' => Stock::with('product')->get()
        ]);
    }
}
