<?php
session_start();
//session_destroy();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<link rel="stylesheet" href="css/main.css" type="text/css" />
<script src="js/jquery-1.7.1.js"></script>
<script src="js/general.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	bandoneon($(".content"), $(".bar"));
	colorChanger($("body"));
});
</script>
<title>CotC Alternativ Aufstiegs Timer für AoC</title>
</head>
<body class="use-hover">
<img class="bg_img" src="http://www.childrenofthecorn.de/background_rotgs.jpg" />
<?php
/*
 * 
 * Age of Conan Alternativ Aufstiegs Timer
 * 
 * Autor: Jan Smolka
 * Date: 01.10.2011
 *
 * Content: Nach erfolgreichem Login, Anzeige der Restdauer des jeweiligen Alternativ Aufstieg, hinzufügen und entfernen von Charakteren 
 *
 */

if(!isset($_SESSION["user"]) || !isset($_SESSION["pwd"]))
{
	$_SESSION["user"] = $_POST["user"];
	$_SESSION["pwd"] = $_POST["pwd"];
}

include "classes/main_class.php";
include "config.php";

$user = new Member($_SESSION["user"], $_SESSION["pwd"]);
$user->login();

if($user->loginStatus == false)
{
	echo '<a href="index.php" name="zurück"><button class="back_link_after_reg">Zur&uuml;ck zur Startseite</button></a><br />';
}else{
	?>
	<span class="addedCharsHead">Eingetragene Chars</span>
	<div class="charList">
	<?php 
	$user->listChars();
	?>
	</div>
	<form action="" method="post">
	<span class="newChar">Neuen Char eintragen</span>
	<input class="charNameInput" type="text" name="char" value="Char Name" onclick="this.value=''" size="20"/>
	<input class="charNameSubmit" id="submit" type="submit" name="add" value="Eintragen"/>
	</form>
	<?php
	if(isset($_POST["char"]) && $_POST["char"] !== '')
	{
			$char = $_POST['char'];
			$user->setChar($char);
			//header('Location: '.$_SERVER["PHP_SELF"].'');
	}	
}
?>

</body>

</html>