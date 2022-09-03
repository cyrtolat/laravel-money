<?php

namespace Cyrtolat\Money\Facades;

use Cyrtolat\Money\MoneyService;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Cyrtolat\Money\MoneyService
 */
class Money extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return MoneyService::class;
    }
}
