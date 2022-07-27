<?php

/**
 * La fonction `foo()` prend en paramètre **n** tableaux de 2 nombres entiers, chaque tableau représente un intervalle de valeurs.
 * Ces intervalles sont ordonnés par ordre croissant. Puis une fois triées, les intervalles qui se chevauchent sont fusionnés entre eux.
 *
 * La fonction renvoie les intervalles qui résultent de cette opération, ainsi que ceux qui ne se chevauchent pas.
 *
 * @param array $intervals Les intervalles à traiter
 * @return array Renvoie les intervalles fusionnés et non fusionnés.
 * @throws Exception
 */
function foo(array ...$intervals) :array
{
    usort($intervals, function ($a, $b) { return $a[0] > $b[0]; });

    // Fusion des intervalles
    $result = array();
    $fIndex = 0;
    for($i = 0; $i < count($intervals); $i++) {
        if(count($intervals[$i]) !== 2) {
            throw new Exception("Les tableaux d'intervalles doivent avoir 2 valeurs");
        }
        if(!is_int($intervals[$i][0]) || !is_int($intervals[$i][1])) {
            throw new Exception("Les valeurs des tableaux d'intervalles doivent être des entiers");
        }

        // Si l'intervalle de fusion chevauche l'intervalle courant, on le fusionne
        if(isset($result[$fIndex]) && $result[$fIndex][1] >= $intervals[$i][0]) {
            $result[$fIndex][1] = max($result[$fIndex][1], $intervals[$i][1]);
        } else {
            $result[] = $intervals[$i];
            $fIndex = count($result) - 1;
        }
    }

    return $result ?? [];
}

/**
 * Convertit un tableau d'intervalles en une chaîne de caractères.
 *
 * @param array $intervals
 * @return void
 */
function print_intervals(array $intervals) :void
{
    $res = "";
    foreach($intervals as $interval) {
        $res .= "[{$interval[0]}, {$interval[1]}] ";
    }
    echo $res.PHP_EOL;
}

try {
    $tests = array(
        [ [0, 3], [6, 10] ],
        [ [0, 5], [3, 10] ],
        [ [0, 5], [2, 4] ],
        [ [7, 8], [3, 6], [2, 4] ],
        [ [3, 6], [3, 4], [15, 20], [16, 17], [1, 4], [6, 10], [3, 6] ]
    );

    // Jeux de tests
    foreach ($tests as $test) {
        print_intervals(foo(...$test));
    }
} catch (Exception $e) {
    echo $e->getMessage().PHP_EOL;
}
