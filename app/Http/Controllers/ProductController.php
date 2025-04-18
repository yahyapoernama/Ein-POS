<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Utils\CurrencyFormatter;
use App\Utils\Sanitizer;
use App\View\Components\TableActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function getData()
    {
        $data = Product::select('*');

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('price', function ($row) {
                return CurrencyFormatter::formatRupiah($row->price);
            })
            ->addColumn('categories', function ($row) {
                if ($row->categories->isNotEmpty()) {
                    return $row->categories->map(function ($category) {
                        return '<span class="badge text-bg-dark">' . $category->name . '</span>';
                    })->implode(' ');
                } else {
                    return '<span class="text-secondary"><i><small>No categories</small></i></span>';
                }
            })
            ->editColumn('description', function ($row) {
                if ($row->description) {
                    return $row->description;
                } else {
                    return '<span class="text-secondary"><i><small>No description</small></i></span>';
                }
            })
            ->addColumn('action', function ($row) {
                return (new TableActions(
                    id: $row->id,
                    editButton: true,
                    deleteButton: true
                ))->render();
            })
            ->rawColumns(['action', 'categories', 'description'])
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => ['required', Rule::unique('products')->whereNull('deleted_at')],
                'price' => ['required', 'numeric'],
                'description' => ['nullable', 'string'],
            ]);

            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => Sanitizer::clean($request->description, 'string'),
            ]);

            $product->categories()->sync($request->categories);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Product created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $product = Product::find($id)->load('categories');

        return response()->json(['success' => true, 'data' => $product]);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => ['required', Rule::unique('products')->whereNull('deleted_at')->ignore($id, 'id')],
                'price' => ['required', 'numeric'],
                'description' => ['nullable', 'string'],
            ]);

            $product = Product::find($id);
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = Sanitizer::clean($request->description, 'string');
            $product->save();

            $product->categories()->sync($request->categories);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Product updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $product = Product::find($id);
            $product->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
