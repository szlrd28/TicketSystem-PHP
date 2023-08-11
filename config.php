

//mysqli_connect('localhost','adat','asd','adatbazis')

//Config ---Kapcsolódás mysql-hez----
  mysql_connect("localhost","adat","asd","adatbazis"); //kapcsolódási adatok
  mysqli_query("SET NAMES utf8 COLLATE utf8_hungarian_ci");//karakterkódolás kiválasztása
 mysql_select_db("adatbazis"); 
  print mysql_error(); //ha hiba van kiírja
  
 