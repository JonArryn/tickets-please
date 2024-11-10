<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

abstract class QueryFilter
{
    protected Builder $builder;
    protected Request $request;
    protected array $sortable = [
        'updatedAt' => 'updated_at',
        'createdAt' => 'created_at'
    ];

    public function __construct(Request $request) {
        $this->request = $request;
    }

    protected function filter($arr): Builder { // <-- I don't know how this method gets called or why it works!

        foreach ($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }
        return $this->builder;
    }

    public function apply(Builder $builder): Builder {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $builder;
    }

    protected function sort($value): void {
        $sortAttributes = explode(',', $value);

        foreach ($sortAttributes as $attribute) {
            $direction = 'asc';

            if (str_starts_with($attribute, '-')) {
                $direction = 'desc';
                $attribute = substr($attribute, 1);
            }

            if (! in_array($attribute, $this->sortable) && ! array_key_exists($attribute, $this->sortable)) {
                continue;
            }

            $columnName = $this->sortable[$attribute] ?? null;

            if ($columnName === null) {
                $columnName = $attribute;
            }

            $this->builder->orderBy($columnName, $direction);
        }
    }
}
