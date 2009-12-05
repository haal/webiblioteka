<?

// REGISTRY - baza komponenti

$registry = array(
# "path", "puni naziv", "UI naziv", "Uloga"
# Legenda polja Uloga:
#    A - admin, B - bibliotekar, C - clan, P - public

array("public/intro", "Login", "Login", "P"),

array("admin/intro", "Admin", "Admin", "A"),
array("admin/knjige", "Upravljanje knjigama", "Admin - Knjige", "A"),
array("admin/clanovi", "Upravljanje clanovima", "Admin - Clanovi", "A"),
array("admin/poslovnice", "Upravljanje poslovnicama", "Admin - Poslovnice", "A"),
array("admin/bibliotekari", "Upravljanje bibliotekarima", "Admin - Bibliotekari", "A"),


array("bibliotekar/intro", "Bibliotekar", "Bibliotekar", "B"),
array("bibliotekar/clanovi", "Upravljanje bibliotekarima", "Bibliotekar - Clanovi", "B"),
array("bibliotekar/knjige", "Upravljanje knjigama", "Bibliotekar - Knjige", "B"),
array("bibliotekar/obavijesti", "Upravljanje obavijestima", "Bibliotekar - Obavijesti", "B"),


array("clan/intro", "Clan", "Clan", "C")

);

?>