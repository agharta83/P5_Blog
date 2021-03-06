<header class="navigation fixed-top">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand font-tertiary h3" href=""><img id="logo" src="<?=$basePath?>/public/images/logo.svg"
          alt="Myself"></a>
          <h3 class="text-white font-tertiary ml-4">Dashboard</h3>
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
            <a class="nav-link" href="<?= $router->generate('admin_blog_list', ['page' => '1']); ?>">Posts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= $router->generate('comments_list', ['page' => '1']); ?>">Commentaires</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= $router->generate('users_list', ['page' => '1']); ?>">Utilisateurs</a>
          </li>
          <?php if ($user->isAdmin()): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= $router->generate('home') ?>">Retour Site</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $router->generate('logout') ?>">Déconnexion</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
  </header>
