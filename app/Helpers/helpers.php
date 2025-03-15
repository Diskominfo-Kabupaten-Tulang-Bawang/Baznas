<?php

if (! function_exists('moneyFormat')) {
    /**
     * moneyFormat
     *
     * @param  mixed $str
     * @return void
     */
    function moneyFormat($str) {
        if (is_numeric($str)) {
            return 'Rp. ' . number_format($str, 0, '', '.');
        }
        return 'Rp. 0';
    }
}
