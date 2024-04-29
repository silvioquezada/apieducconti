<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UPLOAD IMAGENES EN LARAVEL</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="/curso/image" enctype="multipart/form-data" method="POST">
                    @csrf    
                    <input type="text" name="nombre" placeholder="ingrese nombre:">
                    <input type="file" name="image">
                    <button type="submit">GUARDAR</button>
                 </form> 
            </div>
        </div>
    </div>
</body>
</html>