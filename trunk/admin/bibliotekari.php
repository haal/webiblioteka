<?

function admin_bibliotekari() {

global $userid;

$bibliotekar = intval($_REQUEST['bibliotekar']);


//dodavanje novog bibliotekara
if ($_REQUEST['akcija'] == 'dodajbibliotekara') {
	
	$ime = my_escape($_POST['ime']);
	$prezime = my_escape($_POST['prezime']);
	$jmbg = intval($_POST['jmbg']);
	$adresa = $_POST['adresa'];
	$pbroj = intval($_POST['pbroj']);
	$grad = my_escape($_POST['grad']);
	$telefon = $_POST['telefon'];
	$email = $_POST['email'];
	$username = my_escape($_POST['username']);
	$pass = my_escape($_POST['pass']);
	$odobren = intval($_POST['odobren']);
	$poslovnica = intval($_POST['poslovnica']);
	
	$q01 = myquery("INSERT INTO auth ( korisnickoime, sifra, odobren ) VALUES ( '$username', '$pass', '$odobren' )");
	$q02 = myquery("SELECT idauth FROM auth WHERE korisnickoime='$username'");
	$auth = mysql_result($q02,0,0);

	$q03 = myquery("INSERT INTO osoba ( Ime, Prezime, JMBG, UlicaIBroj, PostanskiBroj, Grad, Telefon, email, idtiposobe, idauth, idposlovnica)
	VALUES ('$ime', '$prezime', '$jmbg', '$adresa', '$pbroj', '$grad', '$telefon', '$email', 2, '$auth', '$poslovnica')");
	
?>
	<script language="JavaScript">
		window.location="?sta=admin/bibliotekari";
	</script>
<?
}



//u ovoj akciji se samo iz baze podataka uzimaju vrijednosti
if ($_REQUEST["akcija"]=="edit")
{
	if ($bibliotekar) {	
	$q04=myquery("SELECT Ime, Prezime, jmbg, UlicaIBroj, PostanskiBroj, Grad, Telefon, email, idposlovnica, idauth
				  FROM osoba WHERE idosoba=$bibliotekar");
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
	if ($bibliotekar) {
	$q12 = myquery("SELECT idauth FROM osoba WHERE idosoba=$bibliotekar");
	$auth = mysql_result($q12,0,0);
	
	$delete1="DELETE FROM osoba WHERE idosoba=" . $bibliotekar;
	myquery($delete1);
	
	$delete2="DELETE FROM auth WHERE idauth=" . $auth;
	myquery($delete2);
	}
?>
	<script language="JavaScript">
		window.location="?sta=admin/bibliotekari";
	</script>
<?
}


//akcija koja upisuje u bazu podatke s forme, vrsi konkretne promjene, dok akcija "edit" samo uzima podatke iz baze i stavlja ih na formu
if ($_REQUEST['akcija'] == 'izmijenibibliotekara') {

if($bibliotekar){

	$ime = my_escape($_POST['ime']);
	$prezime = my_escape($_POST['prezime']);
	$jmbg = intval($_POST['jmbg']);
	$adresa = $_POST['adresa'];
	$pbroj = intval($_POST['pbroj']);
	$grad = my_escape($_POST['grad']);
	$telefon = $_POST['telefon'];
	$email = $_POST['email'];
	$username = my_escape($_POST['username']);
	$pass = my_escape($_POST['pass']);
	$odobren = intval($_POST['odobren']);
	$poslovnica = intval($_POST['poslovnica']);
   
	$sqlUpdate1="UPDATE osoba SET ime='$ime' ,prezime='$prezime' ,jmbg='$jmbg' , UlicaIBroj='$adresa' , postanskibroj='$pbroj', grad='$grad', telefon='$telefon', email='$email', idposlovnica='$poslovnica' WHERE idosoba='$bibliotekar'";
	$q06=myquery($sqlUpdate1);//update u tabeli osoba
	
	$q11 = myquery("SELECT idauth FROM osoba WHERE idosoba='$bibliotekar'");
	$auth = mysql_result($q11,0,0);//ovim upitom trazimo vezu izmedju tabela auth i osoba, treba nam za update username i pass
	
	$sqlUpdate2="UPDATE auth SET korisnickoime='$username', sifra='$pass', odobren='$odobren' WHERE idauth='$auth'";//update username i pass
	$q07=myquery($sqlUpdate2);
		
}
?>
		<script language="JavaScript">
		window.location="?sta=admin/bibliotekari";
		</script>
<?
}


//kod tabele koja prikazuje sve bibliotekare
$q08 = myquery("SELECT idOsoba, ime, prezime FROM osoba WHERE idtiposobe=2");

?>
<b>Bibliotekari koji su trenutno registrovani:</b><br><br>
<table width="420" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td align="center" width=20><b>R.br.</b></td>
	<td align="center" width=250><b>Ime i prezime</b></td>
    <td width=150 align="center"><b>Opcije</b></td>
	</tr>

<?php
$brojac=1;

while ($bibliotekar=mysql_fetch_row($q08)) {
?>
	
	<tr>
	<td align="center"><? print "$brojac"; ?></td>
	<td align="center"><? print $bibliotekar[1] . " " . $bibliotekar[2]; ?></td>
	<td align="center">
	<a href="?sta=admin/bibliotekari&akcija=ukloni&bibliotekar=<?=$bibliotekar[0];?>">Ukloni</a>&nbsp;&nbsp;&nbsp;<a href="?sta=admin/bibliotekari&akcija=edit&bibliotekar=<?=$bibliotekar[0];?>">Edituj</a>	
	</td></tr>

<?
	$brojac++;
}

print "</table><br>";
if($brojac==1) print "<p><font color=\"#FF0000\">Trenutno nema registrovanih bibliotekara.</font></p><br>";
print "<hr><br>";
	
	$q09 = myquery("SELECT idPoslovnica, naziv FROM poslovnica");	

    print genform("POST");
	if ($_REQUEST["akcija"]=="edit") print '<input type="hidden" name="akcija" value="izmijenibibliotekara">';
	else print '<input type="hidden" name="akcija" value="dodajbibliotekara">';
?>
	Ime:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="ime" size="30" value="<?=$ime?>"><br>
	Prezime:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="prezime" size="30" value="<?=$prezime?>"><br>
	JMBG:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="jmbg" size="30" value="<?=$jmbg?>"><br>
	Ulica i broj:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="adresa" size="50" value="<?=$adresa?>"><br>
	Postanski broj:&nbsp;<input type="text" name="pbroj" size="20" value="<?=$pbroj?>"><br>
	Grad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grad" size="5" value="<?=$grad?>"><br>
	Telefon:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="telefon" size="20" value="<?=$telefon?>"><br>
	email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email" size="20" value="<?=$email?>">
	<br><br>Poslovnica:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="poslovnica" class="default"><?
	while ($r09=mysql_fetch_row($q09)) {
		print "<option value=\"$r09[0]\"";
		if (($_REQUEST["akcija"]=="edit") && ($r03[0]==$poslovnica)) print " selected";
		print ">$r09[1]</option>";
	}
	?></select><br>
	<br>
	Korisnicko ime:<input type="text" name="username" size="20" value="<?=$username?>"><br>
	Sifra:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="pass" size="20" value="<?=$pass?>"><br><br>
	Odobren:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="odobren" class="default"><?
		print "<option value=";
		print "0";
		print ">NE</option>";
		print "<option value=";
		print "1";
		if ((!$bibliotekar) && ($odobren==1)) print " selected";
		print ">DA</option>";
	?></select><br><br>
<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="submit" value="Potvrdi izmjene"  class="default">
	<br><br><a href="?sta=admin/bibliotekari">Unos novog bibliotekara</a>';
	else print '<input type="submit" value="Dodaj bibliotekara"  class="default">';
?>
</form>


<?
}
?>