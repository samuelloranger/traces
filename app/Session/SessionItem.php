<?php
declare(strict_types=1);

namespace App\Session;

use App\Modeles\Livre;
use App\Util;

class SessionItem
{
    private $livre = null;
    private $format = "";
    private $quantite = 0;

    public function __construct(Livre $unLivre, string $format, int $uneQte)
    {
        // À faire...
        $this->livre = $unLivre;
        $this->format = $format;
        $this->quantite = $uneQte;
    }

    // Retourne le montant total d'un item (prix x quantité)
    public function getMontantTotal(): float
    {
        return floatval($this->livre->prix) * intval($this->quantite);
    }

    public function getMontantTotalFormate():string{
        return Util::formaterArgent($this->getMontantTotal());
    }

    // Getter / Setter (magique)
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}