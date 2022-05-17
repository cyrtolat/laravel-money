<?php

namespace Cyrtolat\Money\Traits\Money;

use Cyrtolat\Money\Providers\MoneySerializerProvider;

/**
 * The Money serialization trait.
 */
trait HasSerialization
{
    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $provider = MoneySerializerProvider::getInstance();
        $serializer = $provider->getSerializer();

        return $serializer->toArray($this);
    }

    /**
     * {@inheritdoc}
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
