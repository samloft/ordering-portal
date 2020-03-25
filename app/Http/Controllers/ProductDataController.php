<?php

namespace App\Http\Controllers;

use App\Exports\ProductDataExport;
use App\Exports\ProductPricesExport;
use App\Models\Category;
use App\Models\GlobalSettings;
use Maatwebsite\Excel\Facades\Excel;

class ProductDataController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function index()
    {
        $product_data = GlobalSettings::productData();

        if ($product_data['data'] || $product_data['prices']) {

            $brands = $product_data['prices'] ? Category::brand() : [];

            return view('product-data.index', compact('product_data', 'brands'));
        }

        return abort(404);
    }

    /**
     * @return \Maatwebsite\Excel\BinaryFileResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function prices()
    {
        ini_set('memory_limit', '256M');

        return Excel::download(new ProductPricesExport(request('brand'), request('range')), 'product-net-prices.xlsx');
    }

    /**
     * @return \Maatwebsite\Excel\BinaryFileResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function data()
    {
        ini_set('memory_limit', '256M');

        return Excel::download(new ProductDataExport, 'product-data.xlsx');
    }
}
