<?php

namespace App\Http\Requests;

use App\Models\TrainingModel;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainingRequest extends FormRequest
{
    public function authorize(): bool
    {
        $id = $this->route('id');
        return TrainingModel::where('id', $id)->exists();
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
