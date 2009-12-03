<?

function bibliotekar_obavijesti() {

$q01 = myquery("SELECT o.idObavijest, o.naslov, o.datum, p.naziv FROM obavijest o, poslovnica p WHERE o.idPoslovnica=p.idPoslovnica");

?>

<b>Obavijesti koje su trenutno unesene u bazu podataka:</b>
<br><br>
<table width="580" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=410><b>Naslov obavijesti</b></td>
    <td width=50><b>Datum</b></td>
	<td width=100><b>Poslovnica</b></td>
	</tr>

<?php
$brojac=1;

while ($obavijest=mysql_fetch_row($q01)) {

?>

<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$obavijest[1]; ?></td>
	<td><?=$obavijest[2]; ?></td>
	<td><?=$obavijest[3]; ?></td>
</tr>

<?php
$brojac++;
}

print "</table>";

if($brojac==1) print "<p><font color=\"#FF0000\">Trenutno nema obavijesti u bazi podataka.</font></p>";

?>

<br><br><hr><br>
<b>Dodavanje nove obavijesti:</b><br><br>
<form name="novaobavijest" action="<?=$_SERVER['PHP_SELF'] ?>" method="POST">
	Poslovnica:<input type="input" name="poslovnica"><br>
	Naslov:<input type="text" name="naslov" size="50"><br>
	Tekst:<textarea name="opis" cols="50" rows="10"></textarea><br>
</form>


<?

}

?>