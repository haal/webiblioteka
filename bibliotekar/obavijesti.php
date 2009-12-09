<?

function bibliotekar_obavijesti() {

global $userid;

$obavijest = intval($_REQUEST['obavijest']);

//dodavanje nove knjige
if ($_REQUEST['akcija'] == 'dodajobavijest') {
	
	$naslov = my_escape($_POST['naslov']);
	$tekst = my_escape($_POST['tekst']);
	$datum = date("y-m-d");
	$osoba = intval($_POST['osoba']);	//idOsoba
	$poslovnica = intval($_POST['poslovnica']);	//idPoslovnica
	
$q011 = myquery("INSERT INTO obavijest ( Naslov, Tekst, Datum, idOsoba, idPoslovnica) VALUES ('$naslov','$tekst', '$datum', '$userid', '$poslovnica')");

$q02 = myquery("SELECT idObavijest FROM obavijest ORDER BY datum LIMIT 1"); //upit koji nam daje id obavijesti koju dodajemo, potreban kasnije
$obavijest=mysql_result($q02,0,0);

?>
	<script language="JavaScript">
		window.location="?sta=bibliotekar/obavijesti";
	</script>
	
<?
}

//u ovoj akciji se samo iz baze podataka uzimaju vrijednosti, konkretna promjena se vrsi u akciji "izmijeniobavijest"
if ($_REQUEST["akcija"]=="edit")
{
	if ($obavijest) {	
	$q03=myquery("SELECT naslov, tekst, datum, idOsoba, idPoslovnica
				  FROM obavijest WHERE idObavijest=$obavijest");
	$naslov = mysql_result($q03,0,0);
	$tekst = mysql_result($q03,0,1);
	$datum = mysql_result($q03,0,2);
	$osoba = mysql_result($q03,0,3);
	$poslovnica = mysql_result($q03,0,4);
	}

}

//izmjena postojece obavijesti

if ($_POST['akcija'] == 'izmijeniobavijest') {

if($obavijest){

	$naslov = my_escape($_POST['naslov']);
	$tekst = my_escape($_POST['tekst']);
	//$datum = date("y-m-d");
	$osoba = my_escape($_POST['osoba']);
	$poslovnica = intval($_POST['poslovnica']);
	
   
		$sqlUpdate1="UPDATE obavijest SET naslov='$naslov' , tekst='$tekst' , idPoslovnica='$poslovnica' WHERE idobavijest='$obavijest'";
		$q05=myquery($sqlUpdate1);
	
}
?>

		<script language="JavaScript">
		window.location="?sta=bibliotekar/obavijesti";
		</script>
		
<?
}



// akcija brisanja obavijesti - opcija "ukloni"
if ($_REQUEST["akcija"]=="ukloni")
{
	if ($obavijest) {
	$delete1="DELETE FROM obavijest WHERE idObavijest=" . $obavijest;
	myquery($delete1);
	}
?>
	<script language="JavaScript">
		window.location="?sta=bibliotekar/obavijesti";
	</script>
<?
}


//kod tabele koja prikazuje sve obavijesti

$q01 = myquery("SELECT o.idObavijest, o.naslov, o.datum, p.naziv FROM obavijest o, poslovnica p WHERE o.idPoslovnica=p.idPoslovnica");

?>

<b>Obavijesti koje su trenutno unesene u bazu podataka:</b>
<br><br>
<table width="730" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=410><b>Naslov obavijesti</b></td>
    <td width=50><b>Datum</b></td>
	<td width=100><b>Poslovnica</b></td>
	<td width=150 align="center"><b>Opcije</b></td>
	</tr>

<?php
$brojac=1;

while ($obavijest=mysql_fetch_row($q01)) {

?>

<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$obavijest[1]; ?></td>
	<td><?=$obavijest[2]; ?></td>
	<td><?=$obavijest[3]; ?></td>
	<td align="center">
		<a href="?sta=bibliotekar/obavijesti&akcija=ukloni&obavijest=<?php echo $obavijest[0];?> ">Ukloni</a>&nbsp;&nbsp;&nbsp;
		<a href="?sta=bibliotekar/obavijesti&akcija=edit&obavijest=<?php echo $obavijest[0];?> ">Edituj</a></td>
	</td>
</tr>

<?php
$brojac++;
}

print "</table>";

if($brojac==1) print "<p><font color=\"#FF0000\">Trenutno nema obavijesti u bazi podataka.</font></p>";

//upiti koje koriste select objekti u formi za dodavanje nove obavijesti
$q02 = myquery("SELECT idPoslovnica, naziv FROM poslovnica");

//forma za dodavanje nove knjige u biblioteku
?>
<br><br><hr><br>
<?
	if ($_REQUEST["akcija"]=="edit") print '<b>Izmjena postojece obavijesti:</b><br><br>';
	else print '<b>Dodavanje nove obavijesti:</b><br><br>';?>
	<?=genform("POST");?>
<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="hidden" name="akcija" value="izmijeniobavijest">';
	else print '<input type="hidden" name="akcija" value="dodajobavijest">';
?>
	Naslov:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="naslov" size="50" value="<?=$naslov?>"><br>
	Tekst:<br><textarea name="tekst" cols="50" rows="10" ><?=$tekst?></textarea><br><br>
	Poslovnica: &nbsp;<select name="poslovnica" class="default"><?
	while ($r02=mysql_fetch_row($q02)) {
		print "<option value=\"$r02[0]\"";
		if (($_REQUEST["akcija"]=="edit") && ($r02[0]==$obavijest)) print " selected";
		print ">$r02[1]</option>";
	}
	?></select><br><br>
<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="submit" value="Potvrdi izmjene"  class="default"><br><br><a href="?sta=bibliotekar/obavijesti"><<< Nazad</a>';
	else print '<input type="submit" value="Dodaj obavijest"  class="default">';
?>
</form>

<?

}

?>