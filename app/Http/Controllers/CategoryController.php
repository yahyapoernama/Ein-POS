<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Utils\CurrencyFormatter;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\View\Components\TableActions;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function getData()
    {
        $data = Category::select('*');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $productCount = $row->products()->count();
                return (new TableActions(
                    id: $row->id,
                    listButton: true,
                    listCount: $productCount,
                    editButton: true,
                    deleteButton: true
                ))->render();
            })
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => ['required', Rule::unique('categories')->whereNull('deleted_at')],
                'slug' => ['required', Rule::unique('categories')->whereNull('deleted_at')],
            ]);

            Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Category created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $category = Category::find($id);

        return response()->json(['success' => true, 'data' => $category]);
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return response()->json(['success' => true, 'data' => $category]);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'name' => ['required', Rule::unique('categories')->whereNull('deleted_at')->ignore($id, 'id')],
                'slug' => ['required', Rule::unique('categories')->whereNull('deleted_at')->ignore($id, 'id')],
            ]);

            $category = Category::find($id);
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->description = $request->description;
            $category->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Category updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $category = Category::find($id);
            $category->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function select2(Request $request)
    {
        $query = $request->get('q');
        $categories = Category::where('name', 'ilike', '%' . $query . '%')
            ->orWhere('slug', 'ilike', '%' . $query . '%')
            ->select('id', 'name')
            ->get();

        return response()->json($categories);
    }

    public function products($id)
    {
        $category = Category::find($id);

        return DataTables::of($category->products)
            ->addIndexColumn()
            ->editColumn('price', function ($row) {
                return CurrencyFormatter::formatRupiah($row->price);
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
            ->make(true);
    }
}
