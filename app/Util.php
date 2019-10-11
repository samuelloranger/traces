<?php

declare(strict_types=1);

namespace App;

use NumberFormatter;

class Util {

    public static function couperParagraphe(string $paragraphe, int $nombreMax = 800):string {
        $string = strip_tags($paragraphe);
        if (strlen($string) > $nombreMax) {

            // truncate string
            $stringCut = substr($string, 0, $nombreMax);
            $endPoint = strrpos($stringCut, '.');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '...';
        }
        return $string;
    }

    public static function validerISBN(string $isbn):bool {
        $isbnValide = false;

        if(preg_match("#^[0-9]\-[0-9]{5}\-[0-9]{3}\-[0-9]$#", $isbn) || preg_match("#^[0-9]\-[0-9]{6}\-[0-9]{2}\-[0-9]$#", $isbn)){
            $isbnValide = true;
        }

        return $isbnValide;
    }

    public static function formaterArgent(float $prix):string{
        $moneyFormatter = new NumberFormatter('fr_CA', NumberFormatter::CURRENCY);
        $prixFormate = $moneyFormatter->formatCurrency($prix, "CAD");
        return $prixFormate;
    }
}