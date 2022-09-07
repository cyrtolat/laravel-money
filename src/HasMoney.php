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

        $value = $caster->set($this, $column, $money, $this->attributes);

        return $builder->where($column, $operator, $value[$column]);
    }
}