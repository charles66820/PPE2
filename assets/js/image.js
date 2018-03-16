//variable
let indeximage;//let = var
let listimgproduit = document.getElementById('listimgproduit');

$(function() {
  //inisialisation
  indeximage = 0;
  $("#imgproduit").attr("src", listimgproduit.children[indeximage].src);//affiche la premiére image

  //affiche l'image de la liste qui a aiter cliquer
  $("#listimgproduit").click(function(e) {
    if (e.target.localName == 'img') {
      let index = 0;
      while (e.target.parentNode.children[index] != e.target){
        index++;
      }
      indeximage = index;
      console.log(indeximage);
      $("#imgproduit").attr("src", listimgproduit.children[indeximage].src);
    }
  })
})
