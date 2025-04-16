<?php

namespace App\Http\Controllers;

use App\Http\Traits\ValidationRules\CategoryValidationRules;
use App\Models\Category;
use App\Utils\CurrencyFormatter;
use App\View\Components\TableActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    use CategoryValidationRules;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Get data for DataTables.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        return DataTables::of(Category::select(['id', 'name', 'slug', 'description']))
            ->addIndexColumn()
            ->addColumn('action', function ($category) {
                return (new TableActions(
                    id: $category->id,
                    listButton: true,
                    listCount: $category->products()->count(),
                    editButton: true,
                    deleteButton: true
                ))->render();
            })
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Category::create($request->validate($this->storeRules()));

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Category created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        return response()->json(['success' => true, 'data' => Category::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id)
    {
        return response()->json(['success' => true, 'data' => Category::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        try {
            DB::beginTransaction();

            // Retrieve the category from the database
            $category = Category::findOrFail($id);

            // Validate using update rules
            $request->validate($this->updateRules($id));

            // Define the fields to check for changes
            $fields = ['name', 'slug', 'description'];

            // Check if data has changed
            if (!$this->hasDataChanged($request, $category, $fields)) {
                return $this->noChangeResponse();
            }

            // Proceed with the update if data has changed
            $category->update($request->only($fields));

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Category updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            DB::beginTransaction();

            Category::findOrFail($id)->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Get data for Select2 plugin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function select2(Request $request)
    {
        $query = $request->get('q');

        return response()->json(Category::select('id', 'name')
            ->where('name', 'ilike', '%' . $query . '%')
            ->orWhere('slug', 'ilike', '%' . $query . '%')
            ->get());
    }

    /**
     * Get data for DataTables of products related to the category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function products(int $id)
    {
        return DataTables::of(Category::findOrFail($id)->products)
            ->addIndexColumn()
            ->editColumn('price', function ($product) {
                return CurrencyFormatter::formatRupiah($product->price);
            })
            ->editColumn('description', function ($product) {
                if ($product->description) {
                    return $product->description;
                } else {
                    return '<span class="text-secondary"><i><small>No description</small></i></span>';
                }
            })
            ->addColumn('action', function ($product) {
                return (new TableActions(
                    id: $product->id,
                    model: 'product',
                    editButton: true,
                    editUrl: route('admin.products.edit', $product->id),
                    deleteButton: true
                ))->render();
            })
            ->make(true);
    }
}
