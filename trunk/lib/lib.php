<?

# Biblioteka korisnih funkcija

if (!$_lv_) $_lv_ = array(); // Prevent PHP warnings 

function dbconnect($dbhost,$dbuser,$dbpass,$dbdb) {
	global $__lv_connection,$_lv_,$conf_use_mysql_utf8;

	if (!($__lv_connection = mysql_connect($dbhost, $dbuser, $dbpass))) {
		if ($_lv_["debug"]) biguglyerror(mysql_error());
		exit;
	}
	if (!mysql_select_db($dbdb)) {
		if ($_lv_["debug"]) biguglyerror(mysql_error());
		exit;
	}
	if ($conf_use_mysql_utf8) {
		mysql_set_charset("utf8");
	}
}

function dbdisconnect() {
	global $__lv_connection;
	
	mysql_close($__lv_connection);
}

function niceerror($error) {
	print "<p><font color='red'><b>GRESKA: $error</b></font></p>";
}

function biguglyerror($error) {
	print "<center><h2><font color='red'><b>GRESKA: $error</b></font></h2></center>";
}

function nicemessage($error) {
	print "<p><font color='green'><b>$error</b></font></p>";
}



// Escape stringova radi koristenja u mysql upitima - kopirano sa php.net
function my_escape($value) {
	// Convert special HTML chars to protect against XSS
	// If chars are needed for something, escape manually
	$value = htmlspecialchars($value);
	// Stripslashes
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	// Quote if not a number or a numeric string
	if (!is_numeric($value)) {
		$value = mysql_real_escape_string($value); // Detecting quotes later is a pain
	}
	return $value;
}

// --- SESSION MGMT

function login($pass) {
	// RETURN VALUE:
	//  0 - OK
	//  1 - unknown user
	//  2 - password doesn't match 
	// VARIABLES:
	//  $admin - user has admin privileges (from auth table)
	//  $userid - whatever is used internally (aside from login)

	global $userid,$login,$conf_system_auth;

	$q1 = myquery("select a.korisnickoime,a.sifra,o.idosoba from auth as a, osoba as o where a.korisnickoime='$login' and a.odobren=1 and o.idauth=a.idauth");
	if (mysql_num_rows($q1)<=0)
		return 1;

	
	if ($conf_system_auth == "table") {
		if ($pass != mysql_result($q1,0,1)) return 2;
	}

	$userid = mysql_result($q1,0,2);

	// All OK, start session
	session_start();
	$_SESSION['login']=$login;
	session_write_close();

}


function logout() {
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
}


# genform - pravi zaglavlje forme sa hidden poljima
function genform($method="POST", $name="") {
	global $login;

	if ($method != "GET" && $method != "POST") $method="POST";
	$result = '<form name="'.$name.'" action="'.$_SERVER['PHP_SELF'].'" method="'.$method.'">'."\n";
	foreach ($_REQUEST as $key=>$value) {
		if ($key=="pass" && $method=="GET") continue; // Ne pokazuj sifru u URLu!
		$key = htmlspecialchars($key);
		$value = htmlspecialchars($value);
		if (substr($key,0,4) != "_lv_") 
		$result .= '<input type="hidden" name="'.$key.'" value="'.$value.'">'."\n";
	}

	//   CSRF protection
	//   The generated token is a SHA1 sum of session ID, time()/1000 and userid (in the
	// highly unlikely case that two users get the same SID in a short timespan). The
	// second function checks this token and the second token which uses time()/1000+1.
	// This leaves a 1000-2000 second (cca. 16-33 minutes) window during which an 
	// attacker could potentially discover a users SID and then craft an attack targeting
	// that specific user.

	$result .= '<input type="hidden" name="_lv_csrf_protection_token1" value="'.sha1(session_id().(intval(time()/1000)).$login).'"><input type="hidden" name="_lv_csrf_protection_token2" value="'.sha1(session_id().(intval(time()/1000)+1).$login).'">';

	return $result;
}



function check_csrf_token() {
	global $login;
	$token = sha1(session_id().intval(time()/1000).$login);
	if ($_POST['_lv_csrf_protection_token1']==$token || $_POST['_lv_csrf_protection_token2']==$token)
		return true;
	return false;
}



function check_cookie() {
	global $userid,$login;
	$userid=0;
	session_start();
	$login = my_escape($_SESSION['login']);
	if (!preg_match("/[a-zA-Z0-9]/",$login)) return;

	$q1 = myquery("select idAuth from auth where korisnickoIme='$login'");
	if (mysql_num_rows($q1)>0) {
		$auth = mysql_result($q1,0,0);
		$q2 = myquery("select idosoba from osoba where idauth='$auth'");
		$userid = mysql_result($q2,0,0);
	}
}

// Logging

function bibliotekalog($event) {
	global $userid;

	if (intval($userid)==0) $userid=0;

	myquery("insert into log set dogadjaj='".my_escape($event)."', userid=$userid");
}

?>
