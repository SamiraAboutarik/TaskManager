<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status'      => ['required', 'in:todo,in_progress,done'],
            'due_date'    => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.min'      => 'Le titre doit contenir au moins 3 caractères.',
            'title.max'      => 'Le titre ne peut pas dépasser 255 caractères.',
            'status.required'=> 'Le statut est obligatoire.',
            'status.in'      => 'Le statut doit être : À faire, En cours ou Terminé.',
            'due_date.date'  => 'La date d\'échéance doit être une date valide.',
        ];
    }
}
