<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        $data_category = Category::select([
            'id', 'public_id', 'name', 'slug', 'parent_id'
        ])->with('parent:id,public_id,name,slug')->orderBy('name')->paginate(10);

        return Inertia::render('category/CategoryPage', [
            'data_category' => $data_category
        ]);
    }

    /* Show the form for creating a new resource. */
    public function create()
    {
        $data_category = Category::select('id', 'public_id', 'name', 'slug')->orderBy('name')->get();
        return Inertia::render('category/CategoryCreatePage', ['data_category' => $data_category]);
    }

    /* Store a newly created resource in storage. */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        try {
            $category = Category::create($validated);

            // return to_route('category.show', $category->id)->with('success', $this->messages['save_success']);
            return to_route('category.index')->with('success', $this->messages['save_success']);
        } catch (\Exception $e) {
            Log::error('Failed to save category data: ' . $e->getMessage(), [
                'input_data' => $validated
            ]);
            return back()->withInput()->with('error', $this->messages['save_failed']);
        }
    }

    /* Display the specified resource. */
    public function show(Category $category)
    {
        return Inertia::render('category/CategoryDetailsPage', [
            'data_category' => $category->only('id', 'public_id', 'name', 'slug')
        ]);
    }

    /* Show the form for editing the specified resource. */
    public function edit(Category $category)
    {
        //
    }

    /* Update the specified resource in storage. */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->safe()->only(['name', 'slug']);

        try {
            $category->update($validated);

            return to_route('category.index')->with('success', $this->messages['update_success']);
        } catch (\Exception $e) {
            Log::error('Failed to update category data: ' . $e->getMessage(), [
                'input_data' => $validated
            ]);
            return back()->withInput()->with('error', $this->messages['update_failed']);
        }
    }

    /* Archive the specified resource in storage. */
    public function archive(Category $category)
    {
        try {
            $category->delete();

            return to_route('category.index')->with('success', $this->messages['archive_success']);
        } catch (\Exception $e) {
            Log::error('Failed to archive category data: ' . $e->getMessage(), [
                'category_id' => $category->id
            ]);
            return back()->withInput()->with('error', $this->messages['archive_failed']);
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(Category $category)
    {
        try {
            $category->forceDelete();

            return to_route('category.index')->with('success', $this->messages['delete_success']);
        } catch (\Exception $e) {
            Log::error('Failed to delete category data: ' . $e->getMessage(), [
                'user_id' => $userId,
                'category_id' => $category->id
            ]);
            return back()->withInput()->with('error', $this->messages['delete_failed']);
        }
    }
}
