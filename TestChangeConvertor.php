<?php

include 'ChangeConvertor.php';

class TestChangeConvertor 
{
    public function test() {
        echo '<br>' . '===================TESTS====================' . '<br>';
        $changeConvertor = new ChangeConvertor();
        for ($i = 0 ; $i < 10; $i++) {
            // On va arbitrairement jusqu'à 999€ en somme à rendre
            $amount = rand(0, 99900);
            echo '============================================' . '<br>';
            // En divisant $amount par 100, on affiche une nombre à virgule compréhensible pour l'utilisateur
            // Sans cette division, l'affichage se fait en centimes jusqu'à 5 chiffres.
            echo '<br>' . '<b>Montant à rendre</b> : ' . ($amount/100) . ' €' . '<br>';
            try {
                $change = $changeConvertor->getChange($amount);
                
                foreach ($change as $value => $number) {
                    echo '<pre>';
                    echo 'Coupure : ' . ($value/100) . '€' . ' => Quantité : ' . $number;
                    echo '</pre>';
                }
                // $check permet de vérifier que la monnaie rendue est bien égale à la somme à rendre de départ
                $check = 0;
                foreach ($change as $value => $number) {
                    $check += ($value * $number);
                }
                if ($check !== $amount) {
                    echo
                        "\t" . 'ECHEC : ' .
                        $amount . ' => ' . $check .
                        '<br>';
                } else {
                    echo 'MONTANT RENDU : ' . ($amount/100) . ' €' . '<br>';
                }
            } catch (Exception $exception) {
                echo "ERREUR : Monnaie insuffisante\n" . '<br>';
            }
        }
    }
    
}

$testChangeConvertor = new TestChangeConvertor();
$testChangeConvertor->test();
