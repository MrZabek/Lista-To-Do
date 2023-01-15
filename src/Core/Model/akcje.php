<?php

namespace App\Composer\Core\Model;

require_once 'configdb.php';

class akcje
{
    public function dane()
    {
        $conn = configdb::pol();
        $i = 1;
        if (isset($_SESSION['zapytanie'])) {
            $query = $_SESSION['zapytanie'];
            unset($_SESSION['zapytanie']);
        } else {
            $query = "SELECT *FROM `zadaniadb`";
        }
        $wynik = mysqli_query($conn, $query);
        if (mysqli_num_rows($wynik) > 0) {
            while ($row = mysqli_fetch_assoc($wynik)) {
                $zmienna = new Zadania(
                    $row['numer'], $i, $row['zadanie'],
                    $row['data'], $row['czas'], $row['stan']
                );
                $zmienna->wypisz();
                $i++;
            }
        } else {
            echo "<tr><td colspan=5'class='parz'>Brak danych</td></tr>";
        }
        configdb::close();
    }

//Dodawanie rekordów
    public function dodaj()
    {
        $conn = configdb::pol();
        if (!empty($_POST['polecenie'])) {
            if (!empty($_POST['data_zadania'])) {
                if (!empty($_POST['czas_zadania'])) {
                    @$dane = $_POST['polecenie'];
                    @$data = $_POST['data_zadania'];
                    @$czas = $_POST['czas_zadania'];
                    @$query
                        = "INSERT INTO `zadaniadb`(`numer`, `zadanie`, `data`, `czas`, `stan`) VALUES ('','$dane','$data','$czas',0);";
                    mysqli_query($conn, $query);
                } else {
                    $_SESSION['alert'] = '<h4>Wprowadz godzine</h4>';
                }
            } else {
                $_SESSION['alert'] = '<h4>Wprowadz datę</h4>';
            }
        } else {
            $_SESSION['alert'] = '<h4>Wprowadz polecenie</h4>';
        }
        configdb::close();
        header("location:  \Lista-To-Do\public\index.php");
    }

    public function walid()
    {
        if (isset($_SESSION['alert'])) {
            echo $_SESSION['alert'];
            unset($_SESSION['alert']);
        }
    }

    public function usun()
    {
        //Usuwanie wielu rekordów
        $conn = configdb::pol();
        $all_id = $_GET['usun_wiele'];
        $format_id = implode(',', $all_id);
        $query = "DELETE FROM `zadaniadb` WHERE `numer` IN($format_id);";
        mysqli_query($conn, $query);
        configdb::close();
        header("location:\Lista-To-Do\public\index.php");
    }

    public function deleteonce()
    {
        //Usuwanie rekordów z bazy danych
        $conn = configdb::pol();
        $id = $_GET['del'];
        mysqli_query($conn, "DELETE FROM `zadaniadb` WHERE `numer` =$id;");
        configdb::close();
        header("location:\Lista-To-Do\public\index.php");
    }

    public function stan()
    {
        //Zmiana stanu zadania
        $conn = configdb::pol();
        if (isset($_GET['dozrobienia'])) {
            $id = $_GET['dozrobienia'];
            mysqli_query(
                $conn,
                "UPDATE `zadaniadb` SET `stan` = '0' WHERE `numer` = $id;"
            );
        }
        if (isset($_GET['zrobione'])) {
            $id = $_GET['zrobione'];
            mysqli_query(
                $conn,
                "UPDATE `zadaniadb` SET `stan` = '1' WHERE `numer` = $id;"
            );
        }
        configdb::close();
        header("location:\Lista-To-Do\public\index.php");
    }

//Wyszukiwanie na podstawie zadania lub daty
    public function wyszukaj()
    {
        if (!empty($_POST['wyszpolecenie'])
            && !empty($_POST['wyszdata_zadania'])
        ) {
            $element = $_POST['wyszpolecenie'];
            $drugi_element = $_POST['wyszdata_zadania'];
            $_SESSION['zapytanie']
                = "SELECT * FROM `zadaniadb` WHERE 'zadanie'like'%$element%' AND`data` LIKE'$drugi_element'";
        } elseif (!empty($_POST['wyszpolecenie'])) {
            $element = $_POST['wyszpolecenie'];
            $_SESSION['zapytanie']
                = "SELECT * FROM `zadaniadb` WHERE `zadanie` LIKE '%$element%';";
        } elseif (!empty($_POST['wyszdata_zadania'])) {
            $element = $_POST['wyszdata_zadania'];
            $_SESSION['zapytanie']
                = "SELECT * FROM `zadaniadb` WHERE `data` LIKE '$element';";
        }
        header("location:\Lista-To-Do\public\index.php");
    }
}

if (isset($_GET['zrobione']) || isset($_GET['dozrobienia'])) {
    akcje::stan();
} elseif (isset($_GET['del'])) {
    akcje::deleteonce();
} elseif (isset($_GET['row_delete_multiple'])) {
    akcje::usun();
} elseif (isset($_POST['przeslij'])) {
    akcje::dodaj();
} elseif (isset($_POST['wyszprzeslij'])) {
    akcje::wyszukaj();
}