<?php

namespace App\Http\Controllers;

use App\Http\Requests\PumpMeterRecordRequest;
use App\Models\PumpMeterRecord;
use App\Services\PeriodService;
use Illuminate\Http\Request;

class PumpMeterRecordController extends Controller
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
        $meterRecord = PumpMeterRecord::where("period_id", $period->id)->firstOrFail();

        return response()->json($meterRecord, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PumpMeterRecordRequest $request)
    {
        $validated = $request->validated();

        $period = $this->periodService->findOrCreatePeriod($validated['date']);

        $pumpMeterRecord = PumpMeterRecord::updateOrCreate(
            ['period_id' => $period->id],
            ['amount_volume' => $validated['amount_volume']]
        );

        return response()->json($pumpMeterRecord);
    }

    /**
     * Display the specified resource.
     */
    public function show(PumpMeterRecord $pumpMeterRecord)
    {
        return response()->json($pumpMeterRecord);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PumpMeterRecordRequest $request, PumpMeterRecord $pumpMeterRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PumpMeterRecord $pumpMeterRecord)
    {
        $pumpMeterRecord->delete();

        return response()->json(null, 204);
    }
}
