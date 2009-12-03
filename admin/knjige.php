<?

function admin_knjige() {

$q01 = myquery("SELECT idKnjigaOpis, naslov FROM knjigaopis");

?>
<b>Knjige koje su trenutno unesene u bazu podataka:</b>
<br><br>
<table width="580" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=20><b>R.br.</b></td>
	<td width=410><b>Naslov knjige</b></td>
    <td width=150 align="center"><b>Opcije</b></td>
	</tr>

<?php
$brojac=1;

while ($knjiga=mysql_fetch_row($q01)) {

?>
	<tr>
	<td><? print "$brojac"; ?></td>
	<td><?=$knjiga[1]; ?></td>
	<td align="center">
			<a href="?sta=admin/knjige&akcija=ukloni&knjiga=<?php echo $knjiga[0];?> ">Ukloni</a>&nbsp;&nbsp;&nbsp;
			<a href="?sta=admin/knjige&akcija=edit&knjiga=<?php echo $knjiga[0];?> ">Edituj</a>
	</tr>

<?php
$brojac++;
}

print "</table>";

if($brojac==1) print "<p><font color=\"#FF0000\">Trenutno nema knjiga u bazi podataka.</font></p>";

?>

<br><br><hr><br>
<b>Dodavanje nove knjige:</b><br><br>
<form name="novaknjiga" action="<?=$_SERVER['PHP_SELF'] ?>" method="POST">
	Naslov:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="naslov" size="50"><br>
	Podnaslov:<input type="text" name="podnaslov" size="50"><br>
	ISBN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="isbn" size="13"><br>
	Izdanje:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="izdanje" size="5"><br>
	Jezik:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="jezik" size="20"><br>
	Godina izdavanja:<input type="text" name="jezik" size="4"><br>
	<br>Opis:<br><br><textarea name="opis" cols="50" rows="10"></textarea><br>
</form>

<?

}

?>
