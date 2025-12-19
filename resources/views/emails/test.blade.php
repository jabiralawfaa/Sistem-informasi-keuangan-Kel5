<!DOCTYPE html>
<html>
<head>
    <title>{{ $data['title'] }}</title>
</head>
<body>
    <h1>{{ $data['title'] }}</h1>
    <p>{{ $data['body'] }}</p>
    <p>Ini adalah email percobaan dari sistem informasi keuangan.</p>
    <p>Dikirim pada: {{ now() }}</p>
</body>
</html>