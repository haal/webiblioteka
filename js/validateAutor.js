function validateAutor(theForm) {
	var reason = "";

  reason += validateImePrezime(theForm.ime);
  reason += validateImePrezime(theForm.prezime);
  reason += validateEmpty(theForm.biografija);
     
  if (reason != "") {
    alert("Molimo popravite sljedece greske:\n" + reason);
    return false;
  }

  return true;
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


