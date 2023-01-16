<?php

namespace App\Composer\Core\Model;


class Zadania
{
    public $id_zad;
    public $numer_zad;
    public $pol_zad;
    public $czas_zad;
    public $data_zad;
    public $stan_zad;

    public function __construct(
        $id_zad,
        $numer_zad,
        $pol_zad,
        $data_zad,
        $czas_zad,
        $stan_zad
    ) {
        $this->id_zad = $id_zad;
        $this->numer_zad = $numer_zad;
        $this->pol_zad = $pol_zad;
        $this->czas_zad = $czas_zad;
        $this->data_zad = $data_zad;
        $this->stan_zad = $stan_zad;
    }

    //Wypisywanie zawartości bazy danych
    function wypisz()
    {
        if ($this->numer_zad % 2 == 0) {
            $classname = "parz";
        } else {
            $classname = "nieparz";
        }
        echo "<tr class='$classname' id='$this->numer_zad'name=zad_'$this->id_zad' value='$this->id_zad'>";
        echo "<td class='nr'>$this->numer_zad</td>
                 <td class='zadanie'>$this->pol_zad</td>
                 <td class='time'>Do: $this->czas_zad<br>Dnia: $this->data_zad
                 <td class='akcje'>";

        if ($this->stan_zad == 0) {
            echo "<a href='/../Lista-To-Do/src/Modules/akcje.php?zrobione=$this->id_zad'  class='dozrobienia'>Do zrobienia</a>";
        } else {
            echo "<a href='/../Lista-To-Do/src/Modules/akcje.php?dozrobienia=$this->id_zad' value='$this->numer_zad' class='zrobione'>Zrobione</a>";
        }
        echo "<a href='/../Lista-To-Do/src/Modules/akcje.php?del=$this->id_zad' class='usun'>X</a></td>";
        echo "<td><input class='check' type='checkbox' name='usun_wiele[]' value='$this->id_zad'></td>";
        echo "</tr>";
    }
}
