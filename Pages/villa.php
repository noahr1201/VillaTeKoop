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

  $id = isset($_GET['id']) ? $_GET['id'] : 1; // Default ID is set to 1 if no ID is provided

  $stmt = $dbh->prepare("SELECT * FROM Villa WHERE id = :id");
  $stmt->bindParam(':id', $id);

  if ($stmt->execute()) {
    $villa = $stmt->fetch(PDO::FETCH_ASSOC);
  } else {
    echo "<div class='alert alert-danger' role='alert'>Error executing the query.</div>";
  }
  ?>

  <nav class="navbar navbar-expand navbar-light bg-success" aria-label="Second navbar example">
    <div class="container">
      <a class="navbar-brand" href="../index.html">Villa Te Koop</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsExample02">
        <ul class="navbar-nav ml-auto">
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
      <a href="../index.html"><img src="../media/idealista.png" class="img-fluid rounded" width="20%"></a>
    </div>
    <p class="text-center" style="padding: 30px; font-size: 120%;"></p>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="border-0 mb-4">
            <div class="card-body">
              <h5 class="card-title"><b>Adres</b></h5>
              <p class="card-text"><?php echo $villa['adres']; ?></p>
            </div>
          </div>
          <div class="border-0 mb-4">
            <div class="card-body">
              <h5 class="card-title"><b>Plaatsnaam</b></h5>
              <p class="card-text"><?php echo $villa['plaatsnaam']; ?></p>
            </div>
          </div>
          <div class="border-0 mb-4">
            <div class="card-body">
              <h5 class="card-title"><b>Postcode</b></h5>
              <p class="card-text"><?php echo $villa['postcode']; ?></p>
            </div>
          </div>
          <div class="border-0 mb-4">
            <div class="card-body">
              <h5 class="card-title"><b>Beschrijving</b></h5>
              <p class="card-text"><?php echo $villa['beschrijving']; ?></p>
            </div>
          </div>
          <div class="border-0 mb-4">
            <div class="card-body">
              <h5 class="card-title"><b>Bod</b></h5>
              <p class="card-text">&euro; <?php echo number_format($villa['bod']); ?> ,-</p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="border-0 mb-4">
            <img src="<?php echo $villa['foto']; ?>" class="card-img-top" alt="Villa Image">
          </div>
        </div>
      </div>
    </div>
  </main>

  <div class="container">
    <footer class="py-1 my-2 fixed-bottom text-center">
      <p class="mb-2 text-black-50">&copy; 2023 idealista</p>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
