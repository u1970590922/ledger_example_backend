<?php

namespace App\Http\Requests\Finance;

use App\Enums\Finance\LedgerType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LedgerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'source_id' => ['sometimes', 'required', 'integer', 'exists:ledgers,id'],
            'type' => ['required', 'integer', Rule::in(enum_values(LedgerType::class))],
            'amount' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'max:1000']
        ];

        if ($this->isMethod('PATCH')) {
            array_unshift($rules['type'], 'sometimes');
            array_unshift($rules['amount'], 'sometimes');
        }

        return $rules;
    }
}
