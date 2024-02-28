<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\PotentiallyTranslatedString;

class UniqueTranslation implements ValidationRule
{
    protected $table;
    protected $column;
    protected $ignoreId = null;
    protected $idColumn = 'id';

    /**
     * Create a new rule instance.
     *
     * @param string $table The database table name
     * @param string $column The JSON column name to search for the value
     * @param mixed $ignoreId The ID of the record to ignore (useful for updates)
     * @param string $idColumn The name of the ID column, defaults to 'id'
     */
    public function __construct(string $table, string $column, $ignoreId = null, string $idColumn = 'id')
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignoreId = request('id_unique') ?? null;
        $this->idColumn = $idColumn;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure(string): void  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $query = DB::table($this->table)
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT($this->column, '$.*')) LIKE ?", ["%$value%"]);

        // If an ignore ID is provided, exclude it from the query
        if (!is_null($this->ignoreId)) {
            $query->where($this->idColumn, '!=', $this->ignoreId);
        }

        $exists = $query->exists();

        if ($exists) {
            $fail('The :attribute has already been taken.');
        }
    }
}
