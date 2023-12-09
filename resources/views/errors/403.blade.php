<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Blocked</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #1a1c20, #2c3e50);
            color: #ecf0f1;
        }

        .message {
            font-size: 24px;
            margin: 20px;
        }

        .icon {
            font-size: 48px;
            margin-top: 50px;
        }

        .description {
            font-size: 18px;
            margin-top: 10px;
        }

        @media (min-width: 768px) {
            .container {
                background: linear-gradient(135deg, #1a1c20, #2c3e50);
                color: #ecf0f1;
            }

            .message {
                font-size: 36px;
            }

            .icon {
                font-size: 64px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🚫</div>
        <div class="message">Your IP address has been blocked!</div>
        <div class="description">Please contact the administrator for assistance.</div>
    </div>
</body>
</html>
