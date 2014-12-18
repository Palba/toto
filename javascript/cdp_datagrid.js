$('.datagrid button.cmd_editer').click(function() {
    var id = $(this).siblings('input').val();
    var sform = $('form#commande-form').first();
    sform.attr('action', '?controller=coups_de_pouce&action=editer');
    var sinput = $('form#commande-form input#id');
    sinput.val(id);
    sform.submit(); 
});

$('.datagrid button.cmd_supprimer').click(function() {
    var id = $(this).siblings('input').val();
    var sform = $('form#commande-form').first();
    sform.attr('action', '?controller=coups_de_pouce&action=supprimer');
    var sinput = $('form#commande-form input#id');
    sinput.val(id);
    var message = $('.datagrid a#cdp'+id).text();
   
    if (confirm('Voulez-vous vraiment supprimer ce coup de pouce ? : '+message) == true) {
        sform.submit(); 
    } else {
        alert('false');
    }
    
});
    


