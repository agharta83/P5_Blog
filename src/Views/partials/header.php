<header class="navigation fixed-top">
  <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand font-tertiary h3" href="<?= $router->generate('home'); ?>"><img id="logo" src="<?= $basePath ?>/public/images/logo.svg" alt="Myself"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse text-center" id="navigation">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="<?= $router->generate('home'); ?>">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $router->generate('about'); ?>">A propos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $router->generate('blog_list', ['page' => '1']); ?>">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $router->generate('contact') ?>">Contact</a>
        </li>

        <?php if (isset($user) && !empty($user) && $user->isAdmin()) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $router->generate('dashboard') ?>">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= $router->generate('logout') ?>">Déconnexion</a>
          </li>
        <?php endif; ?>

      </ul>
    </div>
  </nav>
</header>
