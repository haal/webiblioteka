<?

// uvodna stranica za javni dio sajta

function public_intro() {

	?>
		<table width="100%" border="0" cellspacing="4" cellpadding="0">
			<tr>
			<td valign="top">
			<p>&nbsp;</p><br><br><br><br><br><br>
			<?
				login_forma();
			?>
			</td>
			</tr>
			<tr><td>
			<?
				zadnje_obavijesti();
			?>
			<td></tr>
			<tr><td>
			<?
				zadnje_dodane_knjige()
			?>
			</td></tr>
			
		</table>
	<?
}


function login_forma() {
	global $greska;
	
	// Redirekciju na isti URI vršimo samo ako je greška = istek sesije
	$uri=$_SERVER['PHP_SELF'];

	if ($greska == "Vaša sesija je istekla. Molimo prijavite se ponovo." && !(strstr($_SERVER['REQUEST_URI'], "logout"))) {
		$uri = $_SERVER['REQUEST_URI'];
	}
	
	?>
	<center><table border="0" cellpadding="5" bgcolor="#FFFFFF">
	<tr>
		<td align="center">
		<big><b>Dobro dosli!</b></big>
		</td>
	</tr>
	<tr>
		<td align="center">
		<!-- Login forma -->
		<form action="<?=$uri?>" method="POST">
		<input type="hidden" name="loginforma" value="1">
		<table border="0">
			<tr><td>Korisnicko ime:</td><td><input type="text" name="login" size="15"></td></tr>
			<tr><td>Sifra:</td><td><input type="password" name="pass" size="15"></td></tr>
			<tr></tr><tr></tr>
			<tr><td colspan="2" align="center"><input type="submit" value="Kreni"></td></tr>
			<tr></tr>
			<tr><td colspan="2" align="center"><a href="public/registracija.php">Registracija</td></tr></table>
		</form>
		</td>
	</tr>
	</table></center>
	<?
}

?>
<?
function zadnje_obavijesti() {
	
	require("lib/config.php");

	dbconnect($conf_dbhost,$conf_dbuser,$conf_dbpass,$conf_dbdb);
	
	$q01 = myquery("SELECT o.idObavijest, o.naslov, o.datum, p.naziv, o.tekst FROM obavijest o, poslovnica p WHERE o.idPoslovnica=p.idPoslovnica");
	
	$brojac=1;

	print "<h2>OBAVIJESTI</h2><br>";
	while ($obavijest=mysql_fetch_row($q01)) {
		print "<b>".$obavijest[3]." - ".$obavijest[1]."</b><br>".$obavijest[2]."<br>".$obavijest[4]."<br><br>";
	}
	print "<br><br>";
	//print "<b>Prva obavijest</b><br>Tekst same obavijesti<br>";
	//print "<b>Druga obavijest</b><br>Tekst same obavijesti<br>";
}
?>

<?
function zadnje_dodane_knjige() {
	require("lib/config.php");
	
	dbconnect($conf_dbhost,$conf_dbuser,$conf_dbpass,$conf_dbdb);
	
	$q01 = myquery("SELECT k.naslov, z.naziv FROM knjigaopis k, zanr z WHERE k.idZanr=z.idZanr ORDER BY k.datumUlaza");
	
	$brojac=1;

	print "<h2>ZADNJE DODANE KNJIGE</h2><br>";
	while ($knjiga=mysql_fetch_row($q01)) {
		print $knjiga[0]." - ".$knjiga[1]."<br>";
	}
}
?>