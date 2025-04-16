<?php

namespace App\Http\Traits\ValidationRules;

use App\Rules\UniqueSoftDeleteRule;

trait CategoryValidationRules
{
    /**
     * Get base validation rules for category.
     *
     * @return array
     */
    public function baseRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:65535'],
        ];
    }

    /**
     * Get validation rules for storing category.
     *
     * @return array
     */
    protected function storeRules(): array
    {
        return array_merge($this->baseRules(), [
            'name' => [new UniqueSoftDeleteRule('categories', 'name')],
            'slug' => [new UniqueSoftDeleteRule('categories', 'slug')],
        ]);
    }

    /**
     * Get validation rules for updating category.
     *
     * @param int $id
     * @return array
     */
    protected function updateRules($id): array
    {
        return array_merge($this->baseRules(), [
            'name' => [new UniqueSoftDeleteRule('categories', 'name', $id)],
            'slug' => [new UniqueSoftDeleteRule('categories', 'slug', $id)],
        ]);
    }

    /**
     * Check if data has changed before updating.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $model
     * @param array $fields
     * @return bool
     */
    public function hasDataChanged($request, $model, $fields)
    {
        foreach ($fields as $field) {
            if ($model->$field != $request->$field) {
                return true; // There is a change
            }
        }
        return false; // No change detected
    }

    /**
     * Return a response if no data has changed.
     *
     * @return \Illuminate\Http\Response
     */
    public function noChangeResponse()
    {
        return response()->json(['message' => 'No columns were changed.'], 400);
    }
}
