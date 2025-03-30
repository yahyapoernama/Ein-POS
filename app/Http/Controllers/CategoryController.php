<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
                return (new TableActions(
                    id: $row->id,
                    listRoute: 'admin.categories.show',
                    editRoute: 'admin.categories.update',
                    deleteRoute: 'admin.categories.destroy',
                    editFields: [
                        'name' => $row->name,
                        'slug' => $row->slug
                    ]
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
                'name' => ['required', Rule::unique('categories')->whereNull('deleted_at')],
                'slug' => ['required', Rule::unique('categories')->whereNull('deleted_at')],
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
}
