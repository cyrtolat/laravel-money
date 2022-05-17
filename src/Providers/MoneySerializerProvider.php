<?php

namespace Cyrtolat\Money\Providers;

use Cyrtolat\Money\Contracts\MoneySerializerContract;

/**
 * The Serializer provider
 */
final class MoneySerializerProvider
{
    /**
     * @var MoneySerializerProvider|null
     */
    private static $instance;

    /**
     * Returns the singleton instance of MoneySerializerProvider.
     *
     * @return MoneySerializerProvider
     */
    public static function getInstance(): MoneySerializerProvider
    {
        if (self::$instance === null) {
            self::$instance = new MoneySerializerProvider();
        }

        return self::$instance;
    }

    /**
     * Returns an instance of the Money Serializer class.
     *
     * @return MoneySerializerContract
     */
    public function getSerializer(): MoneySerializerContract
    {
        $serializerClass = config('money.serializer');

        return new $serializerClass();
    }
}
