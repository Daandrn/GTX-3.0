<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecruitRequest extends FormRequest
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
        $rules = [
            'nome_recrut'       => 'required|alpha|min:3|max:50',
            'nick_recrut'       => 'required|alpha_num|min:3|max:20',
            'plataforma_recrut' => 'required|numeric',
        ];
        
        return $rules;
    }
}
