<?

function admin_poslovnice() {

global $userid;

$poslovnica = intval($_REQUEST['poslovnica']);


//dodavanje nove poslovnice
if ($_REQUEST['akcija'] == 'dodajposlovnicu') {
	
	$naziv = my_escape($_POST['naziv']);
	$adresa = $_POST['adresa'];
	$pbroj = intval($_POST['pbroj']);
	$grad = my_escape($_POST['grad']);
	$telefon = $_POST['telefon'];
	$email = $_POST['email'];

	$q01 = myquery("INSERT INTO poslovnica ( Naziv, UlicaIBroj, PostanskiBroj, Grad, Telefon, email, idbiblioteka)
	VALUES ('$naziv','$adresa','$pbroj', '$grad', '$telefon', '$email', 1)");
	
?>
	<script language="JavaScript">
		window.location="?sta=admin/poslovnice";
	</script>
<?
}



//u ovoj akciji se samo iz baze podataka uzimaju vrijednosti
if ($_REQUEST["akcija"]=="edit")
{
	if ($poslovnica) {	
	$q02=myquery("SELECT Naziv, UlicaIBroj, PostanskiBroj, Grad, Telefon, email
				  FROM poslovnica WHERE idPoslovnica=$poslovnica");
	$naziv = mysql_result($q02,0,0);
	$adresa = mysql_result($q02,0,1);
	$pbroj = mysql_result($q02,0,2);
	$grad = mysql_result($q02,0,3);
	$telefon = mysql_result($q02,0,4);
	$email = mysql_result($q02,0,5);
	}

}

// akcija brisanja
if ($_REQUEST["akcija"]=="ukloni")
{
	if ($poslovnica) {
	$delete1="DELETE FROM osoba WHERE idosoba>1 AND idPoslovnica=" . $poslovnica;
	myquery($delete1);
	$delete2="DELETE FROM primjerakknjige WHERE idPoslovnica=" . $poslovnica;
	myquery($delete2);
	$delete3="DELETE FROM poslovnica WHERE idPoslovnica=" . $poslovnica;
	myquery($delete3);
	}
?>
	<script language="JavaScript">
		window.location="?sta=admin/poslovnice";
	</script>
<?
}


//akcija koja upisuje u bazu podatke s forme, vrsi konkretne promjene, dok akcija "edit" samo uzima podatke iz baze i stavlja ih na formu
if ($_POST['akcija'] == 'izmijeniposlovnicu') {

if($poslovnica){

	$naziv = my_escape($_POST['naziv']);
	$adresa = $_POST['adresa'];
	$pbroj = intval($_POST['pbroj']);
	$grad = my_escape($_POST['grad']);
	$telefon = $_POST['telefon'];
	$email = $_POST['email'];
   
	$sqlUpdate="UPDATE poslovnica SET Naziv='$naziv' , UlicaIBroj='$adresa' , postanskibroj='$pbroj', grad='$grad', telefon='$telefon', email='$email' WHERE idPoslovnica='$poslovnica'";
	$q05=myquery($sqlUpdate);
		
}
?>
		<script language="JavaScript">
		window.location="?sta=admin/poslovnice";
		</script>
<?
}


//kod tabele koja prikazuje sve poslovnice
$q01 = myquery("SELECT idPoslovnica, naziv, ulicaiBroj FROM poslovnica");

?>
<b>Poslovnice koje su trenutno registrovane:</b><br><br>
<table width="820" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td align="center" width=20><b>R.br.</b></td>
	<td align="center" width=250><b>Naziv poslovnice</b></td>
	<td align="center" width=400><b>Adresa</b></td>
    <td width=150 align="center"><b>Opcije</b></td>
	</tr>

<?php
$brojac=1;

while ($poslovnica=mysql_fetch_row($q01)) {

?>
	<tr>
	<td align="center"><? print "$brojac"; ?></td>
	<td align="center"><?=$poslovnica[1]; ?></td>
	<td align="center"><?=$poslovnica[2]; ?></td>
	<td align="center">
<? 
	if($brojac==1) print "<a href=\"?sta=admin/poslovnice&akcija=edit&poslovnica=$poslovnica[0]\">Edituj</a>";
	else print "<a href=\"?sta=admin/poslovnice&akcija=ukloni&poslovnica=$poslovnica[0]\">Ukloni</a>&nbsp;&nbsp;&nbsp;<a href=\"?sta=admin/poslovnice&akcija=edit&poslovnica=$poslovnica[0] \">Edituj</a>";	
?>
	</td></tr>

<?php
$brojac++;
}
if($brojac==1) print "<p><font color=\"#FF0000\">Trenutno nema registrovanih poslovnica.</font></p><br>";

?>
<script type="text/javascript" src="js/validatePoslovnica.js"></script>
</table><br><hr><br>

<?
    print genform("POST", "poslovnica", "validatePoslovnica");
	if ($_REQUEST["akcija"]=="edit") print '<input type="hidden" name="akcija" value="izmijeniposlovnicu">';
	else print '<input type="hidden" name="akcija" value="dodajposlovnicu">';
?>
	Naziv:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="naziv" size="30" value="<?=$naziv?>"><br>
	Ulica i broj:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="adresa" size="30" value="<?=$adresa?>"><br>
	Poštanski broj:&nbsp;<input type="text" name="pbroj" size="5" maxlength="5" value="<?=$pbroj?>"><br>
	Grad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grad" size="20" value="<?=$grad?>"><br>
	Telefon:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="telefon" size="15" value="<?=$telefon?>"><br>
	email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email" size="30" value="<?=$email?>"><br><br>
<?
	if ($_REQUEST["akcija"]=="edit") print '<input type="submit" value="Potvrdi izmjene"  class="default">
	<br><br><a href="?sta=admin/poslovnice">Nova poslovnica</a>';
	else print '<input type="submit" value="Dodaj poslovnicu"  class="default">';
?>
</form>


<?
}
?>