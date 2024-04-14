<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
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
            'title' => 'required|max:255',
            'body' => 'required',
            'published_date' => 'required|date',
            'author' => 'required|exists:users,id',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'published_date' => now()->toDateTimeString(),
            'author' => Auth::id(),
        ]);
    }
}
