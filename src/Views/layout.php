<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="" />
  <meta name="author" content="Audrey César" />
  <title>Audrey | Portfolio</title>

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="<?=$basePath?>/public/images/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?=$basePath?>/public/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?=$basePath?>/public/images/favicon/favicon-16x16.png">
  <link rel="manifest" href="<?=$basePath?>/public/images/favicon/site.webmanifest">
  <link rel="mask-icon" href="<?=$basePath?>/public/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <!-- end favicon -->

  <!-- build:css css/app.css -->
  <link rel="stylesheet" href="<?=$basePath?>/public/css/vendor.css">
  <link rel="stylesheet" href="<?=$basePath?>/public/css/app.css" />
  <!-- endbuild -->
</head>

<body>

<!--[if IE]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <?= $this->insert('partials/header'); ?>
  
    <?= $this->section('content'); ?>

  <!-- footer -->
  <?php if (!empty($errors)) {
    $this->insert('partials/footer', [
      'errors' => $errors,
      'fields' => $fields
    ]);
  } else {
    $this->insert('partials/footer');
  } ?>
  <!-- /footer -->
  
  <!-- build:js js/app.js -->
  <script src="<?=$basePath?>/public/js/vendor.js"></script>
  <script src="<?=$basePath?>/public/js/app.js"></script>
  <!-- endbuild -->
</body>

</html>