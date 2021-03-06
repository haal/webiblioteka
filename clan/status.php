﻿<?
//pregled knjiga koje je clan trenutno iznajmio ili rezervisao
function clan_status() {

global $userid;


//knjige koje je clan iznajmio i odobrene su
$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime, UNIX_TIMESTAMP(i.datumposudjivanja)
				FROM knjigaopis as k, autor as a, pisac as p, iznajmljivanje as i, primjerakknjige as pk
				WHERE p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis AND pk.idknjigaopis=k.idknjigaopis AND i.idprimjerakknjige=pk.idprimjerakknjige AND i.idosobaclan=$userid AND i.status=0 AND i.odobreno=1");
	
	print "<b>Knjige koje ste iznajmili:</b><br><br>";

	$temp=mysql_num_rows($q01);
	if($temp>0){
	
?>

	<table width="710" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=350><b>Naslov knjige</b></td>
	<td width=150 align="center"><b>Autor</b></td>
	<td width=190 align="center"><b>Vrijeme iznajmljivanja</b></td>
	</tr>

<?
} else print "<p><font color=\"#FF0000\">Trenutno nemate iznajmljenih knjiga.</font></p><br>";

$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {
?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><a href="?sta=clan/knjiga&knjiga=<?=$knjiga[0];?> "><?=$knjiga[1]; ?></a></td>
	<td align="center"><? print $knjiga[2] . " " . $knjiga[3]; ?></td>
	<td align="center"><?=date("d.m.Y. H:i",($knjiga[4]));?></td>
<?
$brojac++;
}

if($temp>0) print "</table><br>";
print "<hr><br>";




//knjige koje je clan iznajmio i nisu odobrene
$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime, UNIX_TIMESTAMP(i.datumposudjivanja)
				FROM knjigaopis as k, autor as a, pisac as p, iznajmljivanje as i, primjerakknjige as pk
				WHERE p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis AND pk.idknjigaopis=k.idknjigaopis AND i.idprimjerakknjige=pk.idprimjerakknjige AND i.idosobaclan=$userid AND i.status=0 AND i.odobreno=0");
	
	print "<b>Knjige koje ste iznajmili i čekaju na odobravanje:</b><br><br>";

	$temp=mysql_num_rows($q01);
	if($temp>0){
	
?>

	<table width="710" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=350><b>Naslov knjige</b></td>
	<td width=150 align="center"><b>Autor</b></td>
	<td width=190 align="center"><b>Vrijeme iznajmljivanja</b></td>
	</tr>

<?
} else print "<p><font color=\"#FF0000\">Trenutno nemate knjiga koje čekaju na odobravanje.</font></p><br>";

$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {
?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><a href="?sta=clan/knjiga&knjiga=<?=$knjiga[0];?> "><?=$knjiga[1]; ?></a></td>
	<td align="center"><? print $knjiga[2] . " " . $knjiga[3]; ?></td>
	<td align="center"><?=date("d.m.Y. H:i",($knjiga[4]));?></td>
<?
$brojac++;
}

if($temp>0) print "</table><br>";
print "<hr><br>";




//knjige koje su trenutno rezervisane od jednog clana
$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime, UNIX_TIMESTAMP(r.vrijeme)
				FROM knjigaopis as k, autor as a, pisac as p, rezervacija as r
				WHERE p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis AND r.idknjigaopis=k.idknjigaopis  AND r.idosoba=$userid AND r.status=0");
	print "<b>Knjige koje ste rezervisali:</b><br><br>";

	$temp=mysql_num_rows($q01);
	if($temp>0){
	
?>

	<table width=710" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=350><b>Naslov knjige</b></td>
	<td width=150 align="center"><b>Autor</b></td>
	<td width=190 align="center"><b>Vrijeme rezervacije</b></td>
	</tr>

<?
} else print "<p><font color=\"#FF0000\">Trenutno nemate rezervisanih knjiga.</font></p><br>";

$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {
?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><a href="?sta=clan/knjiga&knjiga=<?=$knjiga[0];?> "><?=$knjiga[1]; ?></a></td>
	<td align="center"><? print $knjiga[2] . " " . $knjiga[3]; ?></td>
	<td align="center"><?=date("d.m.Y. H:i",($knjiga[4]));?></td>
<?
$brojac++;
}

print "</table><br>";

}

?>