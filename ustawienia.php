<?php
    //Struktura obiektów      
    class zadania{
        public $id_zad;
        public $numer_zad;
        public $pol_zad;
        public $czas_zad;
        public $data_zad;
        public $stan_zad;
        public function __construct($id_zad,$numer_zad,$pol_zad,$data_zad,$czas_zad,$stan_zad)
        {
            $this->id_zad=$id_zad;
            $this->numer_zad=$numer_zad;
            $this->pol_zad = $pol_zad;
            $this->czas_zad=$czas_zad;
            $this->data_zad=$data_zad;
            $this->stan_zad = $stan_zad;   
        }
        //Wypisywanie zawartości bazy danych
         function wypisz()
        {
            if($this->numer_zad%2==0)
            {
                $classname="parz";
            }else
            {  
                $classname="nieparz";
            }
            echo"<tr class='$classname' id='$this->numer_zad'name=zad_'$this->id_zad' value='$this->id_zad'>";
            echo"<td class='nr'>$this->numer_zad</td>
                 <td class='zadanie'>$this->pol_zad</td>
                 <td class='time'>Do: $this->czas_zad<br>Dnia: $this->data_zad
                 <td class='akcje'>";

            if($this->stan_zad ==0)
            {
                echo"<a href='ustawienia.php?zrobione=$this->id_zad'  class='dozrobienia'>Do zrobienia</a>";
            }
            else
            {
                echo"<a href='ustawienia.php?dozrobienia=$this->id_zad' value='$this->numer_zad' class='zrobione'>Zrobione</a>"; 
            }  
            echo"<a href='ustawienia.php?del=$this->id_zad' class='usun'>X</a></td>";
            echo"<td><input class='check' type='checkbox' name='usun_wiele[]' value='$this->id_zad'></td>";
            echo"</tr>";
                
        }
    }

    //Dodawanie rekordów
    function dodaj()
    {
        $conn=mysqli_connect("localhost","root","","listatodo");
        if(!empty($_POST['polecenie']))
        {
            if(!empty($_POST['data_zadania']))
            {
                if(!empty($_POST['czas_zadania']))
                {
                    @$dane=$_POST['polecenie'];
                    @$data=$_POST['data_zadania'];
                    @$czas=$_POST['czas_zadania'];
                    @$query="INSERT INTO `zadaniadb`(`numer`, `zadanie`, `data`, `czas`, `stan`) VALUES ('','$dane','$data','$czas',0);"; 
                    mysqli_query($conn,$query);
                }else  echo  '"Wprowadz Zadanie"'; 
            }else echo '"Wprowadz datę"'; 
        }else echo '"Wprowadz godzinę"'; 
        mysqli_close($conn);
        header("location: index.php");
    }

    function usun()
    {
    //Usuwanie wielu rekordów
    $conn=mysqli_connect("localhost","root","","listatodo");
        $all_id=$_GET['usun_wiele'];
        $format_id=implode(',',$all_id);
        $query="DELETE FROM `zadaniadb` WHERE `numer` IN($format_id);";
        mysqli_query($conn,$query);
        mysqli_close($conn);
        header("location:index.php");
    }

    function deleteonce()
    {
    //Usuwanie rekordów z bazy danych
    $conn=mysqli_connect("localhost","root","","listatodo");
        $id=$_GET['del'];
        mysqli_query($conn,"DELETE FROM `zadaniadb` WHERE `numer` =$id;");
        mysqli_close($conn);
        header("location: index.php");
    }

    function stan()
    {
    //Zmiana stanu zadania
    $conn=mysqli_connect("localhost","root","","listatodo");
        if(isset($_GET['dozrobienia']))
        {
            $id=$_GET['dozrobienia'];
            mysqli_query($conn,"UPDATE `zadaniadb` SET `stan` = '0' WHERE `numer` = $id;");
        }
        if(isset($_GET['zrobione']))
        {
            $id=$_GET['zrobione'];
            mysqli_query($conn,"UPDATE `zadaniadb` SET `stan` = '1' WHERE `numer` = $id;");
        }
        mysqli_close($conn);
        header("location: index.php");
    }
    //Wyszukiwanie na podstawie zadania lub daty
    function wyszukaj()
    {
        if(!empty($_POST['wyszpolecenie'])&&!empty($_POST['wyszdata_zadania']))
        {
            $element=$_POST['wyszpolecenie'];
            $drugi_element=$_POST['wyszdata_zadania'];
            $query="SELECT * FROM `zadaniadb` WHERE 'zadanie'like'%$element%' AND`data` LIKE'$drugi_element'";
        }elseif(!empty($_POST['wyszpolecenie']))
        {
             $element=$_POST['wyszpolecenie'];
             $query="SELECT * FROM `zadaniadb` WHERE `zadanie` LIKE '%$element%';";
         }elseif(!empty($_POST['wyszdata_zadania']))
        {
            $element=$_POST['wyszdata_zadania'];
            $query="SELECT * FROM `zadaniadb` WHERE `data` LIKE '$element';";
        }
        
      header("location: index.php?zapytanie=$query");
    }


    if (isset($_GET['zrobione'])||isset($_GET['dozrobienia'])) 
    {
        stan();
    }elseif(isset($_GET['del']))
    {
        deleteonce();
    }elseif(isset($_GET['row_delete_multiple']))
    {
        usun();
    }elseif (isset($_POST['przeslij'])) 
    {
        dodaj();
    }elseif(isset($_POST['wyszprzeslij']))
    {
        wyszukaj();
    }
?>