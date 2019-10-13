<?php

declare(strict_types=1);

namespace App;

use NumberFormatter;

class Util {

    /**
     * @method couperParagraphe
     * @desc Coupe le paragraphe envoyé en argument
     * @param string $paragraphe - Paragraphe à couper au besoin
     * @param int $nombreMax - Nombre maximum - Valeur not-set à 800
     * @return string - Paragraphe coupé
     */
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


    /*
    * @method ISBNToEAN
    * @desc Convertit un ISBN en format EAN
    * @param string - ISBN à convertir
    * @return string - ISBN converti en EAN, ou FALSE si erreur dans le format ou la conversion
    */
    public static function ISBNToEAN($strISBN)
    {
        $myFirstPart = $mySecondPart = $myEan = $myTotal = "";
        if ($strISBN == "")
            return false;

        $strISBN = str_replace("-", "", $strISBN);
        // ISBN-10
        if (strlen($strISBN) == 10) {
            $myEan = "978" . substr($strISBN, 0, 9);
            $myFirstPart = intval(substr($myEan, 1, 1)) + intval(substr($myEan, 3, 1)) + intval(substr($myEan, 5, 1)) + intval(substr($myEan, 7, 1)) + intval(substr($myEan, 9, 1)) + intval(substr($myEan, 11, 1));
            $mySecondPart = intval(substr($myEan, 0, 1)) + intval(substr($myEan, 2, 1)) + intval(substr($myEan, 4, 1)) + intval(substr($myEan, 6, 1)) + intval(substr($myEan, 8, 1)) + intval(substr($myEan, 10, 1));
            $tmp = intval(substr((string)(3 * $myFirstPart + $mySecondPart), -1));
            $myControl = ($tmp == 0) ? 0 : 10 - $tmp;
            return $myEan . $myControl;
        } // ISBN-13
        else if (strlen($strISBN) == 13){
            return $strISBN;
        }
        // Autres
        else return false;
    }


    /**
     * @method validerISBN
     * @desc Valide le ISBN envoyé en argument
     * @param string $isbn - est le isbn à valider
     * @return bool
     */
    public static function validerISBN(string $isbn):bool {
        $isbnValide = false;

        if(preg_match("#^[0-9]\-[0-9]{6}\-[0-9]{2}\-[0-9]$#", $isbn) || preg_match("#^[0-9]-[0-9]{5}-[0-9]{3}-[0-9]$#", $isbn)){
            $isbnValide = true;
        }

        return $isbnValide;
    }


    /**
     * @method formaterArgent
     * @param float $prix - Montant d'argent à formater
     * @return string - retourne le montant d'argent formater
     */
    public static function formaterArgent(float $prix):string{
//        $moneyFormatter = new NumberFormatter('fr_CA', NumberFormatter::CURRENCY);
//        $prixFormate = $moneyFormatter->formatCurrency($prix, "CAD");

        $prixFormate = number_format($prix, 2) . " $";
        return $prixFormate;
    }
}