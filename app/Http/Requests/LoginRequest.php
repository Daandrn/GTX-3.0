<?php

namespace App\Http\Requests;

use App\Models\Membro;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $isBanedOrRejected = Membro::where('nick', '=', $this->nick_login)
                                ->wherein('status_solicit', [2, 3])
                                ->get('id');

        if ($isBanedOrRejected->isEmpty()) {
            return true;
        }
        
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'nick_login' => 'required|alpha_num|min:3|max:20',
            'senha_login' => 'required|min:8|string',
        ];
        
        return $rules;
    }
}
