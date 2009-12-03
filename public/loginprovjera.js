function validateLoginFormOnSubmit(theForm) {
	var reason = "";
	reason += validateUsername(theForm.login);
	reason += validatePassword(theForm.pass);
	
	if (reason != "") {
	alert("Odredjena polja trebate ispraviti:\n" + reason);
	return false;
	}
	
	return true;
}
	
function validateUsername(fld) {
    var error = "";
    var illegalChars = /\W/; // allow letters, numbers, and underscores
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "Niste unijeli korisnicko ime.\n";
    } else if ((fld.value.length < 5) || (fld.value.length > 15)) {
        fld.style.background = 'Yellow'; 
        error = "Korisnicko ime je predugacko.\n";
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
    var illegalChars = /[\W_]/; // allow only letters and numbers 
 
    if (fld.value == "") {
        fld.style.background = 'Yellow';
        error = "Niste unijeli sifru.\n";
    } else if ((fld.value.length < 5) || (fld.value.length > 15)) {
        error = "Sifra nije odgovarajuce duzine. \n";
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