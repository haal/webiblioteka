<?

// Pocetna stranica


require("lib/lib.php");
require("lib/biblioteka.php");
require("lib/config.php");

dbconnect($conf_dbhost,$conf_dbuser,$conf_dbpass,$conf_dbdb);




// Login forma i provjera sesije

$greska="";
$sta = my_escape($_REQUEST['sta']);

if ($_POST['loginforma'] == "1") {
	$login = my_escape($_POST['login']);
	$pass = my_escape($_POST['pass']);
	
	if (!preg_match("/[\w\d]/",$login)) {
		$greska="Nepoznat korisnik";
	} else {
		$status = login($pass);
		if ($status == 1) { 
			$greska="Nepoznat korisnik";
		} else if ($status == 2) {
			$greska="Pogrešna šifra";
		} 
	}

} else {
	check_cookie();
	if ($userid==0 && $sta!="" && $sta!="public/intro") {
		$greska = "Vaša sesija je istekla. Molimo prijavite se ponovo.";
	}
}
// nakon dijela iznad, $userid drzi numericki ID prijavljenog korisnika




// Određivanje privilegija korisnika

$user_clan=$user_bibliotekar=$user_admin=false;
if ($userid>0) {
	$q01 = myquery("select naziv from tiposobe as t, osoba as o, auth as a where o.idTipOsobe=t.idTipOsobe and o.idosoba='$userid'");
	while ($r01=mysql_fetch_row($q01)) {
		if ($r01[0]=="clan") $user_clan=true; 
		if ($r01[0]=="bibliotekar") $user_bibliotekar=true;
		if ($r01[0]=="admin") $user_admin=true;
	}
	
// Korisnik nije ništa!?
	if (!$user_clan && !$user_bibliotekar && !$user_admin) {
		$greska = "Vaše korisničko ime je ispravno, ali nemate nikakve privilegije na sistemu! Kontaktirajte administratora.";
		$sta = "";
	}
}

//sesija - haris dodao
//session_start();
//$_SESSION['userid'] = $userid;



// Pronalazenje trazenog modula u registryju

include("registry.php");
$staf = str_replace("/","_",$sta);
$found=0;
$naslov="";
if ($sta!="") { // Ne kontrolisemo gresku, zbog public pristupa
	// Logout
	if ($sta == "logout") {
		logout();
		$userid=0;
		$sta="public/intro";
		$staf="public_intro";
		$found=1;
	}

	// Pretraga
	foreach ($registry as $r) {
		if ($r[0] == $sta) { //$r[5] == nevidljiv
			if (strstr($r[3],"P") || (strstr($r[3],"C") && $user_clan) || (strstr($r[3],"B") && $user_bibliotekar) || (strstr($r[3],"A") && $user_admin)) {
				$naslov=$r[1];
				$found=1;
				$greska = "";
			} else if ($greska=="") {
				$greska = "Pristup nije dozvoljen";
				$permstr=""; // opis korisnika, za lakši debugging
				if ($user_clan) $permstr.="C";
				if ($user_bibliotekar) $permstr.="B";
				if ($user_admin) $permstr.="A";
				$sta = ""; // prikaži default modul
			} else {
				$sta=""; // kako se ne bi prikazivale ostale greske, navigacija itd.
			}
			break;
		}
	}
}






if ($naslov=="") $naslov = "Webiblioteka"; // default naslov

?>
<html>
<head>
	<title><?=$naslov?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="css/biblioteka.css" rel="stylesheet" type="text/css" />
</head><?






// template

?>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" bgcolor="#FFFFFF">

<table width="100%" border="1" cellspacing="0" cellpadding="0">
	<tr>
			<td width="50%" align="center" bgcolor="#000000"><br>
			<font color="#FFFFFF" size="5">
			<b><?=$conf_appname?> <?=$conf_appversion?>&nbsp;</b></font><br/>
			<font color="#FFFFFF" size="1">
			&nbsp;&nbsp;&nbsp;</font>
			</td>
	</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="4">
	<tr><td valign="top" align="left">

<?


// Standardne greske
if ($greska != "") {
	niceerror($greska);
}




// Poruka greške za modul
if ($found != 1 && $sta != "") {
	niceerror("Modul $sta još uvijek nije napravljen.");
}



// Default moduli za uloge
if ($found != 1) {
	if ($user_admin) {
		$sta = "admin/intro";
	} else if ($user_bibliotekar) {
		$sta = "bibliotekar/intro";
	} else if ($user_clan) {
		$sta = "clan/intro";
	} else {
		$sta = "public/intro";
	}
	$staf = str_replace("/","_",$sta);
}




// Prikaz modula uglavljenog u template
include ("$sta.php");




// Prikaz menija specificnih za odredjene grupe modula
if (strstr($sta,"bibliotekar/"))
	bibliotekar_meni("$staf();");
else if (strstr($sta,"admin/"))
	admin_meni("$staf();");
else if (strstr($sta,"clan/"))
	clan_meni("$staf();");
else
	eval("$staf();");
	
?>
	
	</td></tr>
</table>

<p>&nbsp;</p>
<p>&nbsp;</p><br><br><br><br><br><br><br><br><br><br><br><br>
<p align="center">Copyright (c) 2009 Alešević Haris, Herić Admir</p>

</body>
</html>
<?
	dbdisconnect();
?>
