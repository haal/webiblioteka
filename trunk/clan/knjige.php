<?

function clan_knjige() {

global $userid;

$knjiga = intval($_REQUEST['knjiga']);




print '<b>Pretraga:</b><br><br>';?>
<?=genform("POST");?>

<input type="hidden" name="akcija" value="trazi">
Odaberi tip pretrage:<select name="tippretrage" class="default"><?
		print "<option value=";
		print "0";
		print ">Naslov knjige</option>";
		print "<option value=";
		print "1";
		print ">Prezime autora</option>";
		print "<option value=";
		print "2";
		print ">Ime autora</option>";
	?></select><br><br>
<input type="text" name="vrijednost" size="50">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search"  class="default"><br><br><hr><br>


</form>




<?

if ($_REQUEST['akcija'] == 'trazi') {
	
	$vrijednost = $_POST['vrijednost'];
	$tipretrage = intval($_POST['tippretrage']);
	
	if($tippretrage==0)
	$q01 = myquery("SELECT idknjigaopis, naslov FROM knjigaopis WHERE upper(naslov) LIKE'%$vrijednost%'");
	elseif($tippretrage==1)
	$q01 = myquery("SELECT idknjigaopis, naslov FROM knjigaopis WHERE upper(naslov) LIKE'%$vrijednost%'");
	elseif($tippretrage==2)
	$q01 = myquery("SELECT idknjigaopis, naslov FROM knjigaopis WHERE upper(naslov) LIKE'%$vrijednost%'");

?>
	<table width="580" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=410><b>Naslov knjige</b></td>
    <td width=150 align="center"><b>Opcije</b></td>
	</tr>

<?
$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {

?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$knjiga[1]; ?></td>
	<td align="center">
			<a href="?sta=clan/knjige&akcija=iznajmi&knjiga=<?=$knjiga[0];?> ">Iznajmi</a>&nbsp;&nbsp;&nbsp;
	</tr>

<?php
$brojac++;
}

print "</table>";

}

}

?>