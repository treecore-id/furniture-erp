<?php

namespace App\Http\Controllers;

use App\Models\Wood;
use App\Http\Requests\StoreWoodRequest;
use App\Http\Requests\UpdateWoodRequest;
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
            Session::flash('success', $this->messages['success_save']);
            return to_route('wood.index');
        } catch (\Exception $e) {
            Log::error('Failed to save wood data: ' . $e->getMessage(), [
                'user_id' => $userId,
                'input_data' => $request
            ]);
            Session::flash('error', $this->messages['failed_save']);
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
        //
    }

    /* Remove the specified resource from storage. */
    public function destroy(Wood $wood)
    {
        //
    }
}
