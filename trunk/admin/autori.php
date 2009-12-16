<?

function admin_autori() {

global $userid;

$autor = intval($_REQUEST['autor']);

//dodavanje novog autora
if ($_REQUEST['akcija'] == 'dodajautora') {
	
	$ime = my_escape($_POST['ime']);
	$prezime = my_escape($_POST['prezime']);
	$biografija = my_escape($_POST['biografija']);
	
$q011 = myquery("INSERT INTO autor ( Ime, Prezime, Biografija) VALUES ('$ime','$prezime', '$biografija')");

$q02 = myquery("SELECT idAutor FROM autor ORDER BY idAutor DESC LIMIT 1"); //upit koji nam daje id autora koju dodajemo, potreban kasnije
$zanr=mysql_result($q02,0,0);

?>
	<script language="JavaScript">
		window.location="?sta=admin/autori";
	</script>
	
<?
}

//u ovoj akciji se samo iz baze podataka uzimaju vrijednosti, konkretna promjena se vrsi u akciji "izmijenautora"
if ($_REQUEST["akcija"]=="edit")
{
	if ($autor) {	
	$q03=myquery("SELECT ime, prezime, biografija
				  FROM autor WHERE idAutor=$autor");
	$ime = mysql_result($q03,0,0);
	$prezime = mysql_result($q03,0,1);
	$biografija = mysql_result($q03,0,1);
	}

}

//izmjena postojeceg zanra

if ($_POST['akcija'] == 'izmijeniautora') {

if($autor){

	$ime = my_escape($_POST['ime']);
	$prezime = my_escape($_POST['prezime']);
	$biografija = my_escape($_POST['biografija']);
		
   
		$sqlUpdate1="UPDATE autor SET ime='$ime' , prezime='$prezime', biografija='$obiografija'  WHERE idautor='$autor'";
		$q05=myquery($sqlUpdate1);
	
}
?>

		<script language="JavaScript">
		window.location="?sta=admin/autori";
		</script>
		
<?
}



// akcija brisanja autora - opcija "ukloni"
if ($_REQUEST["akcija"]=="ukloni")
{
	if ($autor) {
	$delete1="DELETE FROM autor WHERE idAutor=" . $autor;
	myquery($delete1);
	}
?>
	<script language="JavaScript">
		window.location="?sta=admin/autori";
	</script>
<?
}


//kod tabele koja prikazuje sve autore

$q01 = myquery("SELECT a.idAutor, a.Prezime, a.Ime FROM autor a");

?>

<b>Autori koji su trenutno uneseni u bazu podataka:</b>
<br><br>
<table width="440" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=270><b>Prezime i ime</b></td>
    <td width=150 align="center"><b>Opcije</b></td>
	</tr>

<?php
$brojac=1;

while ($autor=mysql_fetch_row($q01)) {

?>

<tr>
	<td><? print "$brojac"; ?></td>
	<td><? print $autor[1] . " " . $autor[2]; ?></td>
	<td align="center">
		<a href="?sta=admin/autori&akcija=ukloni&autor=<?php echo $autor[0];?> ">Ukloni</a>&nbsp;&nbsp;&nbsp;
		<a href="?sta=admin/autori&akcija=edit&autor=<?php echo $autor[0];?> ">Edituj</a></td>
	</td>
</tr>

<?php
$brojac++;
}

print "</table>";

if($brojac==1) print "<p><font color=\"#FF0000\">Trenutno nema autora u bazi podataka.</font></p>";


//forma za dodavanje autora u biblioteku
?>
<br><br><hr><br>
<script type="text/javascript" src="js/validateAutor.js"></script>
<?
	if ($_REQUEST["akcija"]=="edit") print '<b>Izmjena postojeceg autora:</b><br><br>';
	else print '<b>Dodavanje novog autora:</b><br><br>';?>
	<?=genform("POST", "autor", "validateAutor");?>
<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="hidden" name="akcija" value="izmijeniautora">';
	else print '<input type="hidden" name="akcija" value="dodajautora">';
?>
	Ime:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="ime" size="30" value="<?=$ime?>"><br>
	Prezime:&nbsp;<input type="text" name="prezime" size="30" value="<?=$prezime?>"><br><br>
	Biografija:<br><textarea name="biografija" cols="50" rows="10" ><?=$biografija?></textarea><br><br>
	<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="submit" value="Potvrdi izmjene"  class="default"><br><br><a href="?sta=admin/autori"><<< Nazad</a>';
	else print '<input type="submit" value="Dodaj autora"  class="default">';
?>
</form>

<?

}

?>