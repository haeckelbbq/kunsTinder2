<?php


class Format
{
    //Um die Daten in deutsche Format zu haben
        public static function deutscheZeitformat(string $datum) : string
    { // '2014-12-25 explode => array('2014', '12', '25'), Trenner ist "-"
        $datumArray = explode('-', $datum);
        // array_reverse dreht die Reihenfolge der Elemente im Array um
        // => array('25', '12', '2014')
        $datumArrayUmgekehrt = array_reverse($datumArray);
        //implode => '25.12.2014' mit "." als Trenner
        $datumDeutsch = implode('.', $datumArrayUmgekehrt);
        return $datumDeutsch;
    }

}