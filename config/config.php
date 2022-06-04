<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Money Locale
     |--------------------------------------------------------------------------
     |
     | The money locale determines the default locale that will be used by the
     | formatting of instances of Money class to string. In particular, some
     | formatters use this value. You are free to set it any of the locales
     | which will be supported by the package.
     |
     */

    'locale' => config('app.locale', 'en_US'),

    /*
     |--------------------------------------------------------------------------
     | Money Serializer class
     |--------------------------------------------------------------------------
     |
     | The money serializer class determine how the instance of Money class will
     | be converted to array and json. This is necessary, for example, in the
     | API Resources classes. Specify here the class of one of the ready-made
     | serializers or write your own. But remember that a custom serializer
     | must implement MoneySerializerContract of this package.
     |
     */

    'serializer' => \Cyrtolat\Money\Serializers\MoneyIntegerSerializer::class,

    /*
     |--------------------------------------------------------------------------
     | Money Formatter class
     |--------------------------------------------------------------------------
     |
     | The Money formatter class determine how an instance of the Money class
     | will be converted to a string. Explicitly using the appropriate method and
     | implicitly using the php magic method. Specify here the class of one of
     | the ready-made formatters or write your own. But remember that a custom
     | formatter must implement MoneyFormatterContract of this package.
     |
     */

    'formatter' => \Cyrtolat\Money\Formatters\MoneyDecimalFormatter::class,

];
