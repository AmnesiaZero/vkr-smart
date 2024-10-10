<?php

namespace App\Helpers;

class DateHelper
{
    /**
     * Конвертирует дату из unix time в указанный формат
     *
     * @param string $format
     * @param int|null $unixtime
     * @return string
     */
    public static function format(string $format, $unixtime): string
    {
        if (!$unixtime) {
            return '';
        }
        return trim(date($format, $unixtime));
    }

    public static function get_month_name($id)
    {
        if (!$id || $id <= 0) {
            return "error";
        }

        switch ($id) {
            case '1':
                return 'января';
                break;
            case '2':
                return 'февраля';
                break;
            case '3':
                return 'марта';
                break;
            case '4':
                return 'апреля';
                break;
            case '5':
                return 'мая';
                break;
            case '6':
                return 'июня';
                break;
            case '7':
                return 'июля';
                break;
            case '8':
                return 'августа';
                break;
            case '9':
                return 'сентября';
                break;
            case '10':
                return 'октября';
                break;
            case '11':
                return 'ноября';
                break;
            case '12':
                return 'декабря';
                break;

            default:
                // code...
                break;
        }
    }
}
