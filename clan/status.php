<?
//pregled knjiga koje je clan trenutno iznajmio ili rezervisao
function clan_status() {

global $userid;


//knjige koje su trenutno kod clana
$q01 = myquery("SELECT k.naslov, a.ime, a.prezime, UNIX_TIMESTAMP(i.datumposudjivanja)
				FROM knjigaopis as k, autor as a, pisac as p, iznajmljivanje as i, primjerakknjige as pk
				WHERE p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis AND pk.idknjigaopis=k.idknjigaopis AND i.idprimjerakknjige=pk.idprimjerakknjige AND i.idosobaclan=$userid AND i.status=0");
	
	print "<b>Knjige koje ste iznajmili:</b><br><br>";

	$temp=mysql_num_rows($q01);
	if($temp>0){
	
?>

	<table width=710" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
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
	<td><?=$knjiga[0]; ?></td>
	<td align="center"><? print $knjiga[1] . " " . $knjiga[2]; ?></td>
	<td align="center"><?=date("d.m.Y. H:i",($knjiga[3]));?></td>
<?
$brojac++;
}

print "</table><br><hr><br>";


//knjige koje su trenutno kod clana
$q01 = myquery("SELECT k.naslov, a.ime, a.prezime, UNIX_TIMESTAMP(r.vrijeme)
				FROM knjigaopis as k, autor as a, pisac as p, rezervacija as r
				WHERE p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis AND r.knjigaopis_idknjigaopis=k.idknjigaopis  AND r.osoba_idosoba=$userid AND r.status=0");
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
	<td><?=$knjiga[0]; ?></td>
	<td align="center"><? print $knjiga[1] . " " . $knjiga[2]; ?></td>
	<td align="center"><?=date("d.m.Y. H:i",($knjiga[3]));?></td>
<?
$brojac++;
}

print "</table><br>";

}

?>