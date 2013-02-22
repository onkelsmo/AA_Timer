<?php
/*
*
* Age of Conan Alternativ Aufstiegs Timer
*
* Autor: Jan Smolka
* Date: 01.10.2011
*
* Config: Für Datebankanbindung
*
*/

$dbname = "aa_timer";
$dbhost = "localhost";
$dbuser = "root";
$dbpwd = "";

mysql_connect($dbhost, $dbuser, $dbpwd) or die ("Keine Verbindung moeglich");
mysql_select_db($dbname) or die ("Die Datenbank existiert nicht.");

?>