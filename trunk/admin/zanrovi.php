<?

function admin_zanrovi() {

global $userid;

$zanr = intval($_REQUEST['zanr']);

//dodavanje nove knjige
if ($_REQUEST['akcija'] == 'dodajzanr') {
	
	$naziv = my_escape($_POST['naziv']);
	$opis = my_escape($_POST['opis']);
	
$q011 = myquery("INSERT INTO zanr ( Naziv, Opis) VALUES ('$naziv','$opis')");

$q02 = myquery("SELECT idZanr FROM zanr ORDER BY idZanr DESC LIMIT 1"); //upit koji nam daje id zanra koju dodajemo, potreban kasnije
$zanr=mysql_result($q02,0,0);

?>
	<script language="JavaScript">
		window.location="?sta=admin/zanrovi";
	</script>
	
<?
}

//u ovoj akciji se samo iz baze podataka uzimaju vrijednosti, konkretna promjena se vrsi u akciji "izmijenizanr"
if ($_REQUEST["akcija"]=="edit")
{
	if ($zanr) {	
	$q03=myquery("SELECT naziv, opis
				  FROM zanr WHERE idZanr=$zanr");
	$naziv = mysql_result($q03,0,0);
	$opis = mysql_result($q03,0,1);
	}

}

//izmjena postojeceg zanra

if ($_POST['akcija'] == 'izmijenizanr') {

if($zanr){

	$naziv = my_escape($_POST['naziv']);
	$opis = my_escape($_POST['opis']);
		
   
		$sqlUpdate1="UPDATE zanr SET naziv='$naziv' , opis='$opis'  WHERE idzanr='$zanr'";
		$q05=myquery($sqlUpdate1);
	
}
?>

		<script language="JavaScript">
		window.location="?sta=admin/zanrovi";
		</script>
		
<?
}



// akcija brisanja zanra - opcija "ukloni"
if ($_REQUEST["akcija"]=="ukloni")
{
	if ($zanr) {
	$delete1="DELETE FROM zanr WHERE idZanr=" . $zanr;
	myquery($delete1);
	}
?>
	<script language="JavaScript">
		window.location="?sta=admin/zanrovi";
	</script>
<?
}


//kod tabele koja prikazuje sve zanrove

$q01 = myquery("SELECT z.idZanr, z.Naziv FROM zanr z");

?>

<b>Zanrovi koji su trenutno uneseni u bazu podataka:</b>
<br><br>
<table width="380" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=210><b>Naziv</b></td>
    <td width=150 align="center"><b>Opcije</b></td>
	</tr>

<?php
$brojac=1;

while ($zanr=mysql_fetch_row($q01)) {

?>

<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$zanr[1]; ?></td>
	<td align="center">
		<a href="?sta=admin/zanrovi&akcija=ukloni&zanr=<?php echo $zanr[0];?> ">Ukloni</a>&nbsp;&nbsp;&nbsp;
		<a href="?sta=admin/zanrovi&akcija=edit&zanr=<?php echo $zanr[0];?> ">Edituj</a></td>
	</td>
</tr>

<?php
$brojac++;
}

print "</table>";

if($brojac==1) print "<p><font color=\"#FF0000\">Trenutno nema zanrova u bazi podataka.</font></p>";


//forma za dodavanje zanra u biblioteku
?>
<br><br><hr><br>
<?
	if ($_REQUEST["akcija"]=="edit") print '<b>Izmjena postojeceg zanra:</b><br><br>';
	else print '<b>Dodavanje novog zanra:</b><br><br>';?>
	<?=genform("POST");?>
<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="hidden" name="akcija" value="izmijenizanr">';
	else print '<input type="hidden" name="akcija" value="dodajzanr">';
?>
	Naziv:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="naziv" size="50" value="<?=$naziv?>"><br>
	Opis:<br><textarea name="opis" cols="50" rows="10" ><?=$opis?></textarea><br><br>
	<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="submit" value="Potvrdi izmjene"  class="default"><br><br><a href="?sta=admin/zanrovi"><<< Nazad</a>';
	else print '<input type="submit" value="Dodaj zanr"  class="default">';
?>
</form>

<?

}

?>