<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\PumpMeterRecord;
use App\Models\Resident;
use App\Models\WaterRate;
use App\Services\PeriodService;

class BillService
{
    protected $periodServices;

    public function __construct(PeriodService $periodService)
    {
        $this->periodServices = $periodService;
    }

    public function getBillsForDate($date)
    {
        $period = $this->periodServices->findOrCreatePeriod($date);

        // Get bills for the specified period
        return Bill::where('period_id', $period->id)->paginate(50);
    }

    public function calculateBillsForDate($date)
    {
        $period = $this->periodServices->findOrCreatePeriod($date);

        $pumpMeterRecord = PumpMeterRecord::where('period_id', $period->id)->firstOrFail();
        $waterRate = WaterRate::where('period_id', $period->id)->firstOrFail();

        $totalCost = $waterRate->price * $pumpMeterRecord->amount_volume;

        $residents = Resident::where('start_date', '<=', $period->end_date)->get(['id', 'area']);

        $totalArea = $residents->sum('area');

        // Prepare the data
        $billsData = $residents->map(function ($resident) use ($period, $totalArea, $totalCost) {
            $amountBill = ($resident->area / $totalArea) * $totalCost;

            return [
                'period_id' => $period->id,
                'resident_id' => $resident->id,
                'amount_rub' => $amountBill,
            ];
        })->all(); // Convert the collection to a plain array

        // Update or insert bills
        $affectedBills = Bill::upsert($billsData, ['period_id', 'resident_id'], ['amount_rub']);

        return $affectedBills;
    }
}
