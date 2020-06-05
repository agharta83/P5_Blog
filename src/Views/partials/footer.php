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
        </script> - Audrey César - <a href="<?= $router->generate('dashboard'); ?>">Administration</a></p>
    </div>
  </footer>