<header class="navigation fixed-top">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand font-tertiary h3" href=""><img class="logo" src="<?=$basePath?>/public/images/logo.svg"
          alt="Myself"></a>
          <h3 class="text-white font-tertiary"><?= $title; ?></h3>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
        aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>

      </button>

      <div class="collapse navbar-collapse text-center" id="navigation">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
            <a class="nav-link" href="<?= $router->generate('dashboard'); ?>">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= $router->generate('admin_blog_list'); ?>">Posts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Projets</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Commentaires</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Utilisateurs</a>
          </li>
          <?php if ($user): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= $router->generate('logout') ?>">Déconnexion</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
  </header>