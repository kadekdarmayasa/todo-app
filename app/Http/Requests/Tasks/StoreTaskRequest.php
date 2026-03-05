<?php

namespace App\Http\Requests\Tasks;

use App\Enums\PriorityEnum;
use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * Class StoreTaskRequest
 * Handles validation and authorization for creating a new task.
 *
 * @package App\Http\Requests\Tasks
 */
class StoreTaskRequest extends FormRequest
{
    /**
     * All authenticated users can create tasks.
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => ['required', new Enum(PriorityEnum::class)],
            'status' => ['required', new Enum(StatusEnum::class)],
            'due_date' => 'nullable|date|after_or_equal:today',
        ];
    }

    /**
     * Get custom error messages for validation failures.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul task wajib diisi.',
            'title.string' => 'Judul task harus berupa teks.',
            'title.max' => 'Judul task tidak boleh lebih dari 255 karakter.',

            'description.string' => 'Deskripsi task harus berupa teks.',

            'priority.required' => 'Prioritas task wajib diisi.',
            'priority.enum' => 'Prioritas task tidak valid. Pilih opsi yang tersedia.',

            'status.required' => 'Status task wajib diisi.',
            'status.enum' => 'Status task tidak valid. Pilih opsi yang tersedia.',

            'due_date.date' => 'Tanggal jatuh tempo harus berupa tanggal yang valid.',
            'due_date.after_or_equal' => 'Tanggal jatuh tempo harus hari ini atau di masa depan.',
        ];
    }
}
