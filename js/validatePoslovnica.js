function validatePoslovnica(theForm) {
	var reason = "";

  reason += validateEmpty(theForm.naziv);
  reason += validateEmpty(theForm.adresa);
  reason += validateZipCode(theForm.pbroj);
  reason += validateEmpty(theForm.grad);
  reason += validateTelefon(theForm.telefon);
  reason += validateEmail(theForm.email);

  
     
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

function validateZipCode(fld) {
	var error = ""; 
	
	if (fld.value == "") {
		fld.style.background = 'Yellow';
        error = "Niste unijeli postanski broj.\n";
    }
	else if(fld.value.search(/\d{5}/)==-1){
		fld.style.background = 'Yellow';
		error = "Niste unijeli validan postanski broj. Primjer: 77000.\n";
	}
	return error;
}


function trim(s){
	return s.replace(/^\s+|\s+$/, '');
} 

function validateEmail(fld) {
    var error="";
    var tfld = trim(fld.value);                        // value of field with whitespace trimmed off
    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
    
    if (fld.value == "") {
        fld.style.background = 'Yellow';
        error = "Niste unijeli e-mail adresu.\n";
    } else if (!emailFilter.test(tfld)) {              //test email for illegal characters
        fld.style.background = 'Yellow';
        error = "Unesite validnu e-mail adresu.\n";
    } else if (fld.value.match(illegalChars)) {
        fld.style.background = 'Yellow';
        error = "E-mail sadrzi nedozvoljene znakove.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}

function validateTelefon(fld) {
    var error = "";     

   if (fld.value == "") {
		fld.style.background = 'Yellow';
        error = "Niste unijeli telefon.\n";
    }
	if(fld.value.search(/\d{3}\-\d{3}\-\d{3}/)==-1){
		fld.style.background = 'Yellow';
		error = "Niste unijeli validan telefonski broj. Unesite broj u formatu: xxx-xxx-xxx.\n";
	}
	if (fld.value.length != 12) {
		fld.style.background = 'Yellow';
		error = "Niste unijeli validan telefonski broj. Unesite broj u formatu: xxx-xxx-xxx.\n";
	}
	
    return error;
}