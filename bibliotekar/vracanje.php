<?

function bibliotekar_vracanje() {

global $userid;

//akcija kojom premjestamo primjerke iz poslovnice u poslovnicu
if ($_REQUEST['akcija'] == 'vratiknjigu') {
	$vrijeme = time();
	$q02 = myquery("SELECT idiznajmljivanje, idprimjerakknjige FROM iznajmljivanje WHERE status=0");
	while ($i = mysql_fetch_row($q02)) {
		$temp = 'status' . $i[0];
		$status = intval($_POST[$temp]);
		if($status == 1) 
		{
		$q03 = myquery("UPDATE iznajmljivanje SET datumVracanja=FROM_UNIXTIME('$vrijeme'), status='$status' WHERE idiznajmljivanje='$i[0]'");	
		bibliotekalog("Vraćen primjerak knjige id=$i[1]");
		
		//nakon vracanja primjerka provjerava se da li je knjiga rezervisana, ako jeste onda se primjerak prosljedjuje prvoj osobi u redu cekanja
		$q04 = myquery("SELECT r.idOsoba FROM rezervacija as r, primjerakknjige as p WHERE r.idKnjigaOpis=p.idknjigaopis AND p.idprimjerakknjige=$i[1] AND r.status=0");
		if(mysql_num_rows($q04)>0)//provjera da li je neko rezervisao knjigu
			{
				$clan = mysql_result($q04,0,0);	//clan kojem se prosljedjuje primjerak knjige
				$q05 = myquery("INSERT INTO iznajmljivanje (idOsobaClan, idosobabibliotekar, idPrimjerakKnjige, status) 
								VALUES ('$clan','$userid','$i[1]',0)");//umetanje podataka u tabelu iznajmljivanje
								
				//sljedece 4 linije nam sluze da bi uklonili osobu s liste cekanja na nekoj knjizi
				$q06 = myquery("SELECT r.idrezervacija FROM rezervacija as r, primjerakknjige as p WHERE r.idKnjigaOpis=p.idknjigaopis AND p.idprimjerakknjige=$i[1] AND idOsoba='$clan'");	
				$rezervacija = mysql_result($q06,0,0);					
				$q07 = myquery("UPDATE rezervacija SET status=1 WHERE idrezervacija='$rezervacija'");
				$q08 = myquery("UPDATE primjerakknjige SET status=1 WHERE idprimjerakknjige='$i[1]'");//u ovoj liniji se primjerak oznacava kao zauzet ponovo
				
				bibliotekalog("Iznajmljen primjerak članu id=$clan (rezervacija)");
				nicemessage("Iznajmljen primjerak članu id=$clan (rezervacija)");
			}
		}
		
	}
	nicemessage("Vraćanje primjeraka registrovano");
}


//kod tabele koja prikazuje sve knjige
$q01 = myquery("SELECT idIznajmljivanje, UNIX_TIMESTAMP(datumPosudjivanja), idOsobaClan, idPrimjerakKnjige FROM iznajmljivanje WHERE status=0");

?>

<b>Primjerci knjiga koji su trenutno iznajmljeni:</b>
<?=genform("POST");?>
<input type="hidden" name="akcija" value="vratiknjigu">
<br><br>
<table width="500" border="1" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
	<td width=60 align="center"><b>ID</b></td>
	<td width=170 align="center"><b>Datum posuđivanja</b></td>
	<td width=110 align="center"><b>ID primjerka</b></td>
    <td width=80 align="center"><b>ID člana</b></td>
    <td width=80 align="center"><b>Vraćeno</b></td>
	</tr>

<?

while ($i=mysql_fetch_row($q01)) {

?>
	<tr>
	<td align="center"><?=$i[0];?></td>
	<td align="center"><?=date("d.m.Y. H:i",($i[1]));?></td>
	<td align="center"><?=$i[3];?></td>
	<td align="center"><?=$i[2];?></td>
	<td align="center">
	<select name="status<?=$i[0];?>" class="default">	
		<option value="0">NE</option>
		<option value="1">DA</option>
	</select>
		
	</td>
	</tr>

<?php

}

?>

</table><br>
<input type="submit" value="Potvrdi izmjene"  class="default">
</form><hr><br>

<?

}

?>