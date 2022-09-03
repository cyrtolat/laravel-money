<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Money Locale
     |--------------------------------------------------------------------------
     |
     | Todo desc..
     |
     */

    'locale' => config('app.locale', 'en_US'),

    /*
     |--------------------------------------------------------------------------
     | Currency storage
     |--------------------------------------------------------------------------
     |
     | Todo desc..
     |
     */

    'storage' => \Cyrtolat\Money\Storages\DefaultMoneyStorage::class,

    /*
     |--------------------------------------------------------------------------
     | Money Serializer
     |--------------------------------------------------------------------------
     |
     | Todo desc..
     |
     */

    'serializer' => \Cyrtolat\Money\Serializers\MajorMoneySerializer::class,

    /*
     |--------------------------------------------------------------------------
     | Money Formatter
     |--------------------------------------------------------------------------
     |
     | Todo desc..
     |
     */

    'formatter' => \Cyrtolat\Money\Formatters\DefaultMoneyFormatter::class

];
