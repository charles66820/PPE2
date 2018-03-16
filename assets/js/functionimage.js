//function & methods

//affichie image avec son index
function showimgbyindex() {
  console.log(indeximage);
  if (listimgproduit.children[indeximage].src != "") {
    $("#imgproduit").attr("src", listimgproduit.children[indeximage].src);
    $("#addimgproduit").hide();
  }else {
    $("#addimgproduit").show();
  }
}

//ajoute une image
function addimg() {
  buttonactive = false;
  $("#btmcancelmodifiimgproduit").hide();
  $("#addimgproduit").show();
  $("#btmaddimgproduit").css({"cursor":"not-allowed"});
  $('<img src="" data-image-id="" style="width:80px;height: 80px; margin:0 2px">').insertBefore($("#listimgproduit div:first"));
  indeximage = listimgproduit.children.length-2;
  console.log(indeximage);
}

//ajax uploade de l'image
function uploadimg(files) {
  let formData = new FormData();
  formData.append('upload', '');
  formData.append('image', files);
  $.ajax({
    url: "assets/php/dropToUploadFiles.php",
    method: "post",
    data: formData,
    contentType: false,
    processData: false,
    xhr: function(){//pour la bar de progretion
      var xhr = new window.XMLHttpRequest();
      //Upload progress
      xhr.upload.addEventListener("progress", function(evt){
        if (evt.lengthComputable) {
          var percentComplete = Math.trunc((evt.loaded * 100) / evt.total);
          $("#progressbarimg").children().text(percentComplete+"%").css({"width":percentComplete+"%"});
        }
      }, false);
      return xhr;
    },
    success: function (result) {
      //test si c'est une nouvelle image
      if (indeximage == listimgproduit.children.length-2 && listimgproduit.children[listimgproduit.children.length-2].currentSrc == "") {
        images.push({"id":null,"imagename":result});//ajoute l'image a la liste des images

        //réactive le button ajouter une image
        $("#btmaddimgproduit").css({"cursor":"pointer"});
        buttonactive = true;
      }else {
        //change le nom de la nouvelle image
        images[indeximage].imagename = result;
        console.log(images[indeximage].imagename = result);
      }

      //ajoute l'image visuellement
      $('#listimgproduit').find('img').eq(indeximage).attr('src', 'assets/img/imagesupload/'+result);
      console.log(JSON.stringify(images));
      showimgbyindex()

      //change les valeur de l'interface d'envois des images
      $("#tiredropimg").text("Envoyer une image").next().show().text("Glissé déposer votre image ou cliqué ici.");
      $("#progressbarimg").hide().children().text("0%").css({"width":"0%"});
      $("#addimgproduit").hide();

    },


    error: function (error) {
      $("#tiredropimg").text("Erreur d'envois de l'image essayer avec une autre ou annuler").next().show();
      $("#progressbarimg").hide().children().text("0%").css({"width":"0%"}).parent();
      console.log("upload error : "+JSON.stringify(error));
    }
  })
}

//supprime des images
function removeimg(listdelimg) {
  $.ajax({
    method: "post",
    url: "assets/php/removeimg.php",
    data: {
      delImgJSON: JSON.stringify(listdelimg)
    },
    success: function(result) {
      console.log(result);
    }
  })
}
