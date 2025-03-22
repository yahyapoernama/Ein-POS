<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function getData()
    {
        $data = Category::select(['id', 'name']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }
}
