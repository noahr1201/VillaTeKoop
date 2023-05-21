<!DOCTYPE html>
<html>
<head>
    <title>Contactformulier Bevestiging</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333333;
        }

        h2 {
            color: #336699;
        }

        .message {
            font-weight: bold;
            margin-top: 20px;
        }

        .message-content {
            margin-top: 10px;
            padding: 10px;
            background-color: #f5f5f5;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Contactformulier Inzending Bevestiging</h2>
        <div class="message">
            <div class="message-content">
                <p>Beste {{name}},</p>
                <p>Bedankt voor uw bericht. We hebben uw inzending ontvangen en zullen spoedig contact met u opnemen.</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
