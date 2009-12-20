<?

function bibliotekar_odobravanje() {

global $userid;

//akcija kojom premjestamo primjerke iz poslovnice u poslovnicu
if ($_REQUEST['akcija'] == 'odobri') {
	$q02 = myquery("SELECT idiznajmljivanje FROM iznajmljivanje WHERE odobreno=0");
	while ($i = mysql_fetch_row($q02)) {
		$temp = 'odobren' . $i[0];
		$odobreno = intval($_POST[$temp]);
		if($odobreno == 1) 
		{
		$q03 = myquery("UPDATE iznajmljivanje SET odobreno='$odobreno' WHERE idiznajmljivanje='$i[0]'");	
		bibliotekalog("Odobreno iznajmljivanje id=$i[0]");
		}
	}
	nicemessage("Iznajmljivanja odobrena");
}


//kod tabele koja prikazuje sve knjige
$q01 = myquery("SELECT idIznajmljivanje, UNIX_TIMESTAMP(datumPosudjivanja), idOsobaClan, idPrimjerakKnjige FROM iznajmljivanje WHERE odobreno=0");

?>

<b>Iznajmljivanja koja čekaju da budu odobrena:</b>
<?=genform("POST");?>
<input type="hidden" name="akcija" value="odobri">
<br><br>
<table width="500" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=60 align="center"><b>ID</b></td>
	<td width=170 align="center"><b>Datum posuđivanja</b></td>
	<td width=110 align="center"><b>ID primjerka</b></td>
    <td width=80 align="center"><b>ID člana</b></td>
    <td width=80 align="center"><b>Odobreno</b></td>
	</tr>

<?

while ($i=mysql_fetch_row($q01)) {

?>
	<tr>
	<td align="center"><?=$i[0];?></td>
	<td align="center"><?=date("d.m.Y. H:i",($i[1]));?></td>
	<td align="center"><?=$i[3];?></td>
	<td align="center"><?=$i[2];?></td>
	<td align="center">
	<select name="odobren<?=$i[0];?>" class="default">	
		<option value="0">NE</option>
		<option value="1">DA</option>
	</select>
		
	</td>
	</tr>

<?php

}

?>

</table><br>
<input type="submit" value="Potvrdi izmjene"  class="default">
</form><hr><br>

<?

}

?>