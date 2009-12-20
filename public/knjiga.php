<?

function public_knjiga() {

global $userid;

$knjiga = intval($_REQUEST['knjiga']);

$q01=myquery("SELECT naslov, podnaslov, isbn, izdanje, opis, jezik, godinaizdavanja, idzanr
			 FROM knjigaopis WHERE idKnjigaOpis=$knjiga");
$q02=myquery("SELECT a.ime, a.prezime FROM autor as a, pisac as p, knjigaopis as k WHERE k.idKnjigaOpis=$knjiga AND k.idknjigaopis=p.idknjigaopis AND p.idautor=a.idautor");
	$naslov = mysql_result($q01,0,0);
	$podnaslov = mysql_result($q01,0,1);
	$isbn = mysql_result($q01,0,2);
	$izdanje = mysql_result($q01,0,3);
	$opis = mysql_result($q01,0,4);
	$jezik = mysql_result($q01,0,5);
	$godina = mysql_result($q01,0,6);
	$zanr = mysql_result($q01,0,7);
	$autor = mysql_result($q02,0,0)." ".mysql_result($q02,0,1);
?>
<title><?=$naslov?></title>
<b><font size="+1">KNJIGA - DETALJI :</font></b><br><br>
<table width="700" border="0" cellpadding="1" cellspacing="1" bordercolor="#000000">
<tr>
<td width="150"><font size="-1"><b>Naslov:<b></font></td>
<td width="550"><font size="-1"><?=$naslov?></font></td>
</tr>
<tr>
<td width="150"><font size="-1"><b>Autor:<b></font></td>
<td width="550"><font size="-1"><?=$autor?></font></td>
</tr>
<tr>
<td width="150"><font size="-1"><b>Podnaslov:<b></font></td>
<td width="550"><font size="-1"><?=$podnaslov?></font></td>
</tr>
<tr>
<td width="150"><font size="-1"><b>ISBN:<b></font></td>
<td width="550"><font size="-1"><?=$isbn?></font></td>
</tr><tr>
<td width="150"><font size="-1"><b>Izdanje:<b></font></td>
<td width="550"><font size="-1"><?=$izdanje?></font></td>
</tr>
<tr>
<td width="150"><font size="-1"><b>Jezik:<b></font></td>
<td width="550"><font size="-1"><?=$jezik?></font></td>
</tr><tr>
<td width="150"><font size="-1"><b>Godina izdavanja:<b></font></td>
<td width="550"><font size="-1"><?=$godina?></font></td>
</tr>
<tr>
<td width="150"><font size="-1"><b>Zanr:<b></font></td>
<td width="550"><font size="-1"><?=$zanr?></font></td>
</tr>
<tr>
<td width="150"><font size="-1"><b>Opis:<b></font></td>
<td width="550"><font size="-1"><?=$opis?></font></td>
</tr>
</table>
<br><br><a href="?sta=public/intro"><<< Nazad</a>



<?

}

?>