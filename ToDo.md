### Izmjene ###

Izvrsene su one izmjene gdje ispred broja stoji znak x



x1. Provjeriti da li su svi ID-jevi autoincrement

x2. KnjigaOpis->ISBN postaviti na UNIQUE

x3. U tabelu TipOsobe dodati polje Opis (koje opisuje pojedini tip osobe)

x4. Osoba->JMBG provjera ispravnosti te UNIQUE

x5. Status polje u tabele: PrimjerakKnjige(Iznajmljena I, Nije Iznajmljena NI) ili (0 - nije iznajmljena, 1 - jeste iznajmljena)

x6. Dodati polje Zanr->Opis

7. Prilikom dodavanja nove knjige omgućiti unos novog autora (ako nije u listi ponuđenih). Omogućiti izbor više autora (npr. izaberemo jednog autora te kliknemo dodaj, nakon cega izabiremo novog itd)

8. ISBN broj ne smije biti već unesen

x9. Dvije veze između tabela Osoba i Iznajmljivanje
> - bibliotekar (kada korisnik na standardan način iznajmljuje knjigu)

> - član (kada korisnik iznajmljuje putem interneta)

10. Kako izvršiti iznajmljivanje
Provjeravamo da li je primjerak određene knjige dostupan (broj primjeraka te knjige koji imaju status NI mora biti >=1) te nakon toga unosimo novi slog u tabeli Iznamljivanje sa podacima o članu, bibliotekaru, primjerku i datumu). Ako bibliotekar vrši iznajmljivanje onda se upisuje njegov ID inače ako član iznajmljije putem interneta onda se stavlja defaultni online bibliotekar (npr. 0)

11. Kada nije moguće izvršiti iznajmljivanje nudi se rezervacija. Nakon svakog registrovanja povrata knjige pokreće se proces pregleda rezervacija (da li može iti jedna zadovoljiti). Ako može, automatski se unosi novi red u tabeli Iznajmljivanje, a njen status se stavlja u izvršena/zadovoljena.

x12. Rezervacija->Status polje (zadovoljena-1, nije zadovoljena-0)

13. Osoba koja se registruje putem interneta se veža za fiktivnu-online poslovnicu, dok se osoba koja se registruje sandardnim putem se veže za fizičku poslovnicu svoje registracije.

14. Vođenje statistike čitanosti na osnovu broja stranica knjige, broja iznajmljivanja, broja primjeraka

15. Pregled knjiga za slanje poštom
Proces u kome se prikazuju online-iznajmljene knjige za slanje određenim korisnicima

16. Provjera polja
KnjigaOpis->ISBN - samo cifre i to tačno 13
Knjiga->GodinaIzdavanja samo cifre 1700-2009
BrojPrimjeraka->Cijeli broj

x17. Dodano polje idRezervacije u tabelu Iznajmljivanje da se moze pratiti ako je iznajmljivanje nastalo nakon rezervacije.

x18. Dodana opcija za Zanr u admin meni

19. UNIQUE: username, jmbg i jos neka (treba vrsiti provjeru u bazi da li je jedinstveno navedeno polje tj. prije nego baza izbaci gresku)