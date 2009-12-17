<?

function clan_top10() {

global $userid;


//10 najcitanijih knjiga
$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime, count(i.idiznajmljivanje) as broj
				FROM knjigaopis as k, autor as a, pisac as p, iznajmljivanje as i, primjerakknjige as pk
				WHERE p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis AND pk.idknjigaopis=k.idknjigaopis AND i.idprimjerakknjige=pk.idprimjerakknjige
				GROUP BY k.idknjigaopis ORDER BY broj DESC");
	
	print "<b>Knjige koje su najvise iznajmljivane:</b><br><br>";

	$temp=mysql_num_rows($q01);
	if($temp>0){
	
?>
	<table width="680" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=350><b>Naslov knjige</b></td>
	<td width=150 align="center"><b>Autor</b></td>
	<td width=80 align="center"><b>Broj iznajmljivanja</b></td>
	</tr>

<?
} else print "<p><font color=\"#FF0000\">Nema iznajmljenih knjiga.</font></p><br>";

$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {


?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$knjiga[1]; ?></td>
	<td align="center"><? print $knjiga[2] . " " . $knjiga[3]; ?></td>
	<td align="center"><?=$knjiga[4];?></td>
<?
$brojac++;
}

print "</table><br><hr><br>";




//10 najbolje ocijenjenih knjiga
$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime, AVG(o.vrijednost) as ocjena
				FROM knjigaopis as k, autor as a, pisac as p, iznajmljivanje as i, primjerakknjige as pk, ocjena as o
				WHERE p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis AND o.idknjigaopis=k.idknjigaopis
				GROUP BY k.idknjigaopis ORDER BY ocjena DESC");
	
	print "<b>Najbolje ocijenjene knjige:</b><br><br>";

	$temp=mysql_num_rows($q01);
	if($temp>0){
	
?>
	<table width="680" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=350><b>Naslov knjige</b></td>
	<td width=150 align="center"><b>Autor</b></td>
	<td width=80 align="center"><b>Srednja ocjena</b></td>
	</tr>

<?
} else print "<p><font color=\"#FF0000\">Nema ocijenjenih knjiga.</font></p><br>";

$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {

?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$knjiga[1]; ?></td>
	<td align="center"><? print $knjiga[2] . " " . $knjiga[3]; ?></td>
	<td align="center"><? if($knjiga[4]) print number_format($knjiga[4],2); else print "-";?></td>
<?
$brojac++;
}

print "</table><br><hr><br>";





//10 najnovijih knjiga
$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime, UNIX_TIMESTAMP(k.datumulaza) as vrijeme
				FROM knjigaopis as k, autor as a, pisac as p
				WHERE p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis
				GROUP BY k.idknjigaopis ORDER BY vrijeme DESC");
	
	print "<b>Najnovije knjige:</b><br><br>";

	$temp=mysql_num_rows($q01);
	if($temp>0){
	
?>
	<table width="680" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=330><b>Naslov knjige</b></td>
	<td width=150 align="center"><b>Autor</b></td>
	<td width=180 align="center"><b>Vrijeme</b></td>
	</tr>

<?
} else print "<p><font color=\"#FF0000\">Nema knjiga u bazi podataka.</font></p><br>";

$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {


?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$knjiga[1]; ?></td>
	<td align="center"><? print $knjiga[2] . " " . $knjiga[3]; ?></td>
	<td align="center"><?=date("d.m.Y. H:i",($knjiga[4]));?></td>
<?
$brojac++;
}

print "</table><br>";

}


?>