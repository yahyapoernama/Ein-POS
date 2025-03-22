<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function getData()
    {
        $data = Product::select(['id', 'name', 'price']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }
}
