<?

function admin_biblioteka() {

global $userid;

$q01=myquery("SELECT Naziv, Adresa, Webadresa, Email, Telefon  FROM biblioteka WHERE idBiblioteka=1");
$naziv = mysql_result($q01,0,0);
$adresa = mysql_result($q01,0,1);
$webadresa = mysql_result($q01,0,2);
$email = mysql_result($q01,0,3);
$telefon = mysql_result($q01,0,4);
	
//akcija koja upisuje u bazu podatke s forme, vrsi konkretne promjene
if ($_REQUEST['akcija'] == 'izmijenibiblioteku') {

	$naziv = my_escape($_POST['naziv']);
	$adresa = my_escape($_POST['adresa']);
	$webadresa = my_escape($_POST['webadresa']);
	$email = my_escape($_POST['email']);
	$telefon = my_escape($_POST['telefon']);
   
	$sqlUpdate1="UPDATE biblioteka SET naziv='$naziv' ,adresa='$adresa' ,webadresa='$webadresa' , email='$email' , telefon='$telefon' WHERE idBiblioteka=1";
	$q02=myquery($sqlUpdate1);
	
}
?>
		<script type="text/javascript" src="admin/validateBiblioteka.js"></script>
<?


print "<br><b>Uredjivanje informacija o biblioteci</b><br><br>";
	
    print genform("POST","biblioteka","validateBiblioteka");
	print '<input type="hidden" name="akcija" value="izmijenibiblioteku">';
?>
	Naziv:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="naziv" size="30" value="<?=$naziv?>"><br>
	Adresa:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="adresa" size="30" value="<?=$adresa?>"><br>
	Web adresa:&nbsp;<input type="text" name="webadresa" size="30" value="<?=$webadresa?>"><br>
	E-mail:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email" size="20" value="<?=$email?>"><br>
	Telefon:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="telefon" size="20" value="<?=$telefon?>"><br><br>

<? 
	print '<input type="submit" value="Potvrdi izmjene"  class="default">';
?>
</form>


<?
}
?>