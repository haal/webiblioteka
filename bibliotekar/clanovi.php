<?

function bibliotekar_clanovi() {

global $userid;

$clan = intval($_REQUEST['clan']);


//dodavanje novog clana
if ($_REQUEST['akcija'] == 'dodajclana') {
	
	$ime = my_escape($_POST['ime']);
	$prezime = my_escape($_POST['prezime']);
	$jmbg = my_escape($_POST['jmbg']);
	$adresa = $_POST['adresa'];
	$pbroj = intval($_POST['pbroj']);
	$grad = my_escape($_POST['grad']);
	$telefon = $_POST['telefon'];
	$email = $_POST['email'];
	$username = my_escape($_POST['username']);
	$pass = my_escape($_POST['pass']);
	$odobren = intval($_POST['odobren']);
	$poslovnica = intval($_POST['poslovnica']);
	
	//provjera da li vec postoji korisnicko ime ili jmbg
	$q00 = myquery("SELECT korisnickoime FROM auth WHERE korisnickoime='$username'");
	$q001 = "SELECT JMBG FROM osoba WHERE jmbg='$jmbg'";
	if (mysql_num_rows($q00)>=1) {
		niceerror("Korisničko ima nije slobodno!");
	} 
	else if (mysql_num_rows($q001)>=1){
		niceerror("Osoba sa unesenim JMBG-om već postoji u bazi!");
	}
	// dodajemo korisnika	
	else {
	$q01 = myquery("INSERT INTO auth ( korisnickoime, sifra, odobren ) VALUES ( '$username', '$pass', 0 )"); //korisnika mora odobriti admin
	$q02 = myquery("SELECT idauth FROM auth WHERE korisnickoime='$username'"); //da mozemo povezati osobu sa auth
	$auth = mysql_result($q02,0,0);
	$q03 = myquery("INSERT INTO osoba ( Ime, Prezime, JMBG, UlicaIBroj, PostanskiBroj, Grad, Telefon, email, idauth, idposlovnica)
	VALUES ('$ime', '$prezime', '$jmbg', '$adresa', '$pbroj', '$grad', '$telefon', '$email', '$auth', 1)");
	$q04 = myquery("SELECT idOsoba FROM osoba WHERE idAuth='$auth'");
	$idOsoba = mysql_result($q04,0,0);
	$q05 = myquery("INSERT INTO tiposobe (idtiposobe, naziv) VALUES ('$idOsoba','clan')");
	nicemessage("Uspješan unos novog člana.");
	}
	
	/*$q01 = myquery("INSERT INTO auth ( korisnickoime, sifra, odobren ) VALUES ( '$username', '$pass', '$odobren' )");
	$q02 = myquery("SELECT idauth FROM auth WHERE korisnickoime='$username'");
	$auth = mysql_result($q02,0,0);

	$q03 = myquery("INSERT INTO osoba ( Ime, Prezime, JMBG, UlicaIBroj, PostanskiBroj, Grad, Telefon, email, idauth, idposlovnica)
	VALUES ('$ime', '$prezime', '$jmbg', '$adresa', '$pbroj', '$grad', '$telefon', '$email', '$auth', '$poslovnica')");
	$q19 = myquery("SELECT idosoba FROM osoba WHERE ime='$ime' AND prezime='$prezime' AND jmbg='$jmbg'");
	$id = mysql_result($q19,0,0);
	
	$q20 = myquery("INSERT INTO tiposobe ( idtiposobe, naziv) VALUES ('$id', 'clan')");*/
	
?>
	<script language="JavaScript">
		window.location="?sta=bibliotekar/clanovi";
	</script>
<?
}



//u ovoj akciji se samo iz baze podataka uzimaju vrijednosti
if ($_REQUEST["akcija"]=="edit")
{
	if ($clan) {	
	$q04=myquery("SELECT Ime, Prezime, jmbg, UlicaIBroj, PostanskiBroj, Grad, Telefon, email, idposlovnica, idauth
				  FROM osoba WHERE idosoba=$clan");
	$ime = mysql_result($q04,0,0);
	$prezime = mysql_result($q04,0,1);
	$jmbg = mysql_result($q04,0,2);
	$adresa = mysql_result($q04,0,3);
	$pbroj = mysql_result($q04,0,4);
	$grad = mysql_result($q04,0,5);
	$telefon = mysql_result($q04,0,6);
	$email = mysql_result($q04,0,7);
	$poslovnica = mysql_result($q04,0,8);
	$auth = mysql_result($q04,0,9);
	$q05=myquery("SELECT korisnickoime, sifra, odobren FROM auth WHERE idauth=$auth");
	$username = mysql_result($q05,0,0);
	$pass = mysql_result($q05,0,1);
	$odobren = mysql_result($q05,0,2);
	}

}

// akcija brisanja
if ($_REQUEST["akcija"]=="ukloni")
{
	if ($clan) {
	$q12 = myquery("SELECT idauth FROM osoba WHERE idosoba=$clan");
	$auth = mysql_result($q12,0,0);
	
	$delete1="DELETE FROM osoba WHERE idosoba=" . $clan;
	myquery($delete1);
	
	$delete2="DELETE FROM auth WHERE idauth=" . $auth;
	myquery($delete2);
	
	$delete3="DELETE FROM tiposobe WHERE idtiposobe=" . $clan;
	myquery($delete3);
	}
?>
	<script language="JavaScript">
		window.location="?sta=bibliotekar/clanovi";
	</script>
<?
}


//akcija koja upisuje u bazu podatke s forme, vrsi konkretne promjene, dok akcija "edit" samo uzima podatke iz baze i stavlja ih na formu
if ($_REQUEST['akcija'] == 'izmijeniclana') {

if($clan){

	$ime = my_escape($_POST['ime']);
	$prezime = my_escape($_POST['prezime']);
	$jmbg = my_escape($_POST['jmbg']);
	$adresa = $_POST['adresa'];
	$pbroj = intval($_POST['pbroj']);
	$grad = my_escape($_POST['grad']);
	$telefon = $_POST['telefon'];
	$email = $_POST['email'];
	$username = my_escape($_POST['username']);
	$pass = my_escape($_POST['pass']);
	$odobren = intval($_POST['odobren']);
	$poslovnica = intval($_POST['poslovnica']);
   
	$sqlUpdate1="UPDATE osoba SET ime='$ime' ,prezime='$prezime' ,jmbg='$jmbg' , UlicaIBroj='$adresa' , postanskibroj='$pbroj', grad='$grad', telefon='$telefon', email='$email', idposlovnica='$poslovnica' WHERE idosoba='$clan'";
	$q06=myquery($sqlUpdate1);//update u tabeli osoba
	
	$q11 = myquery("SELECT idauth FROM osoba WHERE idosoba='$clan'");
	$auth = mysql_result($q11,0,0);//ovim upitom trazimo vezu izmedju tabela auth i osoba, treba nam za update username i pass
	
	$sqlUpdate2="UPDATE auth SET korisnickoime='$username', sifra='$pass', odobren='$odobren' WHERE idauth='$auth'";//update username i pass
	$q07=myquery($sqlUpdate2);
		
}
?>
		<script language="JavaScript">
		window.location="?sta=bibliotekar/clanovi";
		</script>
<?
}


//kod tabele koja prikazuje sve clanove
$q08 = myquery("SELECT o.idOsoba, o.ime, o.prezime FROM osoba as o, tiposobe as t WHERE t.idtiposobe=o.idosoba AND t.naziv='clan'");

?>
<b>Članovi koji su trenutno registrovani:</b><br><br>
<table width="420" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td align="center" width=20><b>R.br.</b></td>
	<td align="center" width=250><b>Ime i prezime</b></td>
    <td width=150 align="center"><b>Opcije</b></td>
	</tr>

<?php
$brojac=1;
while ($clan=mysql_fetch_row($q08)) 
{
?>
	<tr>
	<td align="center"><? print "$brojac"; ?></td>
	<td align="center"><? print $clan[1] . " " . $clan[2]; ?></td>
	<td align="center">
	<a href="?sta=bibliotekar/clanovi&akcija=ukloni&clan=<?=$clan[0];?>">Ukloni</a>&nbsp;&nbsp;&nbsp;<a href="?sta=bibliotekar/clanovi&akcija=edit&clan=<?=$clan[0];?>">Edituj</a>	
	</td></tr>
<?
	$brojac++;
}

print "</table><br>";
if($brojac==1) print "<p><font color=\"#FF0000\">Trenutno nema registrovanih članova.</font></p><br>";
print "<hr><br>";
?>
<script type="text/javascript" src="js/validateClan.js"></script>
<?	
	$q09 = myquery("SELECT idPoslovnica, naziv FROM poslovnica");

    print genform("POST", "clan", "validateClan");
	if ($_REQUEST["akcija"]=="edit") print '<input type="hidden" name="akcija" value="izmijeniclana">';
	else print '<input type="hidden" name="akcija" value="dodajclana">';
?>
	Ime:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="ime" size="30" value="<?=$ime?>"><br>
	Prezime:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="prezime" size="30" value="<?=$prezime?>"><br>
	JMBG:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="jmbg" size="13" maxlength="13" value="<?=$jmbg?>"><br>
	Ulica i broj:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="adresa" size="50" value="<?=$adresa?>"><br>
	Poštanski broj:&nbsp;<input type="text" name="pbroj" size="5" maxlength="5" value="<?=$pbroj?>"><br>
	Grad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grad" size="30" value="<?=$grad?>"><br>
	Telefon:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="telefon" size="15" value="<?=$telefon?>"><br>
	E-mail:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email" size="20" value="<?=$email?>">
	<br><br>Poslovnica:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="poslovnica" class="default"><?
	while ($r09=mysql_fetch_row($q09)) {
		print "<option value=\"$r09[0]\"";
		if (($_REQUEST["akcija"]=="edit") && ($r03[0]==$poslovnica)) print " selected";
		print ">$r09[1]</option>";
	}
	?></select><br>
	<br>
	Korisničko ime:<input type="text" name="username" size="20" value="<?=$username?>"><br>
	Šifra:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="pass" size="20" value="<?=$pass?>"><br><br>
	Odobren:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="odobren" class="default"><?
		print "<option value=";
		print "0";
		print ">NE</option>";
		print "<option value=";
		print "1";
		if ((!$clan) && ($odobren==1)) print " selected";
		print ">DA</option>";
	?></select><br><br>
<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="submit" value="Potvrdi izmjene"  class="default">
	<br><br><a href="?sta=bibliotekar/clanovi">Unos novog člana</a>';
	else print '<input type="submit" value="Dodaj člana"  class="default">';
?>
</form>


<?
}
?>