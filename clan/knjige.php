<?

function clan_knjige() {

global $userid;

$knjiga = intval($_REQUEST['knjiga']);



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



//forma - tabela i "search" dio
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
	
	$vrijednost = my_escape($_POST['vrijednost']);
	$tippretrage = intval($_POST['tippretrage']);
	
	if($tippretrage==0)
	$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime FROM knjigaopis as k, autor as a, pisac as p WHERE upper(k.naslov) LIKE'%$vrijednost%' AND p.idknjigaopis=k.idknjigaopis AND p.idautor=a.idautor");
	if($tippretrage==1)
	$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime FROM knjigaopis as k, autor as a, pisac as p WHERE upper(a.prezime) LIKE'%$vrijednost%' AND p.idknjigaopis=k.idknjigaopis AND p.idautor=a.idautor");
	if($tippretrage==2)
	$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime FROM knjigaopis as k, autor as a, pisac as p WHERE upper(a.ime) LIKE'%$vrijednost%' AND p.idknjigaopis=k.idknjigaopis AND p.idautor=a.idautor");

?>
	<table width=720" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=410><b>Naslov knjige</b></td>
	<td width=150 align="center"><b>Autor</b></td>
	<td width=40 align="center"><b>Ostalo</b></td>
    <td width=100 align="center"><b>Opcije</b></td>
	</tr>

<?
$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {
	
	$q02 = myquery("COUNT (*) FROM primjerakknjige WHERE idknjigaopis=$knjiga[0] AND status=0");
	$broj = mysql_result($q02,0,0);

?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$knjiga[1]; ?></td>
	<td align="center"><? print $knjiga[2] . " " . $knjiga[3]; ?></td>
	<td><?=$broj; ?></td>
	<td align="center">
			<? print "<a href=\"?sta=clan/knjige&akcija=iznajmi&knjiga=<?=$knjiga[0];?> \">Iznajmi</a>&nbsp;&nbsp;&nbsp;"
			?>
	</tr>

<?php
$brojac++;
}

print "</table>";

}

}

?>