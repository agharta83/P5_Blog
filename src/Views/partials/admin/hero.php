<section class="hero-area hero-admin bg-primary" id="parallax">

    <div class="container card-admin">
        <div class="row d-flex">

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
                <div class="milestone-counter py-3 background-linear1 shadow">
                    <i class="text-white far fa-newspaper fa-3x py-3"></i>
                    <span class="text-white h3 stat-count highlight pb-2"><?= $countDatas['nbPosts']; ?></span>
                    <div class="text-white h5 milestone-details">Articles publiés</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
                <div class="milestone-counter py-3 background-linear2 shadow">
                    <i class="text-white fas fa-laptop-code fa-3x py-3"></i>
                    <span class="text-white h3 stat-count highlight pb-2"><?= $countDatas['nbCommentsToValidate']; ?></span>
                    <div class="text-white h5 milestone-details">Commentaires à valider</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
                <div class="milestone-counter py-3 background-linear3 shadow">
                    <i class="text-white fas fa-comments fa-3x py-3"></i>
                    <span class="text-white h3 stat-count highlight pb-2"><?= $countDatas['nbCommentsValid']; ?></span>
                    <div class=" text-white h5 milestone-details">Commentaires</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
                <div class="milestone-counter py-3 background-linear4 shadow">
                    <i class="text-white fas fa-user fa-3x py-3"></i>
                    <span class="text-white h3 stat-count highlight pb-2"><?= $countDatas['nbUsers']; ?></span>
                    <div class="text-white h5 milestone-details">Utilisateurs</div>
                </div>
            </div>

        </div>
    </div>
    <div class="layer-bg layer-bg-admin w-100">
      <img class="img-fluid w-100" src="<?=$basePath?>/public/images/illustrations/leaf-bg.png" alt="bg-shape">
    </div>

  </section>