<?php

declare(strict_types=1);

namespace App;

class Util {

    public static function couperParagraphe(string $paragraphe, int $nombreMax = 800):string {
        $string = strip_tags($paragraphe);
        if (strlen($string) > $nombreMax) {

            // truncate string
            $stringCut = substr($string, 0, $nombreMax);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '...';
        }
        return $string;
    }
}