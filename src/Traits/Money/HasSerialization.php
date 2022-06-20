<?php

namespace Cyrtolat\Money\Traits\Money;

use Cyrtolat\Money\Providers\MoneySerializerProvider;

/**
 * The Money serialization trait.
 */
trait HasSerialization
{
    /** {@inheritdoc} */
    public function toArray(): array
    {
        $provider = MoneySerializerProvider::getInstance();
        $serializer = $provider->getSerializer();

        return $serializer->toArray($this);
    }

    /** {@inheritDoc} */
    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    /** {@inheritDoc} */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
