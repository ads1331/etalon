<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SomeRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
           'user.first_name' => 'required|string|max:255',
            'user.last_name' => 'required|string|max:255',
            'user.notes' => 'nullable|string',
            'phone.*.number' => 'required|string',
            'phone.*.type' => 'required|string',
            'emails.*.email' => 'required|email',
            'emails.*.type' => 'required|string',
            'links.*.link' => 'required|url',
            'links.*.type' => 'required|string',
            'dates.*.date' => 'required|date',
            'dates.*.type' => 'required|string',
            'companies.*.name' => 'required|string',
            'companies.*.address' => 'required|string',
        ];
    }
}
