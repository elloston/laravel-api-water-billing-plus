<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResidentRequest;
use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortBy = $request->query('sortBy', 'id');
        $order = $request->query('order', 'asc') === 'desc' ? 'desc' : 'asc';
        $perPage = (int) $request->query('perPage', 50);

        $allowedSortColumns = ['id', 'fio', 'area', 'start_date'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }

        $residents = Resident::orderBy($sortBy, $order)->paginate($perPage);

        return response()->json($residents, 200);
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
