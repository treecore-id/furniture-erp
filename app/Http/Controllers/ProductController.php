<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ProductController extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        $data_product = Product::select([
            'id', 'public_id', 'category_id', 'name', 'description', 'product_code', 'unit_price'
        ])->orderBy('name')->paginate(3);

        return Inertia::render('product/ProductPage', [
            'data_product' => $data_product
        ]);
    }

    /* Show the form for creating a new resource. */
    public function create()
    {
        return Inertia::render('product/ProductCreatePage');
    }

    /* Store a newly created resource in storage. */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Product
            $product = Product::create([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'product_code' => $validated['product_code'] ?? null,
                'unit_price' => $validated['unit_price'] ?? null,
            ]);

            // Product Attribute
            if (isset($validated['attributes'])) {
                $attributesToSave = [];
                foreach ($validated['attributes'] as $attr) {
                    $attributesToSave[] = new ProductAttribute([
                        'attribute_name' => $attr['name'],
                        'attribute_value' => $attr['value'],
                    ]);
                }
                $product->attributes()->saveMany($attributesToSave);
            }

            // Product Image
            $imagesToSave = [];
            $mainImageIndex = $validated['main_image_index'];

            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('images/products', 'public');

                $imagesToSave[] = new ProductImage([
                    'path' => $path,
                    'is_main' => ($index == $mainImageIndex),
                    'sort_order' => $index,
                ]);
            }

            $product->images()->saveMany($imagesToSave);

            DB::commit();

            Session::flash('success', $this->messages['save_success']);
            return to_route('product.show', $product->id);
        } catch (\Exception $e) {
            Log::error('Failed to save product data: ' . $e->getMessage(), [
                'input_data' => $validated
            ]);
            Session::flash('error', $this->messages['save_failed']);
            return back()->withInput();
        }
    }

    /* Display the specified resource. */
    public function show(Product $product)
    {
        return Inertia::render('product/ProductDetailsPage', [
            'data_product' => $product->only('id', 'public_id', 'category_id', 'name', 'description', 'product_code', 'unit_price')
        ]);
    }

    /* Show the form for editing the specified resource. */
    public function edit(Product $product)
    {
        //
    }

    /* Update the specified resource in storage. */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->safe()->only(['category_id', 'name', 'description', 'product_code', 'unit_price']);

        DB::beginTransaction();
        try {
            // Product
            $product->update([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'product_code' => $validated['product_code'] ?? null,
                'unit_price' => $validated['unit_price'] ?? null,
            ]);

            DB::commit();

            Session::flash('success', $this->messages['update_success']);
            return to_route('product.index');
        } catch (\Exception $e) {
            Log::error('Failed to update product data: ' . $e->getMessage(), [
                'input_data' => $validated
            ]);
            Session::flash('error', $this->messages['update_failed']);
            return back()->withInput();
        }
    }

    /* Archive the specified resource in storage. */
    public function archive(Product $product)
    {
        try {
            $product->delete();

            return to_route('product.index')->with('success', $this->messages['archive_success']);
        } catch (\Exception $e) {
            Log::error('Failed to archive product data: ' . $e->getMessage(), [
                'product_id' => $product->id
            ]);
            Session::flash('error', $this->messages['archive_failed']);
            return back()->withInput();
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(Product $product)
    {
        try {
            $product->forceDelete();

            Session::flash('success', $this->messages['delete_success']);
            return to_route('product.index');
        } catch (\Exception $e) {
            Log::error('Failed to delete product data: ' . $e->getMessage(), [
                'user_id' => $userId,
                'product_id' => $product->id
            ]);
            Session::flash('error', $this->messages['delete_failed']);
            return back()->withInput();
        }
    }
}
