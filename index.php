<?php
    include_once 'ustawienia.php'; 
?>

<!DOCTYPE HTML>
<html LANG="PL">
<head>
<meta charset="UTF-8">
    <title>Lista To Do</title>
    <meta name ="author" content ="Marcin Zabrocki">
    <meta http-equiv="x-ua-compatible" content="IE=EDGE,chrome=1">
    <link rel ="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head> 
<body>
    <header>
        <div>
            <h1><b>Lista zadań do wykonania</b> </h1>
            <form action="ustawienia.php" method="post">
                <input type="text" name="polecenie"id="pole" placeholder="Dodaj zadanie"/>
                <input type="date" name="data_zadania" id="pole_data"/>
                <input type="time" name="czas_zadania" id="pole_czas"/>
                <input type="submit" name="przeslij" id="button" value="Zatwierdz"/><br>
            </form>
        </div>
    </header>
    <main>
        <table>
            <tr id="naglowek">
                <th>Nr.</th>
                <th>Zadanie</th>
                <th>Wykonać do</th>
                <th>Akcje</th>
                <form method='$_GET' action='ustawienia.php'>
                <th><input type="submit" value="delete"name="row_delete_multiple" id="delete"/></th>
            </tr>
            <?php 
                $conn=mysqli_connect("localhost","root","","listatodo");
                if(!$conn)
                {
                    alert("Błąd połączenia");
                }
                $i=1;
                if(!empty($_GET['zapytanie']))
                {
                    $query=$_GET['zapytanie'];
                }else
                {
                    $query="SELECT *FROM `zadaniadb`"; 
                }
                $wynik=mysqli_query($conn,$query);
                if(mysqli_num_rows($wynik)>0)
                {
                    while($row=mysqli_fetch_assoc($wynik))
                    {
                        $zmienna=new zadania($row['numer'],$i,$row['zadanie'],$row['data'],$row['czas'],$row['stan']);
                        $zmienna->wypisz();
                        $i++;
                    }
                }else
                {
                    ?>
                    <tr>
                        <td colspan="5"class='parz'>Brak danych</td>
                    </tr>
                    <?php

                }mysqli_close($conn);
            ?>
          </tr>
          </form>
        </table>
    </main>
    <footer>
        <div>
            <form method='POST' action='ustawienia.php'>
                <input type="text" name="wyszpolecenie"id="wyszpole" placeholder="Wyszukaj polecenie"></input>
                <input type="date" name="wyszdata_zadania" id="wyszpole_data"></input>
                <input type="submit" name="wyszprzeslij" id="btnwyszukaj" value="Wyszukaj"></input><br>
            </form>
            </div>
        <div>
            <h5>Author: Marcin Zabrocki</h5>
        </div>
    </footer>
</body>
</html>