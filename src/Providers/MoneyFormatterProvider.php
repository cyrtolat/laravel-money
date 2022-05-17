<?php

namespace Cyrtolat\Money\Providers;

use Cyrtolat\Money\Contracts\MoneyFormatterContract;

/**
 * The Formatter provider
 */
final class MoneyFormatterProvider
{
    /**
     * @var MoneyFormatterProvider|null
     */
    private static $instance;

    /**
     * Returns the singleton instance of MoneyFormatterProvider.
     *
     * @return MoneyFormatterProvider
     */
    public static function getInstance(): MoneyFormatterProvider
    {
        if (self::$instance === null) {
            self::$instance = new MoneyFormatterProvider();
        }

        return self::$instance;
    }

    /**
     * Returns an instance of the Money Formatter class.
     *
     * @return MoneyFormatterContract
     */
    public function getFormatter(): MoneyFormatterContract
    {
        $formatterClass = config('money.formatter');

        return new $formatterClass();
    }
}
