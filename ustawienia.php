<?php

session_start();
class Application
{
    private static $instance;


    public function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    public function connect()
    {
        if (isset(static::$instance))
            $pol=mysqli_connect('localhost','root','','listatodo');
        return $pol;
    }

    public function run()
    {
        if (isset(static::$instance)) {
            echo('
                <!DOCTYPE HTML>
                <html LANG="PL">
                <head>
                    <meta charset="UTF-8">
                    <title>Lista To Do</title>
                    <meta name="author" content="Marcin Zabrocki">
                    <meta http-equiv="x-ua-compatible" content="IE=EDGE,chrome=1">
                    <link rel="stylesheet" href="src/style.css">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                </head>
                <body>
                    <header>
                    <div>
                        <h1><b>Lista zadań do wykonania</b></h1>
                        <form action="src/ustawienia.php" method="post">
                            <input type="text" name="polecenie" id="pole" placeholder="Dodaj zadanie"/>
                            <input type="date" name="data_zadania" id="pole_data"/>
                            <input type="time" name="czas_zadania" id="pole_czas"/>
                            <input type="submit" name="przeslij" id="button" value="Zatwierdz"/><br>
                        </form>
                    </div>');
            walid();
            echo('</header>
                    <main>
                        <table>
                            <tr id="naglowek">
                                <th>Nr.</th>
                             <th>Zadanie</th>
                                <th>Wykonać do</th>
                                <th>Akcje</th>
                                <form method="$_GET" action="src/ustawienia.php">
                                    <th><input type="submit" value="delete" name="row_delete_multiple" id="delete"/></th>');
            dane();
            echo('
                            </tr>
                            </form>
                        </table>
                    </main>
                    <footer>
                        <div>
                            <form method="POST" action="src/ustawienia.php">
                                <input type="text" name="wyszpolecenie" id="wyszpole"
                                        placeholder="Wyszukaj polecenie"></input>
                                <input type="date" name="wyszdata_zadania"
                                        id="wyszpole_data"></input>
                                <input type="submit" name="wyszprzeslij" id="btnwyszukaj"
                                        value="Wyszukaj" title="Aby wrócić do wszystkich zadań naciśnij ponownie"><br>
                            </form>
                        </div>
                        <div>
                            <h5>Author: Marcin Zabrocki</h5>
                        </div>
                    </footer>
                </body>
            </html>');
        }
    }
}
//Struktura obiektów
class zadania
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
            echo "<a href='src/ustawienia.php?zrobione=$this->id_zad'  class='dozrobienia'>Do zrobienia</a>";
        } else {
            echo "<a href='src/ustawienia.php?dozrobienia=$this->id_zad' value='$this->numer_zad' class='zrobione'>Zrobione</a>";
        }
        echo "<a href='src/ustawienia.php?del=$this->id_zad' class='usun'>X</a></td>";
        echo "<td><input class='check' type='checkbox' name='usun_wiele[]' value='$this->id_zad'></td>";
        echo "</tr>";

    }
}

function dane()
{
    $conn = mysqli_connect("localhost", "root", "", "listatodo");
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
            $zmienna = new zadania($row['numer'], $i, $row['zadanie'],
                $row['data'], $row['czas'], $row['stan']);
            $zmienna->wypisz();
            $i++;
        }
    } else {
        echo "<tr><td colspan=5'class='parz'>Brak danych</td></tr>";
    }
    mysqli_close($conn);
}

//Dodawanie rekordów
function dodaj()
{
    $conn = mysqli_connect("localhost", "root", "", "listatodo");
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
    mysqli_close($conn);
    $pow = router::powrot();
    echo $pow;
}

function walid()
{
    $conn = mysqli_connect("localhost", "root", "", "listatodo");
    if (isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
    mysqli_close($conn);
}

function usun()
{
    //Usuwanie wielu rekordów
    $conn = mysqli_connect("localhost", "root", "", "listatodo");
    $all_id = $_GET['usun_wiele'];
    $format_id = implode(',', $all_id);
    $query = "DELETE FROM `zadaniadb` WHERE `numer` IN($format_id);";
    mysqli_query($conn, $query);
    mysqli_close($conn);
    $pow = router::powrot();
    echo $pow;
}

function deleteonce()
{
    //Usuwanie rekordów z bazy danych
    $conn = mysqli_connect("localhost", "root", "", "listatodo");
    $id = $_GET['del'];
    mysqli_query($conn, "DELETE FROM `zadaniadb` WHERE `numer` =$id;");
    mysqli_close($conn);
    $pow = router::powrot();
    echo $pow;
}

function stan()
{
    //Zmiana stanu zadania
    $conn = mysqli_connect("localhost", "root", "", "listatodo");
    if (isset($_GET['dozrobienia'])) {
        $id = $_GET['dozrobienia'];
        mysqli_query($conn,
            "UPDATE `zadaniadb` SET `stan` = '0' WHERE `numer` = $id;");
    }
    if (isset($_GET['zrobione'])) {
        $id = $_GET['zrobione'];
        mysqli_query($conn,
            "UPDATE `zadaniadb` SET `stan` = '1' WHERE `numer` = $id;");
    }
    mysqli_close($conn);
    $pow = router::powrot();
    echo $pow;
}

//Wyszukiwanie na podstawie zadania lub daty
function wyszukaj()
{
    if (!empty($_POST['wyszpolecenie']) && !empty($_POST['wyszdata_zadania'])) {
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
    $pow = router::powrot();
    echo $pow;
}

class router
{

    public function przekierowanie()
    {
        if (isset($_GET['zrobione']) || isset($_GET['dozrobienia'])) {
            stan();
        } elseif (isset($_GET['del'])) {
            deleteonce();
        } elseif (isset($_GET['row_delete_multiple'])) {
            usun();
        } elseif (isset($_POST['przeslij'])) {
            dodaj();
        } elseif (isset($_POST['wyszprzeslij'])) {
            wyszukaj();
        }
    }

    public function powrot()
    {
        header("location:\Lista-To-Do\index.php");
    }
}

$akcja = router::przekierowanie();
echo $akcja;
?>