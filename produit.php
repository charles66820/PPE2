<?php session_start(); ?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="icon" href="./assets/img/logoIcon.gif"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
</head>

<body>
  <?php include 'nav.php'; ?>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div><img class="rounded" src="assets/img/4424460.jpg" data-bs-hover-animate="pulse" style="width:422px;max-width:none;height:385px;margin-top:27px;margin-left:66px;"></div>
                    <div><img src="assets/img/postal_pulpo_lindo_del_dibujo_animado_en_rosa-rab08a3c83fee4266ab88ca97e53546ba_vgbaq_8byvr_324.jpg" style="width:80px;"><img src="assets/img/postal_pulpo_lindo_del_dibujo_animado_en_rosa-rab08a3c83fee4266ab88ca97e53546ba_vgbaq_8byvr_324.jpg" style="width:80px;"><img src="assets/img/postal_pulpo_lindo_del_dibujo_animado_en_rosa-rab08a3c83fee4266ab88ca97e53546ba_vgbaq_8byvr_324.jpg" style="width:80px;"><img src="assets/img/postal_pulpo_lindo_del_dibujo_animado_en_rosa-rab08a3c83fee4266ab88ca97e53546ba_vgbaq_8byvr_324.jpg" style="width:80px;"><img src="assets/img/postal_pulpo_lindo_del_dibujo_animado_en_rosa-rab08a3c83fee4266ab88ca97e53546ba_vgbaq_8byvr_324.jpg" style="width:80px;"></div>
                </div>
                <div class="col-md-4">
                    <div>
                        <h1 class="text-capitalize text-center">nom du produit</h1>
                    </div>
                    <div>
                        <h5 class="text-left text-success"><i class="fa fa-check"></i>&nbsp;Produit disponible x stock</h5>
                        <h5 class="text-left text-danger"><i class="fa fa-close"></i>&nbsp;Produit indisponible</h5>
                    </div>
                    <div>
                        <h4 class="text-right" style="margin-top:18px;max-width:68px;height:33px;">Avis :&nbsp;</h4>
                    </div>
                    <div class="float-right d-flex" style="background-color:#9d1616;font-size:22px;width:170px;margin-top:-35px;margin-right:32px;"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                    <div>
                        <h5 class="text-center" style="margin-top:16px;margin-left:10px;padding-top:0px;padding-left:-1px;font-size:25px;width:120px;">Quantité :&nbsp;</h5>
                        <div><select class="float-right" style="height:26px;margin-top:-34px;margin-right:24px;"><optgroup label="Quantité"><option value="1" selected="">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option></optgroup></select></div>
                        <div>
                            <h5 class="text-center" style="margin-top:22px;margin-left:10px;padding-top:0px;padding-left:-1px;font-size:25px;width:120px;">Taille :&nbsp;</h5>
                            <div><select class="float-right" style="height:26px;margin-top:-33px;margin-right:25px;"><optgroup label="Taille"><option value="1" selected="">XS</option><option value="2">S</option><option value="3">M</option><option value="4">L</option><option value="5">XL</option><option value="6">XXL</option></optgroup></select></div>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-center text-warning" style="padding-top:26px;max-width:292px;margin-top:-10px;margin-left:0px;padding-right:0px;padding-left:0px;font-size:47px;">Prix €</h1>
                    </div>
                    <div><button class="btn btn-primary" type="button" disabled="disabled" data-bs-hover-animate="tada" style="width:295px;height:80px;margin-top:18px;font-size:31px;">Ajouter au panier&nbsp;</button></div>
                </div>
            </div>
            <div style="margin-top:19px;">
                <div>
                    <h1>Description&nbsp;</h1>
                </div>
                <div>
                    <p><i class="icon ion-android-send"></i>Paragraph</p>
                    <p><i class="icon ion-android-send"></i>Paragraph</p>
                    <p><i class="icon ion-android-send"></i>Paragraph</p>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div>
                        <h3 class="text-center">Heading</h3><img class="rounded" src="assets/img/postal_pulpo_lindo_del_dibujo_animado_en_rosa-rab08a3c83fee4266ab88ca97e53546ba_vgbaq_8byvr_324.jpg" style="width:139px;margin-left:54px;">
                        <div><button class="btn btn-primary btn-lg" type="button" style="width:255px;height:50px;margin-top:1px;">Voir le produit</button></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <h3 class="text-center">Heading</h3><img class="rounded" src="assets/img/postal_pulpo_lindo_del_dibujo_animado_en_rosa-rab08a3c83fee4266ab88ca97e53546ba_vgbaq_8byvr_324.jpg" style="width:139px;margin-left:54px;">
                        <div><button class="btn btn-primary btn-lg" type="button" style="width:255px;height:50px;margin-top:1px;">Voir le produit</button></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <h3 class="text-center">Heading</h3><img class="rounded" src="assets/img/postal_pulpo_lindo_del_dibujo_animado_en_rosa-rab08a3c83fee4266ab88ca97e53546ba_vgbaq_8byvr_324.jpg" style="width:139px;margin-left:54px;">
                        <div><button class="btn btn-primary btn-lg" type="button" style="width:255px;height:50px;margin-top:1px;">Voir le produit</button></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <h3 class="text-center">Heading</h3><img class="rounded" src="assets/img/postal_pulpo_lindo_del_dibujo_animado_en_rosa-rab08a3c83fee4266ab88ca97e53546ba_vgbaq_8byvr_324.jpg" style="width:139px;margin-left:54px;">
                        <div><button class="btn btn-primary btn-lg" type="button" style="width:255px;height:50px;margin-top:1px;">Voir le produit</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>
