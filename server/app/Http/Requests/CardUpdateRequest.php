<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CardUpdateRequest extends FormRequest
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

    public function rules()
    {
        // Rule::unique('columns', 'title')->ignore($user->id);
        return [
            'title' => ['required', Rule::unique('cards', 'title')
                ->where('columns_id', $this->input('columns_id'))
                ->ignore($this->input('id'))],
            'description' => ['required'],
            'columns_id' => ['required'],
            'id' => ['required'],
        ];
    }
}
