function validateBiblioteka(theForm) {
	var reason = "";

  //reason += validateEmpty(theForm.naziv);
  //reason += validateEmpty(theForm.adresa);
  reason += validateNaziv(theForm.naziv);
  reason += validateAdresa(theForm.adresa);
  reason += validateWebAdresa(theForm.webadresa);
  reason += validateEmail(theForm.email);
  reason += validateTelefon(theForm.telefon);
  
      
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
        error = "Potrebna polja niste popunili.\n"
    } else {
        fld.style.background = 'White';
    }
    return error;   
}

function validateNaziv(fld) {
    var error = "";
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "Niste unijeli naziv.\n";
    } else {
        fld.style.background = 'White';
    } 
    return error;
}

function validateAdresa(fld) {
    var error = "";
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "Niste unijeli adresu.\n";
    } else {
        fld.style.background = 'White';
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

function isURL(urlStr) {
	if (urlStr.indexOf(" ") != -1) {
	error = "Spaces are not allowed in a URL.\n";
	return false;
	}

	if (urlStr == "" || urlStr == null) {
	return true;
	}


	urlStr=urlStr.toLowerCase();

	var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
	var validChars="\[^\\s" + specialChars + "\]";
	var atom=validChars + '+';
	var urlPat=/^http:\/\/(\w*)\.([\-\+a-z0-9]*)\.(\w*)/;
	var matchArray=urlStr.match(urlPat);

	if (matchArray==null) {
	//alert("The URL seems incorrect \ncheck it begins with http://\n and it has 2 .'s");
	return false;
	}
	
	var user=matchArray[2];
	var domain=matchArray[3];

	for (i=0; i<user.length; i++) {
		if (user.charCodeAt(i)>127) {
			//alert("This domain contains invalid characters.");
			return false;
		}
	}

	for (i=0; i<domain.length; i++) {
		if (domain.charCodeAt(i) > 127) {
			//alert("This domain name contains invalid characters.");
			return false;
		}
	}

	var atomPat=new RegExp("^" + atom + "$");
	var domArr=domain.split(".");
	var len=domArr.length;

	for (i=0;i<len;i++) {
		if (domArr[i].search(atomPat) == -1) {
			//alert("The domain name does not seem to be valid.");
			return false;
		}
	}
	
	return true;
}

function validateWebAdresa(fld) {
    var error = "";
     
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "Niste unijeli web adresu.\n";
	}
    if (!isURL(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "Web adresa nije u pravom formatu. Primjer: http://www.index.ba\n";
    } 
    return error;
}