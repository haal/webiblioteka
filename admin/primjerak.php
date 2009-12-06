<?

function admin_primjerak() {

global $userid;

$knjiga = intval($_REQUEST['knjiga']);



//dodavanje nove knjige
if ($_REQUEST['akcija'] == 'premjestiprimjerak') {
	
	$q01 = myquery("SELECT idprimjerakknjige, idposlovnica FROM primjerakknjige WHERE idknjigaopis=$knjiga");
	while ($k=mysql_fetch_row($q01)) {
		$temp='poslovnica' . $k[0];
		$poslovnica=intval($_POST[$temp]);
		$sqlUpdate="UPDATE primjerakknjige SET idposlovnica='$poslovnica' WHERE idprimjerakknjige='$k[0]'";
		$q02=myquery($sqlUpdate);
	}
	
}
	
	

//kod tabele koja prikazuje sve primjerke za neku knjigu
$q03 = myquery("SELECT naslov FROM knjigaopis WHERE idknjigaopis=$knjiga"); //upit pomocu kojeg uzimamo naslov knjige
$naslov = mysql_result($q03,0,0);

$q04 = myquery("SELECT idprimjerakknjige, idposlovnica FROM primjerakknjige WHERE idknjigaopis=$knjiga");
?>
<b>Primjerci knjige "<?=$naslov ?>"</b>
<?=genform("POST");?>
<input type="hidden" name="akcija" value="premjestiprimjerak">
<br><br>
<table width="310" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr bordercolor="#000000">
	<td width=110 align="center"><b>ID primjerka</b></td>
	<td width=200 align="center"><b>Poslovnica</b></td>
	</tr>

<?php

while ($k=mysql_fetch_row($q04)) {

?>
	<tr>
	<td align="center"><?=$k[0]; ?></td>
	<td align="center"><select name="poslovnica<?=$k[0]; ?>" class="default"><?
	$q05 = myquery("SELECT idPoslovnica, naziv FROM poslovnica"); //upit koji nam sluzi za generisanje opcija u select objektu "poslovnica"
	while ($r05=mysql_fetch_row($q05)) {
		print "<option value=\"$r05[0]\"";
		if ($r05[0]==$k[1]) print " selected";
		print ">$r05[1]</option>";
	}
	?></select></td>
	</tr>

<?php
}
?>

</table><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" value="Potvrdi izmjene"  class="default">
</form>
<br><a href="?sta=admin/knjige"><<< Nazad</a>

<?
}
?>
