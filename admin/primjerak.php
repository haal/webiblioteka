<?

function admin_primjerak() {

global $userid;

$knjiga = intval($_REQUEST['knjiga']);
$primjerak = intval($_REQUEST['primjerak']);



// akcija brisanja primjerka - opcija "ukloni"
if ($_REQUEST["akcija"]=="ukloni")
{
	if ($primjerak) {
	$delete="DELETE FROM primjerakKnjige WHERE idPrimjerakKnjige=" . $primjerak;
	myquery($delete);
	}
?>
	<script language="JavaScript">
		window.location="?sta=admin/primjerak&knjiga=<?=$knjiga?>";
	</script>
<?
}


//akcija kojom premjestamo primjerke iz poslovnice u poslovnicu
if ($_REQUEST['akcija'] == 'premjestiprimjerak') {
	
	$q01 = myquery("SELECT idprimjerakknjige, idposlovnica FROM primjerakknjige WHERE idknjigaopis=$knjiga");
	while ($k=mysql_fetch_row($q01)) {
		$temp='poslovnica' . $k[0];
		$poslovnica=intval($_POST[$temp]);
		$sqlUpdate="UPDATE primjerakknjige SET idposlovnica='$poslovnica' WHERE idprimjerakknjige='$k[0]'";
		$q02=myquery($sqlUpdate);
	}
	
}

//akcija kojom dodajemo nove primjerke klikom na dugme "dodaj primjerke"
if ($_REQUEST['akcija'] == 'dodajprimjerak') {
	
	$q10 = myquery("SELECT brojprimjeraka FROM knjigaopis WHERE idknjigaopis=$knjiga");
	$broj = intval($_POST['broj']);
	$poslovnica = intval($_POST['poslovnica']);
	for($i=1;$i<=$broj;$i++){
		$insert = myquery("INSERT INTO primjerakknjige ( idknjigaopis, idposlovnica ) VALUES ('$knjiga','$poslovnica')");
	}
	$temp=$broj+mysql_result($q10,0,0);
	$update = myquery("UPDATE knjigaopis SET brojprimjeraka='$temp' WHERE idknjigaopis=$knjiga");
	
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
<table width="430" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr bordercolor="#000000">
	<td width=110 align="center"><b>ID primjerka</b></td>
	<td width=200 align="center"><b>Poslovnica</b></td>
    <td width=150 align="center"><b>Opcije</b></td>
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
	<td align="center">
		<a href="?sta=admin/primjerak&akcija=ukloni&knjiga=<?=$knjiga;?>&primjerak=<?=$k[0];?> ">Ukloni</a>
	</td>	
	</tr>

<?php
}
?>

</table><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" value="Potvrdi izmjene"  class="default">
</form><hr><br>
<b>Dodavanje novih primjeraka knjige:</b><br>
<?=genform("POST");?>
<input type="hidden" name="akcija" value="dodajprimjerak">
<br><br>
Dodaj&nbsp;<input type="text" name="broj" size="1">
primjeraka knjige "<?=$naslov ?>" u poslovnicu&nbsp;<select name="poslovnica" class="default"><?
	$q05 = myquery("SELECT idPoslovnica, naziv FROM poslovnica"); //upit koji nam sluzi za generisanje opcija u select objektu "poslovnica"
	while ($r05=mysql_fetch_row($q05)) {
		print "<option value=\"$r05[0]\"";
		print ">$r05[1]</option>";
	}
	?></select><br><br>
<input type="submit" value="Dodaj primjerke"  class="default">
</form>
<br><hr>
<br><a href="?sta=admin/knjige"><<< Nazad</a>

<?
}
?>
