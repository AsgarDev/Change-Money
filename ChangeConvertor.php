<?php

class ChangeConvertor
{
    /* === On déclare notre tableau de valeurs indiquant combien de pièces/billets sont
    disponibles pour chaque valeur en centimes (Ex: Il y a 18 pièces de 10 centimes disponibles) */
    private $changes = [
        1     => 25,
        2     => 74,
        5     => 14,
        10    => 18,
        20    => 0,
        50    => 5,
        100   => 30,
        200   => 15,
        500   => 8,
        1000  => 11,
        2000  => 8,
        5000  => 5,
        10000 => 2,
        20000 => 0,
        50000 => 0
    ];
    /**
     * @return array
     */
    public function getAvailableChange() {
        return $this->changes;
    }
    public function __construct(array $changes = null)
    {
        if ($changes !== null) {
            $this->changes = $changes;
        }
        // On inverse l'ordre de tri du tableau associatif tout en préservant la correspondance clés/valeurs
        // Car nous cherchons toujours à trouver la valeur maximale la plus proche de la somme à rendre donc il est intéressant de parcourir le tableau à partir des indexs les plus forts
        krsort($this->changes);
    }
    /**
     * @param integer $amount
     * @return array
     */
    public function getChange($amount)
    {
        $remaining = $amount;
        $changes = [];
        // Pour chaque association clé/valeur, on stocke dans $change[$value] le nombre à rendre correspondant à la monnaie
        foreach (array_keys($this->changes) as $value) {
            $changeReturned = $this->getNumberOfChangeValue($remaining, $value);
            if ($changeReturned) {
                $changes[$value] = $changeReturned;
            }
            $remaining -= ($changeReturned * $value);
        }
        if ($remaining > 0) {
            throw new Exception('Impossible de rendre la monnaie');
        }
        return $changes;
    }
    /**
     * @param integer $amount
     * @param integer $value
     * @return integer
     */
    private function getNumberOfChangeValue($amount, $value)
    {
        // On divise le montant à rendre par la valeur de la monnaie et on retourne la valeur minimale entre le résultat et la quantité de monnaie disponible en stock
        $availableChange = $this->changes[$value];
        return min(intdiv($amount, $value), $availableChange);
    }
}