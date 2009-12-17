<?

function clan_ocjene() {

global $userid;


//knjige koje su trenutno kod clana
$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime
				FROM knjigaopis as k, autor as a, pisac as p, iznajmljivanje as i, primjerakknjige as pk
				WHERE p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis AND pk.idknjigaopis=k.idknjigaopis AND i.idprimjerakknjige=pk.idprimjerakknjige AND i.idosobaclan=$userid");
	
	print "<b>Knjige koje ste iznajmili:</b><br><br>";

	$temp=mysql_num_rows($q01);
	if($temp>0){
	
?>

	<table width=740" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=350><b>Naslov knjige</b></td>
	<td width=150 align="center"><b>Autor</b></td>
	<td width=80 align="center"><b>Vasa ocjena</b></td>
	<td width=80 align="center"><b>Srednja ocjena</b></td>
	<td width=140 align="center"><b>Opcije</b></td>
	</tr>

<?
} else print "<p><font color=\"#FF0000\">Nemate dostupnih knjiga za ocjenjivanje.</font></p><br>";

$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {
$q02 = myquery("SELECT vrijednost FROM ocjena WHERE idknjigaopis=$knjiga[0] AND idosoba=$userid");
if (mysql_num_rows($q02)>0) $ocjena = mysql_result($q02,0,0);//ocjena clana

$q03 = myquery("SELECT AVG(vrijednost) FROM ocjena WHERE idknjigaopis=$knjiga[0]");//srednja ocjena svih clanova
if (mysql_num_rows($q03)>0) $srednjaocjena = mysql_result($q03,0,0);

?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$knjiga[1]; ?></td>
	<td align="center"><? print $knjiga[2] . " " . $knjiga[3]; ?></td>
	<td align="center"><? if($ocjena) print $ocjena; else print "-";?></td>
	<td align="center"><? if($srednjaocjena) print number_format($srednjaocjena,2); else print "-";?></td>
	<td align="center"><a href="?sta=clan/ocjena&knjiga=<?=$knjiga[0]?>">Ocijeni knjigu</a></td>
<?
$brojac++;
}

print "</table><br>";



}

?>