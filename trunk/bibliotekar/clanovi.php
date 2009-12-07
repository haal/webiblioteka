<?

function bibliotekar_clanovi() {

global $userid;

$clan = intval($_REQUEST['clan']);

//dodavanje novog clana
if ($_REQUEST['akcija'] == 'dodajclana') {
	
	$ime = my_escape($_POST['ime']);
	$prezime = my_escape($_POST['prezime']);
	$jmbg = my_escape($_POST['jmbg']);
	$ulicaibroj = my_escape($_POST['ulicaibroj']);
	$postanskibroj = my_escape($_POST['postanskibroj']);
	$grad = my_escape($_POST['grad']);
	$telefon = my_escape($_POST['telefon']);
	$email = my_escape($_POST['email']);
	$status = my_escape($_POST['status']);
	$tiposobe = intval($_POST['tiposobe']);	//idTipOsobe
	$idauth = intval($_POST['idauth']);	//idAuth
	$poslovnica = intval($_POST['poslovnica']);	//idPoslovnica
	
$q011 = myquery("INSERT INTO osoba (Ime, Prezime, Jmbg, UlicaIBroj, PostanskiBroj, Grad, Telefon, Email, Status, idTipOsobe,  idPoslovnica) VALUES ('$ime','$prezime', '$jmbg', '$ulicaibroj', '$postanskibroj', '$grad', '$telefon', '$email', '$status', '$tiposobe', '$poslovnica')");

$q02 = myquery("SELECT idOsoba FROM osoba WHERE jmbg='$jmbg'"); //upit koji nam daje id clana kojeg dodajemo, potreban kasnije
$clan=mysql_result($q02,0,0);

?>

<script language="JavaScript">
		window.location="?sta=bibliotekar/clanovi";
	</script>
<?
}



//u ovoj akciji se samo iz baze podataka uzimaju vrijednosti, konkretna promjena se vrsi u akciji "izmijeniclana"
if ($_REQUEST["akcija"]=="edit")
{
	if ($clan) {
	$q03=myquery("SELECT Ime, Prezime, Jmbg, UlicaIBroj, PostanskiBroj, Grad, Telefon, Email, Status, idTipOsobe, idAuth, idPoslovnica
				  FROM osoba WHERE idOsoba=$clan");
	$ime = mysql_result($q03,0,0);
	$prezime = mysql_result($q03,0,1);
	$jmbg = mysql_result($q03,0,2);
	$ulicaibroj = mysql_result($q03,0,3);
	$postanskibroj = mysql_result($q03,0,4);
	$grad = mysql_result($q03,0,5);
	$telefon = mysql_result($q03,0,6);
	$email = mysql_result($q03,0,7);
	$status = mysql_result($q03,0,8);
	$tiposobe = mysql_result($q03,0,9);
	$idauth = mysql_result($q03,0,10);
	$poslovnica = mysql_result($q03,0,11);
	}

}

//izmjena postojeceg clana

if ($_POST['akcija'] == 'izmijeniclana') {

if($clan){
	
	$ime = my_escape($_POST['ime']);
	$prezime = my_escape($_POST['prezime']);
	$jmbg = my_escape($_POST['jmbg']);
	$ulicaibroj = my_escape($_POST['ulicaibroj']);
	$postanskibroj = my_escape($_POST['postanskibroj']);
	$grad = my_escape($_POST['grad']);
	$telefon = my_escape($_POST['telefon']);
	$email = my_escape($_POST['email']);
	$status = my_escape($_POST['status']);
	$tiposobe = intval($_POST['tiposobe']);
	$idauth = intval($_POST['idauth']);
	$poslovnica = intval($_POST['poslovnica']);	
	
   
//Provjera ispravnosti
/*	if ($broj<=0){
		niceerror("Broj primjeraka mora biti veci od nule");
		return 0;
	}
	if ($godina<=0 || $godina>=2009){
		niceerror("Neispravna godina izdavanja knjige");
		return 0;
	}*/
		$sqlUpdate1="UPDATE osoba SET ime='$ime' , prezime='$prezime' , jmbg='$jmbg', ulicaibroj='$ulicaibroj', postanskibroj='$postanskibroj', grad='$grad', telefon='$telefon', email='$email', status='$status', idtiposobe='$tiposobe', idposlovnica='$poslovnica' WHERE idOsoba='$clan'";
		$q05=myquery($sqlUpdate1);
		
}
?>
		<script language="JavaScript">
		window.location="?sta=bibliotekar/clanovi";
		</script>
<?
}



// akcija brisanja korisnika - opcija "ukloni"
if ($_REQUEST["akcija"]=="ukloni")
{
	if ($knjiga) {
	$delete1="DELETE FROM osoba WHERE idOsoba=" . $clan;
	//$delete2="DELETE FROM auth WHERE idOsoba=" . $knjiga; treba brisati i iz auth
	myquery($delete1);
	//myquery($delete2);
	}
?>
	<script language="JavaScript">
		window.location="?sta=bibliotekar/clanovi";
	</script>
<?
}





//kod tabele koja prikazuje sve clanove
$q01 = myquery("SELECT idOsoba, ime, prezime FROM osoba");

?>
<b>Clanovi koji su trenutno u bazi podataka:</b>
<br><br>
<table width="390" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=110><b>Ime</b></td>
	<td width=110><b>Prezime</b></td>
    <td width=150 align="center"><b>Opcije</b></td>
	</tr>

<?php
$brojac=1;

while ($clan=mysql_fetch_row($q01)) {

?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$clan[1]; ?></td>
	<td><?=$clan[2]; ?></td>
	<td align="center">
			<a href="?sta=bibliotekar/clanovi&akcija=ukloni&clan=<?php echo $clan[0];?> ">Ukloni</a>&nbsp;&nbsp;&nbsp;
			<a href="?sta=bibliotekar/clanovi&akcija=edit&clan=<?php echo $clan[0];?> ">Edituj</a></td>	
	</tr>

<?php
$brojac++;
}

print "</table>";

if($brojac==1) print "<p><font color=\"#FF0000\">Trenutno nema clanova u bazi podataka.</font></p><br>";



//upiti koje koriste select objekti u formi za dodavanje nove knjige
$q02 = myquery("SELECT idTipOsobe, naziv FROM tipOsobe");
$q03 = myquery("SELECT idPoslovnica, naziv FROM poslovnica");



//forma za dodavanje nove knjige u biblioteku
?><br><br><hr><br>
<?
	if ($_REQUEST["akcija"]=="edit") print '<b>Izmjena postojeceg clana:</b><br><br>';
	else print '<b>Dodavanje novog clana:</b><br><br>';?>
	<?=genform("POST");?>
<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="hidden" name="akcija" value="izmijeniclana">';
	else print '<input type="hidden" name="akcija" value="dodajclana">';
?>
	Ime:<input type="text" name="ime" size="50" value="<?=$ime?>"><br>
	Prezime: <input type="text" name="prezime" size="50" value="<?=$prezime?>"><br>
	Jmbg: <input type="text" name="jmbg" size="13" value="<?=$jmbg?>"><br>
	Ulica i broj: <input type="text" name="ulicaibroj" size="50" value="<?=$ulicaibroj?>"><br>
	Postanski broj: <input type="text" name="postanskibroj" size="5" value="<?=$postanskibroj?>"><br>
	Grad: <input type="text" name="grad" size="20" value="<?=$grad?>"><br>
	Telefon: <input type="text" name="telefon" size="13" value="<?=$telefon?>"><br>
	E-mail: <input type="text" name="email" size="20" value="<?=$email?>"><br>
	Status: <input type="text" name="status" size="50" value="<?=$status?>"><br>
	Tip osobe: <select name="tiposobe" class="default"><?
	while ($r02=mysql_fetch_row($q02)) {
		print "<option value=\"$r02[0]\"";
		if (($_REQUEST["akcija"]=="edit") && ($r02[0]==$tiposobe)) print " selected";
		print ">$r02[1]</option>";
	}
	?></select><br>
	Poslovnica: <select name="poslovnica" class="default"><?
	while ($r03=mysql_fetch_row($q03)) {
		print "<option value=\"$r03[0]\"";
		if (($_REQUEST["akcija"]=="edit") && ($r03[0]==$poslovnica)) print " selected";
		print ">$r03[1]</option>";
	}
	?></select><br>
<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="submit" value="Potvrdi izmjene"  class="default"><br><br><a href="?sta=bibliotekar/clanovi"><<< Nazad</a>';
	else print '<input type="submit" value="Dodaj clana"  class="default">';
?>
</form>


<?

}

?>
