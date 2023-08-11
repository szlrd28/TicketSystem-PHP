<?php

ob_start();
session_start();
include('config.php');
include('login_form.php');
   if(isset($_POST["login"])){
 //Bejelentkezés
   $nickname = $_POST["nickname"]; //Név
   $password = md5($_POST["password"]); //Jelszó
   $lekerdezes = mysql_query("SELECT * FROM users WHERE nickname = '".mysql_real_escape_string($nickname)."' AND password = '$password'"); //Megnézi jók-e az adatok
   $vanelekerdezes = mysql_num_rows($lekerdezes);
   if ($vanelekerdezes>0)//Ha van ilyen felhasználónév/jelszó páros
   {
      header('location: login.php'); //Ha sikerült belépni, a login.php-ra irányít
      $adatok=mysql_fetch_assoc($lekerdezes); //SESSION-ba rendezi az adatokat
      $_SESSION["id"]=$adatok["id"];
      $_SESSION['bann'] = 0;
      $_SESSION["nickname"]=$adatok["nickname"];
      $_SESSION["rank"]=$adatok["rank"];      
  }
   else
  {
   print 'Hibás felhasználónév vagy jelszó!'; //Ha nem jók a beírt adatok hiba
   print mysql_error(); //ha esetleg adatbázis hiba van akkor kiírja
  }
  
  
   } else if(isset($_SESSION["nickname"])){ //Ha sikerült belépni a  belső tartalom 
   
   
   
   print 'Üdv, '.$_SESSION['nickname'].''; //belépett falhasználó, ha kiírja a nevét akkor működik
   
   ?>