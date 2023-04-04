// JavaScript Document
$("#formPassNew1, #formPassNew2").change(function() {
  validatePassword();
});
function validatePassword(){
	var pass1=$("#formPassNew1");
	var pass2=$("#formPassNew2");
	if(pass1.val()!=pass2.val()){
		pass2.each(function() { this.setCustomValidity("Contraseña no coincide"); });
	}else{
		pass2.each(function() { this.setCustomValidity(""); });
	}
	if(pass1.val().length<6){
		pass1.each(function() { this.setCustomValidity("Minimo 6 caracteres"); });
	}else{
		pass1.each(function() { this.setCustomValidity(""); });
	}
	if(passwordStrength(pass1.val())<2){
		pass1.each(function() { this.setCustomValidity("Contraseña Muy Debil"); });
	}else{
		pass1.each(function() { this.setCustomValidity(""); });
	}
}

function passwordStrength(password){
	var desc = new Array();
	desc[0] = "Muy Debil";
	desc[1] = "Debil";
	desc[2] = "Normal";
	desc[3] = "Normal";
	desc[4] = "Fuerte";
	desc[5] = "Muy Fuerte";
	var score   = 0;
	//if password bigger than 6 give 1 point
	if (password.length > 6) score++;
	//if password has both lower and uppercase characters give 1 point      
	if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;
	//if password has at least one number give 1 point
	if (password.match(/\d+/)) score++;
	//if password has at least one special caracther give 1 point
	if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;
	//if password bigger than 12 give another 1 point
	if (password.length > 12) score++;
	document.getElementById("passwordDescription").innerHTML = desc[score];
	document.getElementById("passwordStrength").className = "strength" + score;
	//alert(score);
	return (score);
}