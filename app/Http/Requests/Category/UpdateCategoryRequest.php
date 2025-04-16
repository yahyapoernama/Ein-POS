<?php

namespace App\Http\Requests;

use App\Http\Traits\ValidationRules\CategoryValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    use CategoryValidationRules;
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // PHPDoc for $this->route() to help Intelephense understand it's available
        /** @var \Illuminate\Http\Request $this */
        $categoryId = $this->route('category'); // Retrieve route parameter {category}

        return $this->updateRules($categoryId);
    }
}
