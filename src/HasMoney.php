<?php

namespace Cyrtolat\Money;

use Illuminate\Database\Eloquent\Builder;

trait HasMoney
{
    /**
     * Contains a query area with models with the
     * specified monetary attribute value.
     *
     * @param Builder $builder
     * @param string $column
     * @param mixed $operator
     * @param Money $money
     * @return Builder
     */
    public function scopeWhereMoney(
        Builder $builder, string $column, string $operator, Money $money): Builder
    {
        if (! $this->hasCast($column)) {
            return $builder->where($column, $operator, $money->getAmount());
        }

        $caster = $this->resolveCasterClass($column);
        $result = $caster->set($this, $column, $money, $this->attributes);

        foreach ($result as $key => $value) {
            if ($key == $column) {
                $builder = $builder->where($key, $operator, $value);
            } else {
                $builder = $builder->where($key, '=', $value);
            }
        }

        return $builder;
    }
}