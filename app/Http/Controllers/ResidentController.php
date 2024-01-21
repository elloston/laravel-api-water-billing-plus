<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResidentRequest;
use App\Models\Resident;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Resident::paginate(50));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResidentRequest $request)
    {
        $validated = $request->validated();

        $resident = new Resident();
        $resident->fio = $validated['fio'];
        $resident->area = $validated['area'];
        $resident->start_date = $validated['start_date'];
        $resident->save();

        return response()->json($resident, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Resident $resident)
    {
        return response()->json($resident, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResidentRequest $request, Resident $resident)
    {
        $validated = $request->validated();

        $resident->fio = $validated['fio'];
        $resident->area = $validated['area'];
        $resident->start_date = $validated['start_date'];
        $resident->save();

        return response()->json($resident, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resident $resident)
    {
        $resident->delete();

        return response()->json(null, 204);
    }
}
