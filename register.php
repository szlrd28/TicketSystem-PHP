<?php


ob_start(); session_start();
include("config.php");
  
  if(isset($_POST['regisztracio']))
  {
    unset($reg_result);
    if(mb_strlen($_POST['nickname'])>25)
      $reg_result = ' Túl hosszú nick!(Max 25 karakter lehet!)
<input name="vissza" value="Vissza" onclick="history.go(-1)" type="button">';
    elseif($_POST['nickname']=="")
      $reg_result = 'Üres Nick mező!
<input class="buttons" name="vissza" value="Vissza" onclick="history.go(-1)" type="button">';
    elseif($_POST['pass1']=="")
      $reg_result = 'Üres Jelszó mező!
<input class="buttons" name="vissza" value="Vissza" onclick="history.go(-1)" type="button">';
    elseif($_POST['pass1']!=$_POST['pass2'])
      $reg_result = 'A két Jelszó mező különbözik!
<input class="buttons" name="vissza" value="Vissza" onclick="history.go(-1)" type="button">';
    elseif(mb_strlen($_POST['pass1'])<5)
      $reg_result = 'Túl rövid a jelszó! (min 5 karakter lehet)
<input class="buttons" name="vissza" value="Vissza" onclick="history.go(-1)" type="button">';
    elseif($_POST['email']=="")
       $reg_result = ' Üres e-mail mező!
<input class="buttons" name="vissza" value="Vissza" onclick="history.go(-1)" type="button">';
    else
    {
      $nick_prot = trim( $_POST['nickname'] );
      $nick_prot = mysql_escape_string($nick_prot);
      $sql_result = mysql_query("SELECT id FROM users  WHERE nickname='$nick_prot'");
      if(mysql_errno())
        $reg_result = "Adatbázis hiba [1] miatt a regisztráció sikertelen!";  
      if(@mysql_num_rows($sql_result))
        $reg_result = ' Már regisztráltak ezzel a nick névvel!
<input class="buttons" name="vissza" value="Vissza" onclick="history.go(-1)" type="button">';
      @mysql_free_result($sql_result);  
    }
    if(!isset($reg_result))
    {
      mysql_query("INSERT INTO users  (nickname,password,email,regip,regtime) VALUES ('$nick_prot', '".md5($_POST['pass1'])."', '".mysql_real_escape_string($_POST['email'])."','".$_SERVER['REMOTE_ADDR']."',NOW())");
      if(mysql_errno())
      $reg_result = "Adatbázis hiba [2] miatt a regisztráció sikertelen!";  
      print mysql_error();
    }
}
  header("Content-Type: text/html; charset=utf-8"); // html tartalom utf8 kódolás
  header("Cache-Control: no-cache, no-store, must-revalidate, post-check=0, pre-check=0"); // nincs cache, mindig frissítsen
  
  if(!isset($_POST['regisztracio']))
  {
    // regisztsációs form megjeleníse
    include('form.php');
  }
  elseif(isset($_POST['regisztracio']))
  {
    // regisztráció eredménye
    if(isset($reg_result))
      // valami hiba van
      print("$reg_result");
    else {
      // siker :-)
          print('Sikeres regisztráció!');
         }
  }  
  
  //mysql_close();
  
  ?>