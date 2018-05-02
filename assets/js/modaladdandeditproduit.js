$(function () {
  $('#produitconfirme').on('show.bs.modal', function (e) {
    $("#modalbody").html(
      '<div class="col-sm-6">Nom du Produit : '+$("#nomproduit").val()+'</div>'+
      '<div class="col-sm-6">Prix Unitaire HT : '+$("#prixproduit").val()+'</div>'+
      '<div class="col-sm-6">Référence : '+$("#referenceproduit").val()+'</div>'+
      '<div class="col-sm-6">Quantité : '+$("#quantiteproduit").val()+'</div>'+
      '<div class="col-sm-6">Catégorie : '+document.getElementById("categorieproduit").selectedOptions[0].innerText+'</div>'+
      '<div class="col-sm-6">Taille : '+document.getElementById("taille").selectedOptions[0].innerText+'</div>'+
      '<div class="col-sm-6">Description : '+$("#descriptionproduit").val()+'</div>'
    );
  })
})
