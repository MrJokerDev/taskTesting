<?php

namespace App\Http\Requests;

use App\Rules\DateFormat;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'status'      => 'required|string|in:active,inactive,expired',
            'deadline'    => ['required', 'string', new DateFormat()],
        ];
    }

}
