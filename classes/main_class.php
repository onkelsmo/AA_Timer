<?php
/**
 * 
 * Age of Conan Alternativ Aufstiegs Timer
 * Main_class: Hauptklasse Member
 * 
 * @author SmO
 * @since 26.11.2011
 *
 */
class Member {
	// Eingenschaften der Klasse Member
	public $username;
	public $password;
	public $char;
	public $time;
	public $loginStatus = false;
	
	
	/**
	 * 
	 * Konstruktor
	 * @param string $username
	 * @param string $password
	 * @param string $char
	 * @param int $time
	 */
	public function __construct($username, $password, $char = " ", $time = 0) 
	{
		$this->username = $username;
		$this->password = $password;
		$this->char = $char;
		$this->time = $time;
	}
	

	/**
	 * 
	 * Destruktor
	 */
	public function __destruct() 
	{
		// TODO gibt es die notwendigkeit?
	}

	
	/**
	 * 
	 * Registreirung, falls noch kein Konto vorhanden
	 */
	public function register() 
	{ 
		include "config.php";
		
		//POST-Daten in Variablen schreiben
		$user = $_SESSION["user"];
		$pwd = $_SESSION["pwd"];
		
		//Check, ob POST-Daten gefüllt. ansonsten: verweis
		if ($user == "" || $pwd == ""){
			echo '<span class="error">Bitte beide Felder ausfüllen!<br /></span>';
			echo '<a href="register.html" name="zurück"><button class="back2reg">Zur&uuml;ck zur Registrierung</button></a><br />';
			echo '<a href="index.php" name="zurück"><button class="back_link">Zur&uuml;ck zur Startseite</button></a><br />';
			//return false;
		}else{
			//Eintrag in die Datenbank TODO "Doppelte Einträge verhindern!"
			$eintrag ="INSERT INTO user (user, password) VALUES ('$user', '$pwd')";
			$eintragen = mysql_query($eintrag);
			echo '<span class="thanks">Danke fürs registrieren<br /></span>';
			echo '<a href="index.php" name="zurück"><button class="back_link_after_reg">Zur&uuml;ck zur Startseite</button></a><br />';
			//return true;
		}
	}
	
	/**
	 * 
	 * Einlogen in Userbereich 
	 */
	public function login() 
	{ 
		include "config.php";
		
		//SESSION-Daten in Variablen schreiben
		$user = $_SESSION["user"];
		$pwd = $_SESSION["pwd"];
		
		//Check, ob SESSION-Daten gefüllt. ansonsten: false
		if ($user == "" || $pwd == ""){
			echo '<span class="error">Bitte beide Felder ausfüllen!<br /></span>';
			//return false;
		}
		if (isset($user, $pwd)){
			//Datenbankabfrage, ob user vorhanden.
			$abfrage = "SELECT user, password FROM user WHERE user = '$user' AND password = '$pwd'";
			$ergebnis = mysql_query($abfrage);
		
			while($row = mysql_fetch_object($ergebnis))
			{
				echo '<h1 class="main_h1">Hallo '.$row->user.'!<br /></h1>';
				echo '<a href="index.php" name="zurück"><button class="logout">Logout</button></a>';
				$this->loginStatus = true;
				//return true;
			}
		}
	}
	
	/**
	 * 
	 * Neuen Char einfügen
	 * @param string $newChar
	 */
	public function setChar($newChar)
	{
			include "config.php";
			
			//TODO - Leeren Eintrag vermeiden!
			$this->char = $newChar;
			//User ID aus DB holen
			$abfrage = "SELECT id FROM user WHERE user = '$this->username'";
			$ergebnis = mysql_query($abfrage);
			while($row = mysql_fetch_array($ergebnis))
			{
				$user_id = $row['id'];
				
				//Char in DB eintragen
				$eintrag = "INSERT INTO chars (user_id, name) VALUES ('$user_id', '$this->char')";
				$eintragen = mysql_query($eintrag);
			}

			echo $this->char." wurde eingetragen!<br />";
			echo '<meta http-equiv="Refresh" content="0"; URL='.$_SERVER["PHP_SELF"].'">';
	}
	
	/**
	 * 
	 * Char löschen
	 * @param string $charToClear
	 */
	private function clearChar($charToClear)
	{
		?>
		<form class="<?php echo $charToClear ?>" action="" method="post">
		<input type="hidden" name="clear<?php echo $charToClear ?>" value="clear<?php echo $charToClear ?>"/>
		<input type="submit" name="del" value="Char l&ouml;schen"/>
		</form>
		<?php 
		$abfrage = "SELECT id FROM user WHERE user = '$this->username'";
		$ergebnis = mysql_query($abfrage);
		while($row = mysql_fetch_array($ergebnis))
		{
			$user_id = $row['id'];
		}
		
		if(isset($_POST["clear".$charToClear.""]))
		{
			$mysqlDelete = "DELETE FROM chars WHERE name = '$charToClear'";
			$deleteQuery = mysql_query($mysqlDelete);
			if(! $deleteQuery )
			{
				die('Char konnte nicht gelöscht werden: ' . mysql_error());
			}else{
				echo 'Char erfolgreich gelöscht!';
				echo '<meta http-equiv="Refresh" content="0"; URL='.$_SERVER["PHP_SELF"].'">';
			}
		}
	}
	
	/**
	 * 
	 * Auflistung aller vorhandenen Chars eines Users
	 */
	public function listChars()
	{
		$abfrage = "SELECT id FROM user WHERE user = '$this->username'";
		$ergebnis = mysql_query($abfrage);
		while($row = mysql_fetch_array($ergebnis))
		{
			$user_id = $row['id'];
		}
		$abfrage = "SELECT name FROM chars WHERE user_id = '$user_id'";
		$ergebnis = mysql_query($abfrage);

		$charCount = 0;
		while($row = mysql_fetch_array($ergebnis))
		{
			$charName[] = $row;
			?>
				<h3 class="bar"><?php echo $charName[$charCount]['name'] ?></h3>
					<div class="content">
						<span>
						<?php $this->getTime($charName[$charCount]['name']); ?>
						<?php $this->setTime($charName[$charCount]['name']); ?><br />
						<?php $this->clearChar($charName[$charCount]['name']); ?><br />
						</span>
					</div>
			<?php 
			$charCount++;		
		}
	}
  	
	/**
	 * 
	 * Aktuelle AA-Zeit anzeigen
	 * @param string $charName Name des Chars, für den die AA-Zeit angezeigt werden soll
	 */
	private function getTime($charName)
	{
		$abfrage = "SELECT startTime, time FROM chars WHERE name = '$charName'";
		$ergebnis = mysql_query($abfrage);
		while($row = mysql_fetch_array($ergebnis))
		{
			$startTime = $row['startTime'];
			$time = $row['time'];
		}
		
		if($time !== '0')
		{
		//Eingetragene Zeit in Sekunden umrechnen
		$timeInSeconds = $time * 3600;
		
		//Start Time String zerlegen
		$startTime = explode('-', $startTime);
		$startTime['2'] = explode(' ', $startTime['2']);
		$startTime['2']['1'] = explode(':', $startTime['2']['1']);
		
		//Start Time in Variablen gliedern
		$startTimeYear = $startTime['0'];
		$startTimeMonth = $startTime['1'];
		$startTimeDay = $startTime['2']['0'];
		$startTimeHour = $startTime['2']['1']['0'];
		$startTimeMin = $startTime['2']['1']['1'];
		$startTimeSec = $startTime['2']['1']['2'];
		
		//Start Time in unixTime umwandeln
		$startTimeUnixTime = mktime($startTimeHour, $startTimeMin, $startTimeSec, $startTimeMonth, $startTimeDay, $startTimeYear);
		
		//Endzeitpunkt berechnen und in "normales" Datum umwandeln
		$endTime = $startTimeUnixTime + $timeInSeconds;
		
		// wenn Zeit abgelaufen, wird ein span hinzugefügt um dem übergeordneten "h3" eine bestimmte klasse hinzuzufügen
		$now = time();
		if($endTime <= $now)
		{
			echo '<span class="ready"></span>';
		}
		
		$formattedEndTime = date("\S\k\i\l\l \\f\e\\r\\t\i\g \a\m l \d\e\\n j\.n\.Y\ \u\m H:i:s", $endTime);
		
		//Englische Bezeichnungen ersetzen
		$englishDays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
		$germanDays = array('Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag');
		$formattedEndTime = str_replace($englishDays, $germanDays, $formattedEndTime);
		
		echo $formattedEndTime;
		}
	}
	
	/**
	 * 
	 * Neue AA-Zeit einfügen
	 * @param string $charName Name des Chars, für den die AA-Zeit eingetragen werden soll
	 */
	private function setTime($charName)
	{
		$abfrage = "SELECT time FROM chars WHERE name = '$charName'";
		$ergebnis = mysql_query($abfrage);
		while($row = mysql_fetch_array($ergebnis))
		{
			$time = $row['time'];
		}
		
		if($time == '0')
		{
			echo "Neue Zeit in Stunden?";
			?>
			<form class="<?php echo $charName ?>" action="" method="post">
			<input type="hidden" name="setTimeFor<?php echo $charName ?>" value="setTimeFor<?php echo $charName ?>"/>
			<input type="text" name="timeToSetFor<?php echo $charName ?>" size="3" />
			<input type="submit" name="set" value="Zeit eintragen"/>
			</form>
			<?php
			if(!isset($_POST["timeToSetFor".$charName.""]) || $_POST["timeToSetFor".$charName.""] == "")
			{
				//TODO was passiert hier? Fehlermeldung?
			}
			else
			{
				$time = $_POST["timeToSetFor".$charName.""];
				//Damit der Timestamp bei gleicher Zeiteingabe neu gesetzt wird
				$eintrag = "UPDATE chars SET time = '0' WHERE name = '$charName'";
				$eintragen = mysql_query($eintrag);
				//Dann Spalte Updaten und aktueller Timestamp wird gesetzt
				$eintrag = "UPDATE chars SET time = '$time' WHERE name = '$charName'";
				$eintragen = mysql_query($eintrag);
				echo '<meta http-equiv="Refresh" content="0"; URL='.$_SERVER["PHP_SELF"].'">';				
			}
		}
		else
		{
			//echo "Zeit zurücksetzen";
			$this->clearTime($charName);
			
		}
	}
	
	public function clearTime($charName)
	{
		?>
		<form class="<?php echo $charName ?>" action="" method="post">
		<input type="hidden" name="clearTimeFor<?php echo $charName ?>" value="clearTimeFor<?php echo $charName ?>"/>
		<input class="clearTime" type="submit" name="del" value="Zeit zur&uuml;cksetzen"/>
		</form>
		<?php 
		if(isset($_POST['clearTimeFor'.$charName.'']))
		{
			$eintrag = "UPDATE chars SET time = '0' WHERE name = '$charName'";
			$eintragen = mysql_query($eintrag);
			echo '<meta http-equiv="Refresh" content="0"; URL='.$_SERVER["PHP_SELF"].'">';
		}
	}
	
	
	/**
	 * 
	 * Benachrichtigung per Mail, wenn Zeit abgelaufen
	 */
	public function mailTo()
	{
		//TODO 
	}
}
?>