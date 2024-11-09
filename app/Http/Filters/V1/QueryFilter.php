<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

abstract class QueryFilter
{
    protected $builder;
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    protected function filter($arr) { // <-- I don't know how this method gets called or why it works!
        Log::info('Reached filter method', ['request' => $arr]);

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
}
