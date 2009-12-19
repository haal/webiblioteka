<?


// uvodna stranica za javni dio sajta

function public_intro() {

	?>
		<table width="100%" border="0" cellspacing="4" cellpadding="0">
			<tr>
			<td width="15%" valign="top">
			<?
				login_forma();
			?>
			</td>
			<td width="50%" valign="top">
			<?
				zadnje_obavijesti();
			?>
			</td>
			<td width="3%"></td>
			<td width="30%" valign="top">
			<?
				top_knjige();
			?>
			</td>
			</tr>
			<tr><td>
			<?
				//zadnje_obavijesti();
			?>
			<td></tr>
			<tr><td>
			<?
				//zadnje_dodane_knjige()
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
		<h3>LOGIN</h3>
		</td>
	</tr>
	<tr>
		<td align="center">
		<!-- Login forma -->
		<form action="<?=$uri?>" method="POST">
		<input type="hidden" name="loginforma" value="1">
		<table border="0">
			<tr><td>Korisnicko ime:</td></tr><tr><td><input type="text" name="login" size="15"></td></tr>
			<tr><td>Sifra:</td><tr><td><input type="password" name="pass" size="15"></td></tr>
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


	$q01 = myquery("SELECT o.idObavijest, o.naslov, UNIX_TIMESTAMP(o.datum) as vrijeme, p.naziv, o.tekst 
					FROM obavijest o, poslovnica p 
					WHERE o.idPoslovnica=p.idPoslovnica
					ORDER BY vrijeme DESC");
	
	$brojac=1;

	print "<h3>OBAVIJESTI</h3><br>";
	while ($obavijest=mysql_fetch_row($q01)) {
		print "<b>".$obavijest[3]." - ".$obavijest[1]."</b><br>".date("d.m.Y. H:i",($obavijest[2]))."<br><br>".$obavijest[4]."<br><br><br>";
	}
	print "<br><br>";
	//print "<b>Prva obavijest</b><br>Tekst same obavijesti<br>";
	//print "<b>Druga obavijest</b><br>Tekst same obavijesti<br>"; date("d.m.Y. H:i",($obavijest[2])
}
?>

<?
function top_knjige() {

	//10 najnovijih knjiga
	$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime, UNIX_TIMESTAMP(k.datumulaza) as vrijeme
					FROM knjigaopis as k, autor as a, pisac as p
					WHERE p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis
					GROUP BY k.idknjigaopis ORDER BY vrijeme DESC LIMIT 0,10");
	
	$brojac=1;

	print "<h3>NAJNOVIJE KNJIGE</h3>";
	while ($knjiga=mysql_fetch_row($q01)) {
		$link="<a href=\"?sta=public/knjiga&knjiga=".$knjiga[0]."\">".$knjiga[1]."</a>";
		print $brojac.". ".$link." - ".$knjiga[3]." ".$knjiga[2]."<br>";
		$brojac++;
	}
	
	//10 najbolje ocijenjenih knjiga
	$q02 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime, AVG(o.vrijednost) as ocjena
					FROM knjigaopis as k, autor as a, pisac as p, iznajmljivanje as i, primjerakknjige as pk, ocjena as o
					WHERE p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis AND o.idknjigaopis=k.idknjigaopis
					GROUP BY k.idknjigaopis ORDER BY ocjena DESC LIMIT 0,10");
	print "<br><br>";
	
	$brojac=1;
	print "<h3>NAJBOLJE OCIJENJENE KNJIGE</h3>";
	while ($knjiga=mysql_fetch_row($q02)) {
		$link="<a href=\"?sta=public/knjiga&knjiga=".$knjiga[0]."\">".$knjiga[1]."</a>";
		print $brojac.". ".$link." (".number_format($knjiga[4],2).") "." - ".$knjiga[3]." ".$knjiga[2]."<br>";
		$brojac++;
	}
	
	//10 najcitanijih knjiga
	$q03 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime, count(i.idiznajmljivanje) as broj
					FROM knjigaopis as k, autor as a, pisac as p, iznajmljivanje as i, primjerakknjige as pk
					WHERE p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis AND pk.idknjigaopis=k.idknjigaopis AND i.idprimjerakknjige=pk.idprimjerakknjige
				GROUP BY k.idknjigaopis ORDER BY broj DESC LIMIT 0,10");
	print "<br><br>";
	
	$brojac=1;
	print "<h3>NAJCITANIJE KNJIGE</h3>";
	while ($knjiga=mysql_fetch_row($q03)) {
		$link="<a href=\"?sta=public/knjiga&knjiga=".$knjiga[0]."\">".$knjiga[1]."</a>";
		print $brojac.". ".$link." - ".$knjiga[3]." ".$knjiga[2]."<br>";
		$brojac++;
	}
	
				
}
?>