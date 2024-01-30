<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillRequest;
use App\Http\Resources\BillResource;
use App\Models\Bill;
use App\Services\BillService;
use App\Services\PeriodService;
use Illuminate\Http\Request;

class BillController extends Controller
{
    protected $billService;
    protected $periodService;

    public function __construct(BillService $billService, PeriodService $periodService)
    {
        $this->billService = $billService;
        $this->periodService = $periodService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate(["date" => 'required|date']);

        $sortBy = $request->query('sortBy', 'id');
        $order = $request->query('order', 'asc') === 'desc' ? 'desc' : 'asc';
        $perPage = (int) $request->query('perPage', 50);

        $allowedSortColumns = ['id', 'amount_rub'];

        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }

        $period = $this->periodService->findOrCreatePeriod($request->date);

        // Get bills for the specified period
        $bills = Bill::where('period_id', $period->id)
            ->orderBy($sortBy, $order)
            ->paginate($perPage);


        return BillResource::collection($bills);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillRequest $request)
    {
        $affectedBills = $this->billService->calculateBillsForDate($request->date);

        $message = ($affectedBills > 0) ? "{$affectedBills} bills upserted successfully." : 'No changes were made.';

        return response()->json(['message' => $message, 'bills' => $affectedBills], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        return response()->json(new BillResource($bill), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        $bill->delete();

        return response()->json(null, 204);
    }
}
