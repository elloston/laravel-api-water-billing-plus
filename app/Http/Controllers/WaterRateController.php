<?php

namespace App\Http\Controllers;

use App\Http\Requests\WaterRateRequest;
use App\Models\WaterRate;
use App\Services\PeriodService;
use Illuminate\Http\Request;

class WaterRateController extends Controller
{
    protected $periodService;

    public function __construct(PeriodService $periodService)
    {
        $this->periodService = $periodService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate(['date' => 'required|date']);

        $period = $this->periodService->findOrCreatePeriod($request->date);
        $waterRate = WaterRate::where("period_id", $period->id)->firstOrFail();

        return response()->json($waterRate, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WaterRateRequest $request)
    {
        $validated = $request->validated();

        $period = $this->periodService->findOrCreatePeriod($validated['date']);

        $waterRate = WaterRate::updateOrCreate(
            ['period_id' => $period->id],
            ['price' => $validated['price']]
        );

        return response()->json($waterRate, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(WaterRate $waterRate)
    {
        return response()->json($waterRate, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WaterRateRequest $request, WaterRate $waterRate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WaterRate $waterRate)
    {
        $waterRate->delete();

        return response()->json(null, 204);
    }
}
