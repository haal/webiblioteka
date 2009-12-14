<?

function clan_knjige() {

global $userid;

$knjiga = intval($_REQUEST['knjiga']);



// akcija brisanja knjige - opcija "ukloni"
if ($_REQUEST["akcija"]=="iznajmi")
{
	if ($knjiga) {
	$q04 = myquery("SELECT idprimjerakknjige FROM primjerakknjige WHERE status=0 AND idknjigaopis=$knjiga");
	$primjerak =mysql_result($q04,0,0);
	$q03 = myquery("INSERT INTO iznajmljivanje (idOsobaClan, idosobabibliotekar, idPrimjerakKnjige, status) VALUES ('$userid',1,'$primjerak',0)");
	$sqlUpdate = myquery("UPDATE primjerakknjige SET status=1 WHERE idprimjerakknjige='$primjerak'");
	}
?>
	<script language="JavaScript">
		window.location="?sta=clan/knjige";
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
	$q01 = myquery("SELECT DISTINCT k.idknjigaopis, k.naslov, a.ime, a.prezime FROM knjigaopis as k, autor as a, pisac as p, primjerakknjige as pr WHERE upper(k.naslov) LIKE'%$vrijednost%' AND p.idknjigaopis=k.idknjigaopis AND p.idautor=a.idautor AND pr.idposlovnica=1 AND pr.idknjigaopis=k.idknjigaopis AND k.idknjigaopis NOT IN (SELECT pk.idknjigaopis FROM primjerakknjige as pk, iznajmljivanje as i WHERE i.idosobaclan=$userid AND i.idprimjerakknjige=pk.idprimjerakknjige )");
	if($tippretrage==1)
	$q01 = myquery("SELECT DISTINCT k.idknjigaopis, k.naslov, a.ime, a.prezime FROM knjigaopis as k, autor as a, pisac as p, primjerakknjige as pr WHERE upper(a.prezime) LIKE'%$vrijednost%' AND p.idknjigaopis=k.idknjigaopis AND p.idautor=a.idautor AND pr.idposlovnica=1 AND pr.idknjigaopis=k.idknjigaopis AND k.idknjigaopis NOT IN (SELECT pk.idknjigaopis FROM primjerakknjige as pk, iznajmljivanje as i WHERE i.idosobaclan=$userid AND i.idprimjerakknjige=pk.idprimjerakknjige");
	if($tippretrage==2)
	$q01 = myquery("SELECT DISTINCT k.idknjigaopis, k.naslov, a.ime, a.prezime FROM knjigaopis as k, autor as a, pisac as p, primjerakknjige as pr WHERE upper(a.ime) LIKE'%$vrijednost%' AND p.idknjigaopis=k.idknjigaopis AND p.idautor=a.idautor AND pr.idposlovnica=1 AND pr.idknjigaopis=k.idknjigaopis  AND k.idknjigaopis NOT IN (SELECT pk.idknjigaopis FROM primjerakknjige as pk, iznajmljivanje as i WHERE i.idosobaclan=$userid AND i.idprimjerakknjige=pk.idprimjerakknjige");
	
	$temp=mysql_fetch_row($q01);
	if($temp){
	
?>
	<table width=720" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=370><b>Naslov knjige</b></td>
	<td width=150 align="center"><b>Autor</b></td>
	<td width=90 align="center"><b>Slobodno</b></td>
    <td width=90 align="center"><b>Opcije</b></td>
	</tr>

<?
} else print "<p><font color=\"#FF0000\">Trazena knjiga nije pronadjena.</font></p><br>";

$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {
	
	$q02 = myquery("SELECT COUNT(*) FROM primjerakknjige WHERE idknjigaopis=$knjiga[0] AND status=0");
	$broj = mysql_result($q02,0,0);//broj slobodnih primjeraka
?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$knjiga[1]; ?></td>
	<td align="center"><? print $knjiga[2] . " " . $knjiga[3]; ?></td>
	<td align="center"><?=$broj; ?></td>
	<td align="center">
			<? if($broj>0) print "<a href=\"?sta=clan/knjige&akcija=iznajmi&knjiga=$knjiga[0]\">Iznajmi</a>";
			   else print  "<a href=\"?sta=clan/knjige&akcija=rezervisi&knjiga=$knjiga[0]\">Rezervisi</a>";
			?>
	</tr>

<?php
$brojac++;
}

print "</table>";

}
}

?>