function validateObavijest(theForm) {
	var reason = "";

  reason += validateEmpty(theForm.naslov);
  reason += validateEmpty(theForm.tekst);
     
  if (reason != "") {
    alert("Molimo popravite sljedeće greške:\n" + reason);
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


