﻿<?

function public_registracija() {
	
if ($_REQUEST["akcija"]=="reg"){

    $ime = my_escape($_POST['ime']);
	$prezime = my_escape($_POST['prezime']);
	$jmbg = intval($_POST['jmbg']);
	$adresa = my_escape($_POST['adresa']);
	$pbroj = intval($_POST['pbroj']);
	$grad = my_escape($_POST['grad']);
	$telefon = my_escape($_POST['telefon']);
	$email = my_escape($_POST['email']);
	$username = my_escape($_POST['username']);
	$pass = my_escape($_POST['pass']);
   

	$q01 = myquery("INSERT INTO auth ( korisnickoime, sifra, odobren ) VALUES ( '$username', '$pass', 0 )"); //korisnika mora odobriti admin
	$q02 = myquery("SELECT idauth FROM auth WHERE korisnickoime='$username'"); //da mozemo povezati osobu sa auth
	$auth = mysql_result($q02,0,0);
	$q03 = myquery("INSERT INTO osoba ( Ime, Prezime, JMBG, UlicaIBroj, PostanskiBroj, Grad, Telefon, email, idauth, idposlovnica)
	VALUES ('$ime', '$prezime', '$jmbg', '$adresa', '$pbroj', '$grad', '$telefon', '$email', '$auth', 1)");
}

?>

    <?=genform("POST")?><input type="hidden" name="akcija" value="reg">

	<table width="600" border="0">
	<tr>
	<td width="150">Korisničko ime:</td>
	<td align="left"><input type="text" name="username" size="20"></td>
	</tr>
	<tr>
	<td width="150">Šifra:</td>
	<td align="left"><input type="password" name="pass" size="20"></td>
	</tr><tr></tr>
	<tr>
	<td width="150">Ime:</td>
	<td align="left"><input type="text" name="ime" size="30"></td>
	</tr>
	<tr>
	<td width="150">Prezime:</td>
	<td align="left"><input type="text" name="prezime" size="30"></td>
	</tr>
	<tr>
	<td width="150">JMBG:</td>
	<td align="left"><input type="text" name="jmbg" size="13" maxlength="13"></td>
	</tr>
	<tr>
	<td width="150">Ulica i broj:</td>
	<td align="left"><input type="text" name="adresa" size="30"><br></td>
	</tr>
	<tr>
	<td width="150">Poštanski broj:</td>
	<td align="left"><input type="text" name="pbroj" size="5" maxlength="5"></td>
	</tr>
	<tr>
	<td width="150">Grad:</td>
	<td align="left"><input type="text" name="grad" size="20"></td>
	</tr>
	<tr>
	<td width="150">Telefon:</td>
	<td align="left"><input type="text" name="telefon" size="15"></td>
	</tr>
	<tr>
	<td width="150">E-mail:</td>
	<td align="left"><input type="text" name="email" size="20"></td>
	</tr><tr>
    <td align="right"><br><input type="submit" value="Registruj me"></td>
	</table>
	<br><br><br><a href="?sta=public/intro"><<< Nazad</a></form>

<?

}

?>