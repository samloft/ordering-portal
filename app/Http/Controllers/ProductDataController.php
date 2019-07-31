<?php

namespace App\Http\Controllers;

use App\Models\Prices;
use App\models\ProductSpec;
use Illuminate\Http\Request;

class ProductDataController extends Controller
{
    public function index()
    {
        $specs = Prices::productSpecs();

        foreach ($specs as $spec) {
            dd($spec);
        }
    }
}
