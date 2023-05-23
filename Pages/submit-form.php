<?php
include_once '../config/db_config.php';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = isset($_POST['naam']) ? htmlspecialchars($_POST['naam']) : '';
        $adress = isset($_POST['adres']) ? htmlspecialchars($_POST['adres']) : '';
        $phone = isset($_POST['telefoon']) ? htmlspecialchars($_POST['telefoon']) : '';
        $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
        $message = isset($_POST['vraag']) ? htmlspecialchars($_POST['vraag']) : '';

        // Form validation
        if (empty($name) || empty($email) || empty($message)) {
            $error = "Vul alstublieft alle verplichte velden in.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Ongeldig e-mailadres.";
        }

        if (isset($error)) {
            header("Location: contact.html?error=" . urlencode($error));
            exit;
        }

        $to = "88906@glr.nl";
        $subject = "Nieuwe Inzending Contactformulier";

        // Create unique boundary for multipart message
        $boundary = md5(uniqid(time()));

        $headers = "From: $name <$email>" . "\r\n";
        $headers .= "Reply-To: $email" . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Content-Type: multipart/alternative; boundary=" . $boundary . "\r\n";

        // Submission
        $submissionContent = "--" . $boundary . "\r\n";
        $submissionContent .= "Content-Type: text/html; charset=UTF-8\r\n";
        $submissionContent .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";

        $submissionBody = file_get_contents('../templates/submission.php');

        $submissionBody = str_replace('{{name}}', $name, $submissionBody);
        $submissionBody = str_replace('{{adress}}', $adress, $submissionBody);
        $submissionBody = str_replace('{{phone}}', $phone, $submissionBody);
        $submissionBody = str_replace('{{email}}', $email, $submissionBody);
        $submissionBody = str_replace('{{message}}', $message, $submissionBody);

        $submissionContent .= quoted_printable_encode($submissionBody) . "\r\n\r\n";
        $submissionContent .= "--" . $boundary . "--";

        // Confirmation
        $confirmationSubject = "Bevestiging van Contactformulier Inzending";

        $confirmationBody = file_get_contents('../templates/confirmation.php');

        $confirmationBody = str_replace('{{name}}', $name, $confirmationBody);

        $confirmationContent = "--" . $boundary . "\r\n";
        $confirmationContent .= "Content-Type: text/html; charset=UTF-8\r\n";
        $confirmationContent .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
        $confirmationContent .= quoted_printable_encode($confirmationBody) . "\r\n\r\n";

        // Store data in the database
        $stmt = $dbh->prepare("INSERT INTO mailstorage (naam, adres, telefoonnummer, email, bericht) VALUES (:naam, :adres, :telefoon, :email, :bericht)");
        $stmt->bindParam(':naam', $name);
        $stmt->bindParam(':adres', $adress);
        $stmt->bindParam(':telefoon', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':bericht', $message);

        if ($stmt->execute()) {
            if (mail($email, $confirmationSubject, $confirmationContent, $headers)) {
                if (mail($to, $subject, $submissionContent, $headers)) {
                    header("Location: contact.html?success=true");
                    exit;
                } else {
                    header("Location: contact.html?error=Het verzenden van het bericht is mislukt. Probeer het later opnieuw.");
                    exit;
                }
            } else {
                header("Location: contact.html?error=Het verzenden van de bevestigingsmail is mislukt. Probeer het later opnieuw.");
                exit;
            }
        } else {
            header("Location: contact.html?error=Het opslaan van gegevens in de database is mislukt. Probeer het later opnieuw.");
            exit;
        }
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Er is een fout opgetreden bij het verbinden met de database: " . $e->getMessage() . "</div>";
}
?>
