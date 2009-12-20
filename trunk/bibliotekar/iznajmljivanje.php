<?

function bibliotekar_iznajmljivanje() {

global $userid;


//akcija "iznajmi"
if ($_REQUEST['akcija'] == 'iznajmi') {
	
	$primjerak = intval($_POST['primjerak']);
	$clan = intval($_POST['clan']);
	
	$q03 = myquery("INSERT INTO iznajmljivanje (idOsobaClan, idosobabibliotekar, idPrimjerakKnjige, status, odobreno) VALUES ('$clan','$userid','$primjerak',0,1)");
	//iznajmljivanje od strane bibliotekara je automatski odobreno, odobreno=1
	bibliotekalog("Primjerak idprimjerak=$primjerak uspjesno iznajmljen clanu idclan=$clan");
	nicemessage("Primjerak id=$primjerak uspjesno iznajmljen clanu id=$clan");

}


//forma za iznajmljivanje
	print '<b>Iznajmljivanje primjerka standardnim korisnicima:</b><br><br>';?>
	<?=genform("POST");?>

	<input type="hidden" name="akcija" value="iznajmi">

	Iznajmi primjerak id =&nbsp;<input type="text" name="primjerak" size="2">
	clanu koji ima id =&nbsp;<input type="text" name="clan" size="2">
	
	<br><br><input type="submit" value="Iznajmi"  class="default"><br><br>
</form>


<?

}

?>