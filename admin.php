<?php



ob_start();
session_start();
print('<meta http-equiv="content-type" content="text/html; charset=UTF-8" />');
include('config.php');
if(isset($_SESSION['rank']) && $_SESSION['rank'] == 3)
{
    
?>        
<a href="home.php">főoldal</a>
<table width="100%">
<tr>
<td>Nick</td>
<td>Rang</td>
<td>E-mail</td>
<td>IP</td>
<td>Regisztrált</td>
<td>Műveletek</td>
</tr>
<?
              $sql="SELECT * FROM users";
             $qry=mysql_query($sql);
             while($u=mysql_fetch_assoc($qry)) 
             {
             
             switch($u['bans'])
             {
             case 0:
             $action='<a href="?act=bann&id='.$u['id'].'">Bann</a>';
             break;
             case 1:
             $action='<a href="?act=unbann&id='.$u['id'].'">Feloldás</a>';
             break;
             }
             
             switch($u['rank'])
             {
             case 1:
             $user_rank='tag';
             $rank_action='<a href="?act=admin_add&id='.$u['id'].'">Admin adása</a>';
             break;
             case 3:
             $user_rank='<font color="red">admin</font>';
             $rank_action='<a href="?act=admin_del&id='.$u['id'].'">Admin vétele</a>';
             break;
             }
?>
<tr>
<td><?= $u['nickname']; ?></td>
<td><?= $user_rank; ?></td>
<td><?= $u['email']; ?></td>
<td><?= $u['regip']; ?></td>
<td><?= $u['regtime']; ?></td>
<td><?= $action; ?> | <?= $rank_action; ?> | <a href="?act=del&id=<?= $u['id']; ?>">Törlés</a></td>
</tr>
<? } ?>
</table>    
<?
//felhasználó kitíltása
if(isset($_GET['act']) && $_GET['act'] =='bann') 
{
mysql_query('UPDATE users SET bans=1 WHERE id="'.$_GET['id'].'"');
print('A felhasználó kitíltva!<br><a href="admin.php">frissít</a>');
}
?>
<?
//felhasználó feloldása
if(isset($_GET['act']) && $_GET['act'] =='unbann')
{
mysql_query('UPDATE users SET bans=0 WHERE id="'.$_GET['id'].'"');
print('A felhasználó újra beléphet<br><a href="admin.php">frissít</a>');
}
?>
<?
//admin rang adása
if(isset($_GET['act']) && $_GET['act'] =='admin_add')
{
mysql_query('UPDATE users SET rank=3 WHERE id="'.$_GET['id'].'"');
print('A felhasználó admin rangot kapott!<br><a href="admin.php">frissít</a>');
}
?>        
<?
//admin rang elvétele
if(isset($_GET['act']) && $_GET['act'] =='admin_del')
{
mysql_query('UPDATE users SET rank=1 WHERE id="'.$_GET['id'].'"');
print('A felhasználó adminja megvonva!<br><a href="admin.php">frissít</a>');
}
?>
<?
//felhasználó törlése
if(isset($_GET['act']) && $_GET['act'] =='del')
{
mysql_query('DELETE FROM users WHERE id="'.$_GET['id'].'"');
print('A felhasználó törölve!<br><a href="admin.php">frissít</a>');
}  
} else print('Hozzáférés megtagadva!');

 ?>