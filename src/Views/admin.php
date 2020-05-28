<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="" />
  <meta name="author" content="Audrey César" />
  <title><?= $title; ?></title>

  <!-- build:css css/app.css -->
  <link rel="stylesheet" href="<?=$basePath?>/public/css/vendor.css">
  <link rel="stylesheet" href="<?=$basePath?>/public/css/app.css" />
  <!-- endbuild -->
</head>

<body>

<!--[if IE]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <?= $this->insert('partials/admin/header_admin', ['title' => $title]); ?>
  
    <?= $this->section('content'); ?>

  
  <!-- build:js js/app.js -->
  <script src="<?=$basePath?>/public/js/vendor.js"></script>
  <script src="<?=$basePath?>/public/js/app.js"></script>
  <!-- endbuild -->
</body>

</html>