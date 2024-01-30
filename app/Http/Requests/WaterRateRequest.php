<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WaterRateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'price' => 'required|numeric|regex:/^\s*\d+(\.\d{1,2})?\s*$/',
        ];

        /**
         * 'price' should be:
         * - Required: Must be present in the input data.
         * - Numeric: Must be a numeric value.
         * - Regex: Should match the pattern:
         *    - Optional leading and trailing whitespace (\s*),
         *    - Followed by one or more digits (\d+),
         *    - Optionally followed by a dot and one or two digits (\.\d{1,2}) for a decimal part,
         *    - Ending with optional whitespace (\s*).
         * This validates 'price' as a numeric value with up to two decimal places and allows optional spaces.
         */
    }
}
