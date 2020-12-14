<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CardRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Rule::unique('columns', 'title')->ignore($user->id);
        return [
            'title' => ['required', Rule::unique('cards', 'title')
                    ->where('columns_id', $this->input('columns_id'))],
            'description' => ['required'],
            'columns_id' => ['required']
        ];
    }
}
