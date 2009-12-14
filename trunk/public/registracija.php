<?
function registerUser() {
	require("lib/config.php");
	require("lib/biblioteka.php");
	
	dbconnect($conf_dbhost,$conf_dbuser,$conf_dbpass,$conf_dbdb);

	
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
	$q03 = myquery("INSERT INTO osoba ( Ime, Prezime, JMBG, UlicaIBroj, PostanskiBroj, Grad, Telefon, email, idtiposobe, idauth, idposlovnica)
	VALUES ('$ime', '$prezime', '$jmbg', '$adresa', '$pbroj', '$grad', '$telefon', '$email', 3, '$auth', 0)");
	
}
}
?>

<html>
   <head>
       <title>Registracija</title>
   </head>
   <body>
   <h1>Registracija</h1><br>
       <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" >
			<input type="hidden" name="akcija" value="reg">
			Korisnicko ime:<input type="text" name="username" size="20"><br>
			Sifra: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="pass" size="20"><br><br>
			Ime: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="ime" size="30"><br>
		   Prezime: <input type="text" name="prezime" size="30"><br>
		   JMBG: &nbsp;&nbsp;<input type="text" name="jmbg" size="13" maxlength="13"><br>
		   Ulica i broj: <input type="text" name="adresa" size="30"><br>
		   Postanski broj: <input type="text" name="pbroj" size="5" maxlength="5"><br>
		   Grad: &nbsp;&nbsp;&nbsp;<input type="text" name="grad" size="20"><br>
		   Telefon: <input type="text" name="telefon" size="15"><br>
		   E-mail: &nbsp;<input type="text" name="email" size="20"><br>
           <input type="submit" value="Registruj me">
		</form>
    </body>
</html>
