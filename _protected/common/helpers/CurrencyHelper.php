<?php
/**
 * Created by PhpStorm.
 * User: ManTran
 * Date: 7/13/2015
 * Time: 11:57 AM
 */

namespace common\helpers;

/**
 * Class CurrencyHelper
 * @package backend\modules\temp\helpers
 */
class CurrencyHelper {

    /**
     * @param float $number
     * @return string
     */
    public static function formatNumber($number) {
        return number_format($number, 0, ',', '.') . 'đ';
    }

    public static function toNumber($string) {
        if(empty($string))
            return 0;
        return preg_replace('|[^0-9]|i', '', $string);
    }
}