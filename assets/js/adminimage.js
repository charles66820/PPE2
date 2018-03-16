//variable
let images = [];//let = var
let listsupprimeimg = [];
let buttonactive = true;
let indeximage;
let listimgproduit = document.getElementById('listimgproduit');
let valider = false;
let delconfirm = false;


$(function() {

//prototype de la classe String pour récupérer
  String.prototype.getFilename = function(extension){
    var s= this.replace(/\\/g, '/');
    s= s.substring(s.lastIndexOf('/')+ 1);
    return extension? s.replace(/[?#].+$/, ''): s;
  }


  //inisialisation
  //récupére les image existente
  for (var i = 0; i < listimgproduit.children.length-1; i++) {
    images.push(
      {
        "id":listimgproduit.children[i].getAttribute('data-image-id'),
        "imagename":listimgproduit.children[i].getAttribute('src').getFilename()
      }
    );
  }

  //affiche l'image ou demende d'en ajouter une
  if (listimgproduit.children.length-1 != 0) {
    indeximage = 0;
    showimgbyindex();
  }else {
    addimg();
  }


  console.log(JSON.stringify(images));


  //affiche l'image de la liste qui a aiter cliquer
  $("#listimgproduit").click(function(e) {
    if (e.target.localName == 'img') {
      let index = 0;
      while (e.target.parentNode.children[index] != e.target){
        index++;
      }
      indeximage = index;
      console.log(indeximage);
      if (e.target.currentSrc != "") {
        $("#imgproduit").attr("src", e.target.src);
        $("#addimgproduit").hide();
      }else {
        $("#btmcancelmodifiimgproduit").hide();
        $("#addimgproduit").show();
      }
    }
  })

  //s'active quant on click sur le button ajouter une image
  $("#btmaddimgproduit").click(function() {
    if (buttonactive) {
      addimg();
      buttonactive = false;
    }
  });

  //supprimer image
  $("#btmremoveimgproduit").click(function() {
    //supprime l'image afficher
    $('#listimgproduit').find('img').eq(indeximage).remove();

    //test si l'image est dans la bdd ou non
    if (images[indeximage].id == null) {
      //supprimer l'image sur le serveur
      removeimg([images[indeximage].imagename])
      console.log('supprime.php');
    }else {
      //ajoute a la liste des image a supprimé
      listsupprimeimg.push(images[indeximage].imagename);
      console.log("img a supprimer : "+listsupprimeimg);
    }

    //supprimer du json
    images.splice(indeximage, 1);

    if (listimgproduit.children.length-1 <= 0) {//si il n'y a pas d'autre image
      buttonactive = true;
      addimg();

    }else if (indeximage == listimgproduit.children.length-1) {//si c'est la derniére image
      //afiicher image précédende
      indeximage--;
      showimgbyindex();

    }else {
      //sinon afficher limage suivante
      indeximage;
      showimgbyindex();
    }

  })

  $("#btmmodifiimgproduit").click(function() {
    $("#btmcancelmodifiimgproduit").show();
    $("#addimgproduit").show();
  })

  $("#btmcancelmodifiimgproduit").click(function(e) {
    $("#btmcancelmodifiimgproduit").hide();
    $("#addimgproduit").hide();
    e.stopPropagation();
  })

  //désactive l'ouverture des fichier au moment du drop
  document.addEventListener('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
  });
  document.addEventListener('dragleave', function() {
    $("#addimgproduit").css({"border":"solid 2px rgba(255, 255, 255, 0)", "background-color":"rgb(255, 255, 255)"})
  });
  document.addEventListener('dragover', function(e) {
    e.preventDefault();
    e.dataTransfer.effectAllowed = "none";
    e.dataTransfer.dropEffect = "none";
    e.stopPropagation();
    $("#addimgproduit").css({"border":"solid 2px rgba(0, 120, 255, 1)", "background-color":"rgb(255, 255, 255)"})
  });
  document.getElementById('addimgproduit').addEventListener('dragover', function(e) {
    e.preventDefault();
    e.dataTransfer.effectAllowed = "copy";
    e.dataTransfer.dropEffect = "copy";
    e.stopPropagation();
  });

  //change le style et envois le fichier en fonction du drag/drop
  $("#addimgproduit").on("dragover", function(e) {
    e.preventDefault();
    $(this).css({"border":"dashed 2px rgba(0, 120, 255, 1)", "background-color":"rgb(150, 210, 255)"})
    return false;
  }).on("dragleave", function() {
    $(this).css({"border":"solid 2px rgba(0, 120, 255, 1)", "background-color":"rgb(255, 255, 255)"})
  }).on("click", function() {
    $(this).next().click();
  }).next().on("change", function(e){
    uploadimg(e.target.files[0]);// IDEA: multiple images
  })
  document.getElementById('addimgproduit').ondrop = function(e) {
    $(this).css({"border":"solid 2px rgba(255, 255, 255, 0)", "background-color":"rgb(255, 255, 255)"});
    e.preventDefault();
    $("#tiredropimg").text("Envois de l'image en cous").next().hide();
    $("#progressbarimg").css({"display":"inherit"}).next().hide();
    uploadimg(e.dataTransfer.files[0]);// IDEA: multiple images
    e.stopPropagation();
  }


  //annuler et valider
  $('#btncancel').click(function() {
    for (var i = 0; i < images.length; i++) {
      if (images[i].id == null) {
        //supprimer l'image sur le serveur
        removeimg([images[i].imagename]);
      }
    }
    document.location.replace("modifiercatalogue.php");
  })

  $('#btndone').click(function() {
    $('#imgsJSON').val(JSON.stringify(images));//ajouter le json de la liste des images au form
    //image a supprime ou non
    removeimg(listsupprimeimg)
    valider = true;
  })


});
$( window ).on( "unload", function() {
  //test si l'ajoute a éter effectuer ou pas
  if (valider != true) {
    //supprime quant la page est quitter
    for (var i = 0; i < images.length; i++) {
      if (images[i].id == null) {
        //supprimer l'image sur le serveur
        removeimg([images[i].imagename]);

      }
    }
  }
});
