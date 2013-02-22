<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="css/main.css" type="text/css" />
<title>CotC Alternativ Aufstiegs Timer für AoC</title>
</head>
<body>
<img class="bg_img" src="http://www.childrenofthecorn.de/background_rotgs.jpg" />
<h1 class="main_h1">Alternativ Aufstiegs Timer</h1>

<form action="content.php" method="post">
<span class="userName">Benutzername:<br /><input type="text" name="user" size="20"/><br /></span>
<span class="pwd">Passwort:<br /><input type="password" name="pwd" size="20"/><br /></span>
<input class="submit" type="submit" name="login" value="Login"/>
</form>

<a href="register.html" name="register"><button class="reg_link">Registrierung</button></a>

</body>
</html>
<?php
/**
*
* Age of Conan Alternativ Aufstiegs Timer
* Index: Startseite mit Login und Registrierungs Maske 
*
* @author SmO
* @since 10.01.2012
*
**/
session_destroy();
?>