<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['sometimes', 'nullable', Rule::exists(Category::class, 'id')]
        ];
    }
}
