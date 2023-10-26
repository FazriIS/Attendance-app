<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable','max:255'],
            'foto_karyawan' => ['image','file','max:10240'],
            'email' => ['nullable','email:dns', 'unique:users'],
            'telepon' => ['nullable'],
            'username' => ['nullable','max:255','unique:users'],
            'password' => ['nullable', 'min:6', 'max:255'],
            'tgl_lahir' => ['nullable'],
            'gender' => ['nullable'],
            'status_nikah' => ['nullable'],
            'alamat' => ['nullable'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag()
        ], 400));
    }
}
