<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Google Sign-In Complete</title>
</head>
<body>
    <p>Sign-in complete. This window will close automatically.</p>

    <script>
        if (window.opener && window.opener !== window) {
            window.opener.location.reload();
            window.close();
        }
    </script>
</body>
</html>