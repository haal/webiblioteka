function validateKnjiga(theForm) {
	var reason = "";

  reason += validateEmpty(theForm.naslov);
  reason += validateISBN(theForm.isbn);
  reason += validateIzdanje(theForm.izdanje);
  reason += validateEmpty(theForm.jezik);
  reason += validateGodina(theForm.godina);
  reason += validateEmpty(theForm.opis);
  
     
  if (reason != "") {
    alert("Molimo popravite sljedece greske:\n" + reason);
    return false;
  }

  return true;
}


function validateEmpty(fld) {
    var error = "";
  
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Niste unijeli polje: ".concat(fld.name).concat(".\n");
    } else {
        fld.style.background = 'White';
    }
    return error;   
}

function validateISBN(fld){
	var error = "";
	var regIsbn=/[A-Za-z0-9]/;
	
	if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Niste unijeli ISBN.\n";
    } else if (!regIsbn.test(fld.value) || fld.value.length != 10) {
		fld.style.background = 'Yellow'; 
        error = "Polje ISBN mora sadrzavati 10 znakova bez razmaka.\n";
	}
	
	return error;
}


function validateIzdanje(fld) {
	var error = ""; 
	
	if (fld.value == "") {
		fld.style.background = 'Yellow';
        error = "Niste unijeli izdanje.\n";
    }
	else if(fld.value.search(/\d{1}/)==-1){
		fld.style.background = 'Yellow';
		error = "Niste unijeli validno izdanje. Unesite broj izdanja, primjer: 2.\n";
	}
	return error;
}

function validateGodina(fld) {
	var error = ""; 
	var intYear = parseInt(fld.value, 10);
	
	if (fld.value == "") {
		fld.style.background = 'Yellow';
        error = "Niste unijeli godinu.\n";
    }
	else if (intYear<1900 || intYear>2009) {
		fld.style.background = 'Yellow';
		error = "Niste unijeli validnu godinu. Dozvoljen raspon: 1900-2009\n";
	}
	return error;
}