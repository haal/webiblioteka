<?

function admin_knjige() {

global $userid;

$knjiga = intval($_REQUEST['knjiga']);


//dodavanje nove knjige
if ($_REQUEST['akcija'] == 'dodajknjigu') {
	
	$naslov = my_escape($_POST['naslov']);
	$podnaslov = my_escape($_POST['podnaslov']);
	$isbn = $_POST['isbn'];
	$izdanje = my_escape($_POST['izdanje']);
	$jezik = my_escape($_POST['jezik']);
	$godina = intval($_POST['godina']);
	$opis = my_escape($_POST['opis']);
	$zanr = intval($_POST['zanr']);		//idZanr
	$autor = intval($_POST['autor']);	//idAutor
	$broj = intval($_POST['broj']);
	$vrijeme = time();
	
	$q01 = myquery("INSERT INTO knjigaopis ( Naslov, Podnaslov, ISBN, Izdanje, Opis, Jezik, GodinaIzdavanja, DatumUlaza, idZanr, BrojPrimjeraka)
	VALUES ('$naslov','$podnaslov','$isbn', '$izdanje', '$opis', '$jezik', '$godina', FROM_UNIXTIME('$vrijeme') ,'$zanr', '$broj')");
	
	$q02 = myquery("SELECT idKnjigaOpis FROM knjigaopis WHERE isbn=$isbn"); //upit koji nam daje id knjige koju dodajemo, potreban zbog umetanja u tabelu pisac
	
	$knjiga = mysql_result($q02,0,0);
	$insert = myquery("INSERT INTO pisac ( idAutor, idKnjigaOpis ) VALUES ( '$autor', '$knjiga' )");
	
?>
	<script language="JavaScript">
		window.location="?sta=admin/knjige";
	</script>
<?
}



//u ovoj akciji se samo iz baze podataka uzimaju vrijednosti, konkretna promjena se vrsi u akciji "izmijeniknjigu"
if ($_REQUEST["akcija"]=="edit")
{
	if ($knjiga) {	
	$q03=myquery("SELECT naslov, podnaslov, isbn, izdanje, opis, jezik, godinaizdavanja, idzanr, brojprimjeraka
				  FROM knjigaopis WHERE idKnjigaOpis=$knjiga");
	$q04=myquery("SELECT idAutor FROM pisac WHERE idKnjigaOpis=$knjiga");
	$naslov = mysql_result($q03,0,0);
	$podnaslov = mysql_result($q03,0,1);
	$isbn = mysql_result($q03,0,2);
	$izdanje = mysql_result($q03,0,3);
	$opis = mysql_result($q03,0,4);
	$jezik = mysql_result($q03,0,5);
	$godina = mysql_result($q03,0,6);
	$zanr = mysql_result($q03,0,7);
	$broj = mysql_result($q03,0,8);
	$autor = mysql_result($q04,0,0);
	}

}

//izmjena postojeceg ispitnog termina

if ($_POST['akcija'] == 'izmijeniknjigu') {

if($knjiga){

	$naslov = my_escape($_POST['naslov']);
	$podnaslov = my_escape($_POST['podnaslov']);
	$isbn = $_POST['isbn'];
	$izdanje = my_escape($_POST['izdanje']);
	$jezik = my_escape($_POST['jezik']);
	$godina = intval($_POST['godina']);
	$opis = my_escape($_POST['opis']);
	$zanr = intval($_POST['zanr']);
	$autor = intval($_POST['autor']);
	$broj = intval($_POST['broj']);
   
//Provjera ispravnosti
	if ($broj<=0){
		niceerror("Broj primjeraka mora biti veci od nule");
		return 0;
	}
	if ($godina<=0 || $godina>=2009){
		niceerror("Neispravna godina izdavanja knjige");
		return 0;
	}
		$sqlUpdate="UPDATE knjigaopis SET naslov='$naslov' , podnaslov='$podnaslov' , isbn='$isbn', izdanje='$izdanje', opis='$opis', jezik='$jezik', godinaizdavanja='$godina', idzanr='$zanr', brojprimjeraka='$broj' WHERE idknjigaopis='$knjiga'";
		$q05=myquery($sqlUpdate);
		
}
?>
		<script language="JavaScript">
		window.location="?sta=admin/knjige";
		</script>
<?
}



// akcija brisanja knjige - opcija "ukloni"
if ($_REQUEST["akcija"]=="ukloni")
{
	if ($knjiga) {
	$delete1="DELETE FROM knjigaOpis WHERE idKnjigaOpis=" . $knjiga;
	$delete2="DELETE FROM primjerakKnjige WHERE idKnjigaOpis=" . $knjiga;
	myquery($delete1);
	myquery($delete2);
	}
?>
	<script language="JavaScript">
		window.location="?sta=admin/knjige";
	</script>
<?
}





//kod tabele koja prikazuje sve knjige
$q01 = myquery("SELECT idKnjigaOpis, naslov FROM knjigaopis");

?>
<b>Knjige koje su trenutno unesene u bazu podataka:</b>
<br><br>
<table width="580" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=410><b>Naslov knjige</b></td>
    <td width=150 align="center"><b>Opcije</b></td>
	</tr>

<?php
$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {

?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$knjiga[1]; ?></td>
	<td align="center">
			<a href="?sta=admin/knjige&akcija=ukloni&knjiga=<?php echo $knjiga[0];?> ">Ukloni</a>&nbsp;&nbsp;&nbsp;
			<a href="?sta=admin/knjige&akcija=edit&knjiga=<?php echo $knjiga[0];?> ">Edituj</a>
	</tr>

<?php
$brojac++;
}

print "</table>";

if($brojac==1) print "<p><font color=\"#FF0000\">Trenutno nema knjiga u bazi podataka.</font></p>";




//upiti koje koriste select objekti u formi za dodavanje nove knjige
$q02 = myquery("SELECT idAutor, ime, prezime FROM autor");
$q03 = myquery("SELECT idZanr, naziv FROM zanr");



//forma za dodavanje nove knjige u biblioteku
?><br><br><hr><br>
<?
	if ($_REQUEST["akcija"]=="edit") print '<b>Izmjena postojece knjige:</b><br><br>';
	else print '<b>Dodavanje nove knjige:</b><br><br>';?>
	<?=genform("POST");?>
<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="hidden" name="akcija" value="izmijeniknjigu">';
	else print '<input type="hidden" name="akcija" value="dodajknjigu">';
?>
	Naslov:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="naslov" size="50" value="<?=$naslov?>"><br>
	Podnaslov:<input type="text" name="podnaslov" size="50" value="<?=$podnaslov?>"><br>
	ISBN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="isbn" size="13" value="<?=$isbn?>"><br>
	Izdanje:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="izdanje" size="5" value="<?=$izdanje?>"><br>
	Jezik:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="jezik" size="20" value="<?=$jezik?>"><br><br>
	Pisac:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="autor" class="default"><?
	while ($r02=mysql_fetch_row($q02)) {
		$temp=$r02[1]." ".$r02[2];
		print "<option value=\"$r02[0]\"";
		if (($_REQUEST["akcija"]=="edit") && ($r02[0]==$autor)) print " selected";
		print ">$temp</option>";
	}
	?></select>
	<br><br>Zanr:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="zanr" class="default"><?
	while ($r03=mysql_fetch_row($q03)) {
		print "<option value=\"$r03[0]\"";
		if (($_REQUEST["akcija"]=="edit") && ($r03[0]==$zanr)) print " selected";
		print ">$r03[1]</option>";
	}
	?></select><br><br>
	Godina izdavanja:<input type="text" name="godina" size="2" value="<?=$godina?>"><br>
	Broj primjeraka:&nbsp;<input type="text" name="broj" size="2" value="<?=$broj?>"><br>
	<br>Opis:<br><br><textarea name="opis" cols="50" rows="10" ><?=$opis?></textarea><br><br>
<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="submit" value="Potvrdi izmjene"  class="default"><br><br><a href="?sta=admin/knjige"><<< Nazad</a>';
	else print '<input type="submit" value="Dodaj knjigu"  class="default">';
?>
</form>


<?

}

?>
