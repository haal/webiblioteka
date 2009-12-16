function validateClan(theForm) {
	var reason = "";

  reason += validateImePrezime(theForm.ime);
  reason += validateImePrezime(theForm.prezime);
  reason += validateJMBG(theForm.jmbg);
  reason += validateAdresa(theForm.adresa);
  reason += validateZipCode(theForm.pbroj);
  reason += validateEmpty(theForm.grad);
  reason += validateEmail(theForm.email);
  reason += validateTelefon(theForm.telefon);
  reason += validateUsername(theForm.username);
  reason += validatePassword(theForm.pass);
    
      
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

function validateImePrezime(fld) {
    var error = "";
	var regImePrez=/^[a-zA-Z]+$/;
  
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Niste unijeli polje: ".concat(fld.name).concat(".\n");
    } else if (!fld.value.match(regImePrez)) {
		fld.style.background = 'Yellow'; 
        error = "Polje ".concat(fld.name).concat(" moze sadrzavati samo slova.\n");
    }
    return error;   
}

function validateJMBG(fld) {
    var error = "";
  
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Niste unijeli JMBG.\n";
    } else if(fld.value.search(/\d{13}/)==-1){
		fld.style.background = 'Yellow';
		error = "Maticni broj mora imati tacno 13 cifara.\n";
	} 
	else {
        fld.style.background = 'White';
    }
    return error;   
}

/*function testJMBG(fld) {
	var cifre=new Array();
	
	var i=0;
	for (i=0;i<13;i++){
		cifre[i]=parseInt(fld.value.charAt(i));
	}
	
	return true;
}*/

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
	else if(fld.value.search(/\d{3}\-\d{3}\-\d{3}/)==-1){
		fld.style.background = 'Yellow';
		error = "Niste unijeli validan telefonski broj. Unesite broj u formatu: xxx-xxx-xxx.\n";
	}
	else if (fld.value.length != 11) {
		fld.style.background = 'Yellow';
		error = "aNiste unijeli validan telefonski broj. Unesite broj u formatu: xxx-xxx-xxx.\n";
	}
	
    return error;
}

function validateUsername(fld) {
    var error = "";
    var illegalChars = /\W/; // samo slova, brojevi i donjaCrta
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "Niste unijeli korisnicko ime.\n";
    } else if ((fld.value.length < 5) || (fld.value.length > 15)) {
        fld.style.background = 'Yellow'; 
        error = "Duzina korisnickog imena mora biti izmedju 5 i 15 znakova.\n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "Korisnicko ime sadrzi nedozvoljene znakove.\n";
    } else {
        fld.style.background = 'White';
    } 
    return error;
}

function validatePassword(fld) {
    var error = "";
    var illegalChars = /[\W_]/; // samo slova i brojevi 
 
    if (fld.value == "") {
        fld.style.background = 'Yellow';
        error = "Niste unijeli sifru.\n";
    } else if ((fld.value.length < 7) || (fld.value.length > 15)) {
        error = "Duzina sifre mora biti izmedju 7 i 15 znakova. \n";
        fld.style.background = 'Yellow';
    } else if (illegalChars.test(fld.value)) {
        error = "Sifra sadrzi nedozvoljene znakove.\n";
        fld.style.background = 'Yellow';
    } else if (!((fld.value.search(/(a-z)+/)) && (fld.value.search(/(0-9)+/)))) {
        error = "Sifra mora sadrzavati bar jedan broj.\n";
        fld.style.background = 'Yellow';
    } else {
        fld.style.background = 'White';
    }
   return error;
}  
