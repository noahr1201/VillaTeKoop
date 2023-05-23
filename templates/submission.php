<!DOCTYPE html>
<html>
<head>
    <title>Contactformulier Inzending</title>
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
        <h2 class="mt-4">Contactformulier Inzending</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name"><b>Naam:</b></label>
                    <p class="form-control-static">{{name}}</p>
                </div>
                <div class="form-group">
                    <label for="name"><b>Adres:</b></label>
                    <p class="form-control-static">{{adress}}</p>
                </div>
                <div class="form-group">
                    <label for="name"><b>telefoonnummer:</b></label>
                    <p class="form-control-static">{{phone}}</p>
                </div>
                <div class="form-group">
                    <label for="email"><b>E-mail:</b></label>
                    <p class="form-control-static">{{email}}</p>
                </div>
            </div>
        </div>
        <div class="message">
            <label for="message"><b>Bericht:</b></label>
            <div class="message-content">
                <p class="form-control-static">{{message}}</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
