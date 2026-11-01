<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ini Upload</title>
</head>
<body>
<form action="/uploadfile" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
    Nama : <input type="text" name="nama" value=""><br>
    Pilih File : <input type="file" name="filename" value=""> <br>

    <hr>

    <input type="submit" name="submit" value="simpan">
</form>
</body>
</html>