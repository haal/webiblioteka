<?

// uvodna stranica za javni dio sajta

function public_intro() {

	?>
		<table width="100%" border="0" cellspacing="4" cellpadding="0">
			<tr>
			<td valign="top">
			<p>&nbsp;</p><br><br><br><br><br><br>
			<?
				login_forma();
			?>
			</td></tr>
			
		</table>
	<?
}


function login_forma() {
	global $greska;
	
	// Redirekciju na isti URI vršimo samo ako je greška = istek sesije
	$uri=$_SERVER['PHP_SELF'];

	if ($greska == "Vaša sesija je istekla. Molimo prijavite se ponovo." && !(strstr($_SERVER['REQUEST_URI'], "logout"))) {
		$uri = $_SERVER['REQUEST_URI'];
	}
	
	?>
	<center><table border="0" cellpadding="5" bgcolor="#FFFFFF">
	<tr>
		<td align="center">
		<big><b>Dobro dosli!</b></big>
		</td>
	</tr>
	<tr>
		<td align="center">
		<!-- Login forma -->
		<script  language="JavaScript" src="public/loginprovjera.js"></script>
		<form name="demo" onsubmit="return validateLoginFormOnSubmit(this)" action="<?=$uri?>"  method="POST">
		<input type="hidden" name="loginforma" value="1">
		<table border="0">
			<tr><td>Korisnicko ime:</td><td><input type="text" name="login" size="15"></td></tr>
			<tr><td>Sifra:</td><td><input type="password" name="pass" size="15"></td></tr>
			<tr></tr><tr></tr>
			<tr><td colspan="2" align="center"><input type="submit" value="Kreni"></td></tr></table>
		</form>
		</td>
	</tr>
	</table></center>
	<?
}

?>