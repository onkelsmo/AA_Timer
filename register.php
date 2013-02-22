
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>CotC Alternativ Aufstiegs Timer für AoC</title>
<link rel="stylesheet" href="css/main.css" type="text/css" />
</head>
<body>
<img class="bg_img" src="http://www.childrenofthecorn.de/background_rotgs.jpg" />
<h1 class="register">Registrierung</h1>
<?php
/*
*
* Age of Conan Alternativ Aufstiegs Timer
*
* Autor: Jan Smolka
* Date: 02.10.2011
*
* Register.php: Daten in Datenbank eintragen.
*
*/
//session_start();
include "classes/main_class.php";

$_SESSION["user"] = $_POST["user"];
$_SESSION["pwd"] = $_POST["pwd"];

$newMember = new Member($_POST["user"], $_POST["pwd"]);
$newMember->register();


?>
</body>

</html>