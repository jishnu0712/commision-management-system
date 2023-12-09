<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c3e50;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-container {
            text-align: center;
            color: #ecf0f1;
        }

        .error-code {
            font-size: 120px;
        }

        .error-message {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .back-to-home a {
            text-decoration: none;
            background-color: #3498db;
            color: #ecf0f1;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-weight: bold;
        }

        .back-to-home a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-message">Page Not Found</div>
        <div class="back-to-home">
            <a href="javascript:void(0);" onclick="window.history.back()">Back</a>

        </div>
    </div>
</body>
</html>
