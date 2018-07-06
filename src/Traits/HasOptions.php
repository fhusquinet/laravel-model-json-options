<?php

namespace FHusquinet\ModelOptions\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasOptions
{

    public function __construct(array $attributes = []) {
        $this->casts = array_merge($this->casts, ['options' => 'array']);
        parent::__construct($attributes);
    }

    public function getOption($key, $default = null)
    {
        return data_get($this->options, $key, $default);
    }

    public function setOption($key, $value = null)
    {
        if ( is_array($key) ) {
            return $this->setOptions($key);
        }

        if ( $this->options ) {
            return $this->options = array_merge($this->options, [$key => $value]);
        }
        return $this->options = [$key => $value];
    }

    public function setOptions($options)
    {
        foreach ( $options as $key => $value ) {
            $this->setOption($key, $value);
        }
    }

    public function scopeWhereOption(Builder $query, $key, $value)
    {
        return $query->where('options->'.$key, $value);
    }

    public function scopeWhereOptionNot(Builder $query, $key, $value)
    {
        return $query->where(function ($subQuery) use ($key, $value) {
            $subQuery->whereNull('options->'.$key)
                     ->orWhere('options->'.$key, '!=', $value);
        });
    }

}