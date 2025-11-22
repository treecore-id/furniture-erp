<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wood\StoreWoodRequest;
use App\Http\Requests\Wood\UpdateWoodRequest;
use App\Models\Wood;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class WoodController extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        $data_wood = Wood::select([
            'id', 'public_id', 'name', 'description'
        ])->orderBy('name')->paginate(10);

        return Inertia::render('wood/WoodPage', [
            'data_wood' => $data_wood
        ]);
    }

    /* Show the form for creating a new resource. */
    public function create()
    {
        return Inertia::render('wood/WoodCreatePage');
    }

    /* Store a newly created resource in storage. */
    public function store(StoreWoodRequest $request)
    {
        $validated = $request->validated();

        try {
            $wood = Wood::create($validated);

            return to_route('wood.show', $wood->public_id)->with('success', $this->messages['save_success']);
        } catch (\Exception $e) {
            Log::error('Failed to save wood data: ' . $e->getMessage(), [
                'input_data' => $validated
            ]);
            return back()->withInput()->with('error', $this->messages['save_failed']);
        }
    }

    /* Display the specified resource. */
    public function show(Wood $wood)
    {
        return Inertia::render('wood/WoodDetailsPage', [
            'data_wood' => $wood->only('id', 'public_id', 'name', 'description')
        ]);
    }

    /* Show the form for editing the specified resource. */
    public function edit(Wood $wood)
    {
        //
    }

    /* Update the specified resource in storage. */
    public function update(UpdateWoodRequest $request, Wood $wood)
    {
        $validated = $request->safe()->only(['name', 'description']);

        try {
            $wood->update($validated);

            return to_route('wood.show', $wood->public_id)->with('success', $this->messages['update_success']);
        } catch (\Exception $e) {
            Log::error('Failed to update wood data: ' . $e->getMessage(), [
                'input_data' => $validated
            ]);
            return back()->withInput()->with('error', $this->messages['update_failed']);
        }
    }

    /* Archive the specified resource in storage. */
    public function archive(Wood $wood)
    {
        try {
            $wood->delete();

            return to_route('wood.index')->with('success', $this->messages['archive_success']);
        } catch (\Exception $e) {
            Log::error('Failed to archive wood data: ' . $e->getMessage(), [
                'wood_id' => $wood->id
            ]);
            return back()->withInput()->with('error', $this->messages['archive_failed']);
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(Wood $wood)
    {
        try {
            $wood->forceDelete();

            return to_route('wood.index')->with('success', $this->messages['delete_success']);
        } catch (\Exception $e) {
            Log::error('Failed to delete wood data: ' . $e->getMessage(), [
                'user_id' => $userId,
                'wood_id' => $wood->id
            ]);
            return back()->withInput()->with('error', $this->messages['delete_failed']);
        }
    }
}
