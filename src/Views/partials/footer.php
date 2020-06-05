<footer class="bg-dark footer-section">
  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5 class="text-light">Email</h5>
          <p class="text-white paragraph-lg font-secondary">audrey.cesar83@gmail.com</p>
        </div>
        <div class="col-md-4">
          <h5 class="text-light">Telephone</h5>
          <p class="text-white paragraph-lg font-secondary">06 95 98 51 99</p>
        </div>
        <div class="col-md-4">
          <h5 class="text-light">Adresse</h5>
          <p class="text-white paragraph-lg font-secondary">Toulon (83), France</p>
        </div>
      </div>
    </div>
  </div>

  <div class="border-top text-center border-dark py-5">
    <p class="mb-0 text-light">Copyright ©
      <script>
        var CurrentYear = new Date().getFullYear()
        document.write(CurrentYear)
      </script> - Audrey César - <a href="#login" class="trigger-btn" data-toggle="modal">Administration</a></p>
  </div>
</footer>

<!-- Modal HTML -->
<div id="login" class="modal fade">
  <div class="modal-dialog modal-dialog-centered modal-login">
    <div class="modal-content">
      <form name ="login" action="<?= $router->generate('login'); ?>" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h4 class="modal-title">Connexion à l'administration</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nom d'utilisateur</label>
            <input name="login" type="text" class="form-control" required="required">
          </div>
          <div class="form-group">
            <div class="clearfix">
              <label>Mot de passe</label>
              <a href="#" class="pull-right text-muted"><small>Mot de passe oublié ?</small></a>
            </div>

            <input name="password" type="password" class="form-control" required="required">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <label class="checkbox-inline"><input type="checkbox" class="mr-2">Se souvenir</label>
          <input type="submit" class="btn btn-primary text-white" value="Login">
        </div>
      </form>
    </div>
  </div>
</div>