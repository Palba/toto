$(document).ready(function() {
    $("#ajouter-utilisateur form input[type=text],"+
      "#ajouter-utilisateur form input[type=password],"+
      "#ajouter-utilisateur form select,"
      ).each(function() {
          this.estValide = false;
      })
});

$('#nom').blur(function() {
    if (this.value.trim() === "") {
        this.estValide = false;
        $('p.erreur-form').html("Vous devez fournir un nom");
        $(this).addClass('invalide');
    } else {
        this.estValide = true;
        $(this).removeClass('invalide');
    }
});

$('#prenom').blur(function() {
    if (this.value.trim() === "") {
        this.estValide = false;
        $('p.erreur-form').html("Vous devez fournir un prénom");
        $(this).addClass('invalide');
    } else {
        this.estValide = true;
        $(this).removeClass('invalide');
    }
});

$('#login').blur(function() {
    if (this.value.trim === "") {
        this.estValide = false;
        $('p.erreur-form').html("Vous devez fournir un login");
        $(this).addClass('invalide');
    } else if (this.value.length < 4){
        this.estValide = false;
        $('p.erreur-form').html("Le login doit être composé d'au moins 4 caractères");
        $(this).addClass('invalide');
    } else if (this.value.indexOf(' ') > -1) {
        this.estValide = false;
        $('p.erreur-form').html("Le login ne doit pas contenir d'espaces.");
        $(this).addClass('invalide');
    } else {
        this.estValide = true;
        $(this).removeClass('invalide');
    }
});

$('#mot_de_passe').blur(function() {
    if (this.value.trim().length < 5) {
        this.estValide = false;
        $('p.erreur-form').html("Le mot de passe doit faire au moins 5 caractères");
        $(this).addClass('invalide');
    } else {
        this.estValide = true;
        $(this).removeClass('invalide');
    }
});

$('#confirmation').blur(function() {
    if (!this.value.trim === $('#mot_de_passe').value.trim) {
        this.estValide = false;
        $('p.erreur-form').html("Le mot de passe ne correspond pas");
        $(this).addClass('invalide');
    } else {
        this.estValide = true;
        $(this).removeClass('invalide');
    }
});

$('#email').blur(function() {
    if (!this.value.match(/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i)) {
        this.estValide = false;
        $('p.erreur-form').html("L'email est invalide");
        $(this).addClass('invalide');
    } else {
        this.estValide = true;
        $(this).removeClass('invalide');
    }
});