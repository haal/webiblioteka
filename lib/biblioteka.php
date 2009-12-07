<?

// LIB/BIBLIOTEKA - funkcije koje se koriste u kodu




function myquery($query) {
	global $_lv_;

	if ($r = @mysql_query($query)) {
		return $r;
	}
	
	# Error handling
	if ($_lv_["debug"])
		print "<br/><hr/><br/>MYSQL query:<br/><pre>".$query."</pre><br/>MYSQL error:<br/><pre>".mysql_error()."</pre>";
	$backtrace = debug_backtrace();
	$file = substr($backtrace[0]['file'], strlen($backtrace[0]['file'])-20);
	$line = intval($backtrace[0]['line']);
	print(mysql_error());
	exit;
}

function admin_meni($fj) {

	global $userid,$sta,$registry;	
	
?>

	<table width="100%" border="0" cellspacing="4" cellpadding="4">
	<tr>
		<td align="left">
		&nbsp;&nbsp;<big><b>Administrator</b></big>
		</td>
	</tr>
	<tr>
		<td align="left">
		<table border="0" width="100%">
			<tr>
				<td width="10%" valign="top" bgcolor="#FFFFFF">
				<br><font size="-1" color="#00000">&nbsp;&nbsp;<a href="?sta=admin/poslovnice">POSLOVNICE</a>
				<br>&nbsp;&nbsp;<a href="?sta=admin/knjige" >KNJIGE</a>
				<br>&nbsp;&nbsp;<a href="?sta=admin/clanovi">CLANOVI</a>
				<br>&nbsp;&nbsp;<a href="?sta=admin/bibliotekari">BIBLIOTEKARI</a>
				<br><br>
				<br>&nbsp;&nbsp;<a href="?sta=logout">Logout</a></font><br><br>
				</td>
				<td width="4%"></td>
				<td width="86%" valign="top" align="left">
				<? eval($fj); ?>
				</td>
			</tr>
		</table>		
		</td>
	</tr>
	</table>
	
<?
	
}

function bibliotekar_meni($fj) {

	global $userid,$sta,$registry;
	
?>

<table width="100%" border="0" cellspacing="4" cellpadding="4">
	<tr>
		<td align="left">
		&nbsp;&nbsp;<big><b>Bibliotekar</b></big>
		</td>
		<td align="left">
		<? print $userid;?>
		</td>
	</tr>
	<tr>
		<td align="left">
		<table border="0" width="100%">
			<tr>
				<td width="10%" valign="top" bgcolor="#FFFFFF" ><br><font size="-1" color="#FFFFFF">&nbsp;&nbsp;<a href="?sta=bibliotekar/knjige">KNJIGE</a>
				<br>&nbsp;&nbsp;<a href="?sta=bibliotekar/clanovi">CLANOVI</a>
				<br>&nbsp;&nbsp;<a href="?sta=bibliotekar/obavijesti">OBAVIJESTI</a>
				<br><br>
				<br>&nbsp;&nbsp;<a href="?sta=logout">Logout</a></font><br><br>
				</td>
				<td width="2%"></td>
				<td width="88%" valign="top" align="left">
				<? eval($fj); ?>
				</td>
			</tr>
		</table>		
		</td>
	</tr>
</table>
	
<?
	
}	
	
?>