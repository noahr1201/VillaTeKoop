<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>idealista - Luxe villa's in Nederland</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
  <?php
  include_once '../db_config.php';

  try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Error connecting to the database: " . $e->getMessage() . "</div>";
  }

  error_reporting(E_ALL);
  ini_set('display_errors', 'On');

  $stmt = $dbh->prepare("SELECT * FROM Villa WHERE id = 1");

  if ($stmt->execute()) {
    $villa = $stmt->fetch(PDO::FETCH_ASSOC);
  } else {
    echo "<div class='alert alert-danger' role='alert'>Error executing the query.</div>";
  }
  ?>

  <nav class="navbar navbar-expand navbar-light" style="background-color: rgb(81, 213, 92);" aria-label="Second navbar example">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Villa Te Koop</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsExample02">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Villa's</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.html">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
    <div class="container text-center">
      <img src="../Media/idealista.png" class="img-fluid rounded" width="20%">
    </div>
    <h2 class="lead text-center">Villa Te Koop</h2>
    <p class="text-center" style="padding: 30px; font-size: 120%;"></p>
    <div class="container">
      <div class="row">
        <div class="col">
          <strong>Adres:</strong> <?php echo $villa['adres']; ?>
        </div>
        <div class="col">
          <strong>Plaatsnaam:</strong> <?php echo $villa['plaatsnaam']; ?>
        </div>
        <div class="col">
          <strong>Postcode:</strong> <?php echo $villa['postcode']; ?>
        </div>
        <div class="col">
          <strong>Beschrijving:</strong> <?php echo $villa['beschrijving']; ?>
        </div>
        <div class="col">
          <strong>Bod:</strong> <?php echo $villa['bod']; ?>
        </div>
        <div class="col">
          <img src="<?php echo $villa['foto']; ?>" class="img-fluid rounded" width="60%">
        </div>
      </div>
    </div>
  </main>

  <div class="container">
    <footer class="py-1 my-2 fixed-bottom text-center">
      <p class="mb-2 text-body-secondary text-black-50">2023 &copy; idealista</p>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
