<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wood\StoreWoodRequest;
use App\Http\Requests\Wood\UpdateWoodRequest;
use App\Models\Wood;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class WoodController extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        $data_wood = Wood::select(['id', 'public_id', 'name', 'description'])->orderBy('name')->where('archived', 0)->paginate(10);

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
        $userId = Auth::id();

        $validated = array_merge($request->validated(), [
            'user_created' => $userId,
            'user_updated' => $userId
        ]);

        try {
            Wood::create($validated);
            Session::flash('success', $this->messages['save_success']);
            return to_route('wood.index');
        } catch (\Exception $e) {
            Log::error('Failed to save wood data: ' . $e->getMessage(), [
                'user_id' => $userId,
                'input_data' => $request
            ]);
            Session::flash('error', $this->messages['save_failed']);
            return back()->withInput();
        }
    }

    /* Display the specified resource. */
    public function show(Wood $wood)
    {
        //
    }

    /* Show the form for editing the specified resource. */
    public function edit(Wood $wood)
    {
        //
    }

    /* Update the specified resource in storage. */
    public function update(UpdateWoodRequest $request, Wood $wood)
    {
        $userId = Auth::id();

        $validated = $request->validated();
        $validated = $request->safe()->only(['name', 'description']);
        $validated['user_updated'] = $userId;

        try {
            Wood::whereId($wood->id)->update($validated);
            Session::flash('success', $this->messages['update_success']);
            return to_route('wood.index');
        } catch (\Exception $e) {
            Log::error('Failed to update wood data: ' . $e->getMessage(), [
                'user_id' => $userId,
                'input_data' => $request
            ]);
            Session::flash('error', $this->messages['update_failed']);
            return back()->withInput();
        }
    }

    /* Archive the specified resource in storage. */
    public function archive(Wood $wood)
    {
        $userId = Auth::id();

        $data = [
            'user_updated' => $userId,
            'archived' => 1,
        ];

        try {
            Wood::whereId($wood->id)->update($data);
            Session::flash('success', $this->messages['archive_success']);
            return to_route('wood.index');
        } catch (\Exception $e) {
            Log::error('Failed to save wood data: ' . $e->getMessage(), [
                'user_id' => $userId,
                'wood_id' => $wood->id
            ]);
            Session::flash('error', $this->messages['archive_failed']);
            return back()->withInput();
        }
    }

    /* Remove the specified resource from storage. */
    public function destroy(Wood $wood)
    {
        $userId = Auth::id();

        try {
            $wood->delete();
            Session::flash('success', $this->messages['delete_success']);
            return to_route('wood.index');
        } catch (\Exception $e) {
            Log::error('Failed to save wood data: ' . $e->getMessage(), [
                'user_id' => $userId,
                'wood_id' => $wood->id
            ]);
            Session::flash('error', $this->messages['delete_failed']);
            return back()->withInput();
        }
    }
}
