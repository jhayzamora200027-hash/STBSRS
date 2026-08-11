<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket response</title>
    <link href="{{ config('app.url') }}" rel="canonical">
    <style>
        body{font-family:Arial,Helvetica,sans-serif;padding:24px}
        .card{max-width:700px;margin:32px auto;padding:20px;border:1px solid #ddd;border-radius:6px}
        .btn{display:inline-block;padding:8px 12px;background:#2d3748;color:#fff;border-radius:4px;text-decoration:none}
    </style>
</head>
<body>
    <div class="card">
        <h2>Ticket #{{ data_get($ticket,'ticket_id') }}</h2>
        <p>{{ $message }}</p>
        <p><a class="btn" href="{{ config('app.url') }}">Go to system</a></p>
    </div>
</body>
</html>
