<?

function clan_ocjena() {

global $userid;

$knjiga = intval($_REQUEST['knjiga']);


if ($_REQUEST['akcija'] == 'ocijeni') {
	
	$ocjena = intval($_POST['ocjena']);
	$komentar = my_escape($_POST['komentar']);

	$q03 = myquery("DELETE FROM ocjena WHERE idosoba=$userid AND idknjigaopis=$knjiga");
	
	$q05 = myquery("INSERT INTO ocjena ( vrijednost, idosoba, komentar, idknjigaopis ) VALUES ('$ocjena','$userid','$komentar','$knjiga')");
	bibliotekalog("Uspjesno ocijenjena knjiga");
	
?>
	<script language="JavaScript">
		window.location="?sta=clan/ocjene";
	</script>	
<? 
}



$q01 = myquery("SELECT naslov FROM knjigaopis WHERE idknjigaopis=$knjiga");
if (mysql_num_rows($q01)>0) $naslov = mysql_result($q01,0,0);

$q04 = myquery("SELECT vrijednost, komentar FROM ocjena WHERE idknjigaopis=$knjiga AND idosoba=$userid");
if (mysql_num_rows($q04)>0){ 
	$ocjena = mysql_result($q04,0,0);
	$komentar = mysql_result($q04,0,1);
}
?>

<b>Ocijenite knjigu "<?=$naslov?>":</b>
<? 
print genform("POST");
print "<input type=\"hidden\" name=\"akcija\" value=\"ocijeni\">";

?>

<br>Ocjena:&nbsp;&nbsp;<select name="ocjena" class="default">
<?
	for($i=1;$i<=5;$i++) {
		print "<option value=\"$i\"";
		if ($ocjena==$i) print " selected";
		print ">$i</option>";
	}
?></select>
<br><br>Komentar:<br><br><textarea name="komentar" cols="50" rows="10" ><?=$komentar?></textarea><br><br>
<input type="submit" value="Potvrdi"  class="default">
</form>
<br><br><a href="?sta=clan/ocjene"><<< Nazad</a>


<?

}

?>