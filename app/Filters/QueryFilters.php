<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilters
{
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $name => $value) {
            if (!method_exists($this, $name)) {
                continue;
            }
            if (strlen($value)) {
                $this->$name($value);
            } else {
                $this->$name();
            }
        }

        if ($this->request->query('sort')) {
            $attribute = $this->request->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $this->builder->orderBy($attribute, $sort_order);
        } else {
            $this->builder->latest();
        }

        return $this->builder->paginate($this->request['per_page'] == -1
            ? 999999
            : $this->request['per_page'] ?? 5)
            ->onEachSide(2)->appends($this->request->query());
    }

    public function filters()
    {
        return $this->request->all();
    }
}