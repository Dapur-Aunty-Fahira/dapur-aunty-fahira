<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    use ApiResponse;
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
        // Determine method or route action
        $method = $this->method();

        $userId = $this->input('id') ?? null;
        // only used on update


        switch ($method) {
            case 'POST': // Create
                return [
                    'name' => 'required|string|max:60',
                    'email' => 'required|string|email|max:60|unique:users,email',
                    'password' => 'required|string|min:6|confirmed',
                    'role' => 'required|in:admin,pelanggan,kurir',
                    'phone' => 'nullable|string|max:20',
                ];

            case 'PUT':
            case 'PATCH': // Update
                return [
                    'id' => 'required|integer',
                    'name' => 'sometimes|required|string|max:60',
                    'email' => 'sometimes|required|string|email|max:60|unique:users,email,' . $userId,
                    'password' => 'nullable|string|min:6|confirmed',
                    'role' => 'required|in:admin,pelanggan,kurir',
                    'phone' => 'nullable|string|max:20',
                ];
            default:
                return []; // Usually no validation for show/edit/delete
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role harus salah satu dari: admin, pelanggan, atau kurir.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->validationError($validator->errors()));
    }


}
