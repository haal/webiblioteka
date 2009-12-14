<?

// REGISTRY - baza komponenti

$registry = array(
# "path", "puni naziv", "UI naziv", "Uloga"
# Legenda polja Uloga:
#    A - admin, B - bibliotekar, C - clan, P - public

array("public/intro", "Login", "Login", "P"),
array("public/registracija", "Registracija", "Registracija", "P"),


array("admin/intro", "Admin", "Admin", "A"),
array("admin/knjige", "Upravljanje knjigama", "Admin - Knjige", "A"),
array("admin/clan", "Upravljanje clanovima", "Admin - Clanovi", "A"),
array("admin/poslovnice", "Upravljanje poslovnicama", "Admin - Poslovnice", "A"),
array("admin/primjerak", "Upravljanje primjercima knjige", "Admin - Primjerak knjige", "A"),
array("admin/bibliotekari", "Upravljanje bibliotekarima", "Admin - Bibliotekari", "A"),
array("admin/clanovi", "Upravljanje clanovima", "Admin - Clanovi", "A"),
array("admin/zanrovi", "Upravljanje zanrovima", "Admin - Zanrovi", "A"),
array("admin/autori", "Upravljanje autorima", "Admin - Autori", "A"),
array("admin/biblioteka", "Editovanje informacija o biblioteci", "Admin - Biblioteka", "A"),



array("bibliotekar/intro", "Bibliotekar", "Bibliotekar", "B"),
array("bibliotekar/clanovi", "Upravljanje clanovima", "Bibliotekar - Clanovi", "B"),
array("bibliotekar/knjige", "Upravljanje knjigama", "Bibliotekar - Knjige", "B"),
array("bibliotekar/obavijesti", "Upravljanje obavijestima", "Bibliotekar - Obavijesti", "B"),


array("clan/intro", "Clan", "Clan", "C"),
array("clan/knjige", "Pretraga knjiga", "Knjige", "C")

);

?>