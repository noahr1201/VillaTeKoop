<?php
include_once '../config/db_config.php';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = isset($_POST['volledigeNaam']) ? htmlspecialchars($_POST['volledigeNaam']) : '';
        $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
        $bidAmount = isset($_POST['bodBedrag']) ? htmlspecialchars($_POST['bodBedrag']) : '';
        $villaId = isset($_POST['villaid']) ? htmlspecialchars($_POST['villaid']) : '';

        // Form validatie
        if (empty($name) || empty($email) || empty($bidAmount)) {
            $error = "Vul alle verplichte velden in.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Ongeldig e-mailadres.";
        }

        if (isset($error)) {
            $redirectUrl = $_SERVER['HTTP_REFERER']; // Get the URL of the previous page
            $redirectUrl .= (strpos($redirectUrl, '?') === false ? '?' : '&') . 'error=' . urlencode($error); // Append the error attribute
        } else {
            $to = "88906@glr.nl";
            $subject = "Nieuwe Bod Indiening";

            // E-mail headers
            $headers = "From: $name <$email>" . "\r\n";
            $headers .= "Reply-To: $email" . "\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

            // Bevestigingsmail
            $confirmationSubject = "Bevestiging Bod Indiening";
            $confirmationContent = "Bedankt voor het indienen van uw bod. We hebben de volgende informatie ontvangen:\r\n\r\n";
            $confirmationContent .= "Naam: $name\r\n";
            $confirmationContent .= "E-mail: $email\r\n";
            $confirmationContent .= "Bod Bedrag: $bidAmount\r\n";
            $confirmationContent .= "Villa ID: $villaId\r\n\r\n";

            $bidContent = "Er is een nieuw bod ingediend:\r\n\r\n";
            $bidContent .= "Naam: $name\r\n";
            $bidContent .= "E-mail: $email\r\n";
            $bidContent .= "Bod Bedrag: $bidAmount\r\n";
            $bidContent .= "Villa ID: $villaId\r\n";

            // Opslaan van gegevens in de database
            $stmt = $dbh->prepare("INSERT INTO bidstorage (naam, email, bod, villaid) VALUES (:name, :email, :bidAmount, :villaId)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':bidAmount', $bidAmount);
            $stmt->bindParam(':villaId', $villaId);

            if ($stmt->execute()) {
                if (mail($email, $subject, $confirmationContent, $headers)) {
                    mail($to, $subject, $bidContent, $headers); // Send the e-mail to the administrator
                    $redirectUrl = $_SERVER['HTTP_REFERER']; // Get the URL of the previous page
                    $redirectUrl .= (strpos($redirectUrl, '?') === false ? '?' : '&') . 'success=true'; // Append the success attribute
                } else {
                    $error = "Het versturen van de bevestigingsmail is mislukt. Probeer het later opnieuw.";
                }
            } else {
                $error = "Het opslaan van de gegevens in de database is mislukt. Probeer het later opnieuw.";
            }
        }

        if (isset($error)) {
            $redirectUrl .= (strpos($redirectUrl, '?') === false ? '?' : '&') . 'error=' . urlencode($error); // Append the error attribute
        }

        header("Location: $redirectUrl");
        exit;
    } else {
        header("Location: ../index.html");
        exit;
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Er is een fout opgetreden bij het verbinden met de database: " . $e->getMessage() . "</div>";
}
?>
