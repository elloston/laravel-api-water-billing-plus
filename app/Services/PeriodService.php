<?php

namespace App\Services;

use App\Models\Period;
use Illuminate\Support\Carbon;

class PeriodService
{
    protected function validateDateFormat($date)
    {
        // Validate the date format using Carbon
        try {
            return Carbon::parse($date)->setTimezone('UTC');
        } catch (\Exception $e) {
            // Throw a custom exception on validation failure
            throw new \InvalidArgumentException('Invalid date format', 400);
        }
    }

    public function findOrCreatePeriod($date)
    {
        // Validate the date format
        $validatedDate = $this->validateDateFormat($date);

        $period = Period::firstOrCreate(
            [
                'begin_date' => $validatedDate->startOfMonth(),
                'end_date' => $validatedDate->endOfMonth(),
            ],
        );

        return $period;
    }
}
