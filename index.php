<?php

include_once 'ustawienia.php';

?>

<!DOCTYPE HTML>
<html LANG="PL">
<head>
    <meta charset="UTF-8">
    <title>Lista To Do</title>
    <meta name="author" content="Marcin Zabrocki">
    <meta http-equiv="x-ua-compatible" content="IE=EDGE,chrome=1">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header>
    <div>
        <h1><b>Lista zadań do wykonania</b></h1>
        <form action="ustawienia.php" method="post">
            <input type="text" name="polecenie" id="pole"
                   placeholder="Dodaj zadanie"/>
            <input type="date" name="data_zadania" id="pole_data"/>
            <input type="time" name="czas_zadania" id="pole_czas"/>
            <input type="submit" name="przeslij" id="button" value="Zatwierdz"/><br>
        </form>
    </div>
    <?php
    walid(); ?>
</header>
<main>
    <table>
        <tr id="naglowek">
            <th>Nr.</th>
            <th>Zadanie</th>
            <th>Wykonać do</th>
            <th>Akcje</th>
            <form method='$_GET' action='ustawienia.php'>
                <th><input type="submit" value="delete"
                           name="row_delete_multiple" id="delete"/></th>
        </tr>
        <?php
        dane();
        ?>
        </tr>
        </form>
    </table>
</main>
<footer>
    <div>
        <form method='POST' action='ustawienia.php'>
            <input type="text" name="wyszpolecenie" id="wyszpole"
                   placeholder="Wyszukaj polecenie"></input>
            <input type="date" name="wyszdata_zadania"
                   id="wyszpole_data"></input>
            <input type="submit" name="wyszprzeslij" id="btnwyszukaj"
                   value="Wyszukaj"
                   title="Aby wrócić do wszystkich zadań naciśnij ponownie"></input><br>
        </form>
    </div>
    <div>
        <h5>Author: Marcin Zabrocki</h5>
    </div>
</footer>
</body>
</html>