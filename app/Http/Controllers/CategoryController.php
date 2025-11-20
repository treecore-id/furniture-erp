<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        $data_category = Category::select([
            'id', 'public_id', 'name', 'description'
        ])->orderBy('name')->paginate(3);

        return Inertia::render('category/CategoryPage', [
            'data_category' => $data_category
        ]);
    }

    /* Show the form for creating a new resource. */
    public function create()
    {
        //
    }

    /* Store a newly created resource in storage. */
    public function store(Request $request)
    {
        //
    }

    /* Display the specified resource. */
    public function show(Category $category)
    {
        //
    }

    /* Show the form for editing the specified resource. */
    public function edit(Category $category)
    {
        //
    }

    /* Update the specified resource in storage. */
    public function update(Request $request, Category $category)
    {
        //
    }

    /* Remove the specified resource from storage. */
    public function destroy(Category $category)
    {
        //
    }
}
