<?php

if (! function_exists('format_number')) {
    /**
     * Retorna valor em formato decimal. Ex: 1.234.567,89
     *
     * @param $value
     * @param string $locale
     * @return string
     */
    function format_number($value, $locale = 'pt_BR')
    {
        return (new NumberFormatter($locale, NumberFormatter::DECIMAL))->format($value);
    }
}

if (! function_exists('parse_number')) {
    /**
     * Retorna valor em formato float. Ex: 1234567.89
     *
     * @param $value
     * @param string $locale
     * @return float
     */
    function parse_number($value, $locale = 'pt_BR')
    {
        return (new NumberFormatter($locale, NumberFormatter::DECIMAL))->parse($value);
    }
}

if (! function_exists('format_money')) {
    /**
     * Retorna valor em formato decimal com a moeda. Ex: R$ 1.234.567,89
     *
     * @param $value
     * @param string $locale
     * @return string
     */
    function format_money($value, $locale = 'pt_BR')
    {
        return (new NumberFormatter($locale, NumberFormatter::CURRENCY))->format($value);
    }
}

if (! function_exists('parse_money')) {
    /**
     * Retorna valor com moeda em formato float. Ex: 1234567.89
     *
     * @param $value
     * @param string $locale
     * @return mixed
     */
    function parse_money($value, $locale = 'pt_BR')
    {
        return (new NumberFormatter($locale, NumberFormatter::CURRENCY))->parse($value);
    }
}