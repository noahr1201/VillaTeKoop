<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Villa4You - Luxe villa's in Nederland</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
  <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
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

  // Retrieve bids associated with the villa
  $bidStmt = $dbh->prepare("SELECT bod FROM bidstorage WHERE villaid = :id");
  $bidStmt->bindParam(':id', $id, PDO::PARAM_INT);

  if ($stmt->execute() && $bidStmt->execute()) {
    $villa = $stmt->fetch(PDO::FETCH_ASSOC);
    $bids = $bidStmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    echo "<div class='alert alert-danger' role='alert'>Error executing the query.</div>";
    exit(); // Terminate script execution after displaying the error message
  }
  ?>

  <nav class="navbar navbar-expand navbar-light fixed-top" style="background-color: #F4F6F7;" aria-label="Second navbar example">
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

  <main style="margin-top: 10%">
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
              <?php
              if (!empty($bids)) {
                // Sort the bids array in descending order
                arsort($bids);

                echo "<ol>";
                foreach ($bids as $bid) {
                  echo "<li>&euro; " . number_format($bid['bod'], 2, ',', '.') . ",-</li>";
                }
                echo "</ol>";
              } else {
                echo "<p>Er is nog niet geboden.</p>";
              }
              ?>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="border-0 mb-4">
            <img src="<?php echo $villa['foto']; ?>" class="card-img-top" alt="Villa Image">
          </div>
          <div class="container">
            <h4>Plaats Uw Bod</h4>
            <form method="post" action="../scripts/php/bid-form.php">
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
                <input type="number" class="form-control" id="bodBedrag" name="bodBedrag" min="1000000" placeholder="Voer bodbedrag in" required>
              </div>
              <input type="hidden" name="villaId" value="<?php echo $id; ?>">
              <button type="submit" class="btn btn-primary">Bod Indienen</button>
            </form>
          </div>
        </div>
        <div class="col-md-12">
          <div class="border-0 mb-4">
            <div class="card-body">
              <div id='map' style='width: 1100px; height: 300px; margin-top: 20px'></div>
            </div>
          </div>
      </div>
    </div>
  </main>

  <footer class="border-top" style="margin-top: 5%;">
    <div class="container1 text-center">
      <div class="logo1">
        <img src="../assets/logo.png" width="20%">
      </div>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
  <script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>

  <script src="../scripts/errorMessage.js"></script>
  <script src="../scripts/map.js"></script>
</body>
</html>
