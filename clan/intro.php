<?

function clan_intro() {

//poruka dobrodoslice
global $userid;
$q01=myquery("SELECT o.ime, o.prezime FROM auth a, osoba o WHERE '$userid'=o.idOsoba");
$ime=mysql_result($q01,0,0);
$prezime=mysql_result($q01,0,1);
echo "<b>Dobrodošli: ".$ime." ".$prezime."</b><br>";

print "Odaberite neku od opcija koje su ponudene u meniju s lijeve strane.";
}

?>