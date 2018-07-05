<?php

  $cfg = json_decode('{
  "username"   : "<GATHERCONTENT_USERNAME>",
  "apikey"     : "<GATHERCONTENT_APIKEY>",
  "account_id" : "<GATHERCONTENT_ACCOUNTID>"
}', TRUE);

  include 'functions.php';

  $project    = FALSE;
  $project_id = 0;

  $projects = gc_projects($cfg);

  if (array_key_exists('pid', $_GET)) {
    $pid = trim(strip_tags($_GET['pid']));
    if (array_key_exists($pid, $projects)) {
      $project    = $projects[$pid];
      $project_id = $pid;
    }
  }

?><!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/radialprogress.css">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  
</head>

<body>
  <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
  
<nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="#">GatherContent Status</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <?php foreach ($projects as $pid => $p): ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?pid=<?php echo $pid; ?>">
          <?php echo $p['name']; ?>
        </a>
      </li>
    <?php endforeach; ?>
    </ul>
  </div>
</nav>  