<!DOCTYPE html>
<html>
<head>
    <title>Form Input</title>
</head>
<body>
    <h1>Isi Nama Anda</h1>
    <form method="POST" action="/hasil_cookie">
        @csrf
        <input type="text" name="nama" placeholder="Nama Anda">
        <button type="submit">Kirim</button>
    </form>

    @if(request()->cookie('nama'))
        <p>"Nama Anda: {{ request()->cookie('nama') }}";</p>
    @endif
</body>
</html>
