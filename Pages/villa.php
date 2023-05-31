<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Villa4You - Luxe villa's in Nederland</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
  <?php
  include_once '../config/db_config.php';

  try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Error connecting to the database: " . $e->getMessage() . "</div>";
    exit(); // Terminate script execution after displaying the error message
  }

  $id = isset($_GET['id']) ? $_GET['id'] : 1; // Default ID is set to 1 if no ID is provided

  $stmt = $dbh->prepare("SELECT * FROM Villa WHERE id = :id");
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);

  if ($stmt->execute()) {
    $villa = $stmt->fetch(PDO::FETCH_ASSOC);
  } else {
    echo "<div class='alert alert-danger' role='alert'>Error executing the query.</div>";
    exit(); // Terminate script execution after displaying the error message
  }
  ?>

  <nav class="navbar navbar-expand navbar-light" style="background-color: #F4F6F7;" aria-label="Second navbar example">
    <div class="container">
      <a class="navbar-brand" href="../index.html">
        <img src="../assets/logo.png" class="img-fluid rounded" width="25%">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsExample02">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" style="color: grey;" aria-current="page" href="../index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color: #D4AF37" href="#">Villa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color: grey" href="contact.html">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="error-message" class="alert alert-danger" style="display: none;"></div>

  <main>
    <p class="text-center" style="padding: 20px; font-size: 120%;"></p>
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
          <div class="container">
            <h4>Plaats Uw Bod</h4>
            <form method="post" action="bid-form.php">
              <div class="form-group">
                <label for="volledigeNaam">Volledige Naam</label>
                <input type="text" class="form-control" id="volledigeNaam" name="volledigeNaam" placeholder="Voer uw volledige naam in" required>
              </div>
              <div class="form-group">
                <label for="email">E-mailadres</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Voer uw e-mailadres in" required>
              </div>
              <div class="form-group">
                <label for="bodBedrag">Bodbedrag (in euro's)</label>
                <input type="number" class="form-control" id="bodBedrag" name="bodBedrag" min="1000000" step="100000" placeholder="Voer bodbedrag in" required>
              </div>
              <button type="submit" class="btn btn-primary">Bod Indienen</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="border-top" style="margin-top: 5%;">
    <div class="container1 text-center">
      <div class="tekst1">
        <p>Mobile app</p>
      </div>
      <div class="tekst2">
        <p>Community</p>
      </div>
      <div class="tekst3">
        <p>Company</p>
      </div>
      <div class="logo1">
        <img src="../assets/logo.png" width="20%">
      </div>
      <div class="tekst4">
        <p>Help desk</p>
      </div>
      <div class="tekst5">
        <p>Blog</p>
      </div>
      <div class="tekst6">
        <p>Resources</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
  <script src="../scripts/errorMessage.js"></script>
</body>
</html>
