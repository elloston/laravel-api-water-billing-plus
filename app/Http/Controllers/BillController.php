<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillRequest;
use App\Models\Bill;
use App\Services\BillService;
use Illuminate\Http\Request;

class BillController extends Controller
{
    protected $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(BillRequest $request)
    {
        $bills = $this->billService->getBillsForDate($request->date);

        return response()->json($bills, 200);
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
        return response()->json($bill, 200);
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
