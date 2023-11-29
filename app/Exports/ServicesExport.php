<?php

namespace App\Exports;

use App\Modules\Storage\Product;
use App\Modules\Storage\Stock;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ServicesExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('exports.services', [
            'services' => Product::where('category_id', 17)->get()
        ]);
    }
}
