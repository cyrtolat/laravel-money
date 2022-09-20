<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Default Currency
     |--------------------------------------------------------------------------
     |
     | The default currency. Some applications work with only one currency, so it
     | is advisable for them to set it once in one place. This value is used in
     | some helper functions. Be careful that the specified currency is contained
     | in your currency storage.
     |
     */

    'currency' => 'USD',

    /*
     |--------------------------------------------------------------------------
     | Money Locale
     |--------------------------------------------------------------------------
     |
     | A string containing the BCP 47 language tag. It defines the style of
     | formatting monetary values according to the selected locale and is used
     | inside formatters by the Intl.NumberFormat objects.
     |
     */

    'locale' => 'en_US',

    /*
     |--------------------------------------------------------------------------
     | Currency Storage
     |--------------------------------------------------------------------------
     |
     | A string containing the implementation of a CurrencyStorage contract.
     | It is a repository that contains all the currency data of your application.
     | By default, it includes all the currencies of the ISO-4217 standard, as well
     | as some existing cryptocurrencies. If your application requires currencies
     | that it does not have, then you can write your own storage to use it instead.
     |
     */

    'storage' => \Cyrtolat\Money\Storages\IsoCurrencyStorage::class,

    /*
     |--------------------------------------------------------------------------
     | Money Serializer
     |--------------------------------------------------------------------------
     |
     | A string containing the implementation of a CurrencySerializer contract.
     | This is a class that is responsible for converting Money objects into
     | arrays and JSON strings in your application's HTTP responses. They are
     | not related to how Money will be converted for storage in the DB.
     |
     */

    'serializer' => \Cyrtolat\Money\Serializers\MajorMoneySerializer::class,

    /*
     |--------------------------------------------------------------------------
     | Money Formatter
     |--------------------------------------------------------------------------
     |
     | A string containing the implementation of a CurrencyFormatter contract.
     | This is the class that is responsible for rendering Money objects into
     | strings. Formatters are not associated with HTTP responses and perform
     | their own function.
     |
     */

    'formatter' => \Cyrtolat\Money\Formatters\DecimalMoneyFormatter::class,

];
