<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueSoftDeleteRule implements ValidationRule
{
    protected string $table;
    protected string $column;
    protected ?int $ignoreId;

    /**
     * Constructor
     *
     * @param string $table        Table name
     * @param string $column       Column to validate
     * @param int|null $ignoreId   ID to ignore (for update)
     */
    public function __construct(string $table, string $column, ?int $ignoreId = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignoreId = $ignoreId;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  \Closure(string): void  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table($this->table)
            ->where($this->column, $value)
            ->whereNull('deleted_at');

        if ($this->ignoreId !== null) {
            $query->where('id', '!=', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail("The $attribute has already been taken.");
        }
    }
}
