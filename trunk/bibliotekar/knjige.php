<?

function bibliotekar_knjige() {

global $userid;

$knjiga = intval($_REQUEST['knjiga']);




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
	$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime FROM knjigaopis as k, autor as a, pisac as p WHERE upper(k.naslov) LIKE'%$vrijednost%' AND p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis");
	if($tippretrage==1)
	$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime FROM knjigaopis as k, autor as a, pisac as p WHERE upper(a.prezime) LIKE'%$vrijednost%' AND p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis");
	if($tippretrage==2)
	$q01 = myquery("SELECT k.idknjigaopis, k.naslov, a.ime, a.prezime FROM knjigaopis as k, autor as a, pisac as p WHERE upper(a.ime) LIKE'%$vrijednost%' AND p.idautor=a.idautor AND p.idknjigaopis=k.idknjigaopis");
	
	$temp=mysql_num_rows($q01);
	if($temp>0){
	
?>
	<table width=720" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=370><b>Naslov knjige</b></td>
	<td width=150 align="center"><b>Autor</b></td>
	</tr>

<?
} else print "<p><font color=\"#FF0000\">Trazena knjiga nije pronadjena.</font></p><br>";

$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {
	
?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><a href="?sta=bibliotekar/knjiga&knjiga=<?=$knjiga[0];?> "><?=$knjiga[1]; ?></a></td>
	<td align="center"><? print $knjiga[2] . " " . $knjiga[3]; ?></td>
	</tr>

<?php
$brojac++;
}

print "</table>";

}
}

?>