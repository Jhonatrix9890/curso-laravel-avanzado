<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuarios Pdf</title>
    <style>
        .title{
            color: chartreuse;
            text-align: center;
             
        }

    </style>
</head>
<body>
    <h2 class="title">Listado de usuarios</h2>
    <table border="1">
    <thead>
        <tr>
        <th scope="col">Nombre</th>
        <th scope="col">E-mail</th>
        <th scope="col">Fecha de creacion</th>
        <th scope="col">Ultima actualizacion</th>  
        <th scope="col">Rol</th>                         
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $us)
            <tr>
                <th scope="row">{{$us->name}}</th>
                <td>{{$us->email}}</td>
                <td>{{$us->created_at}}</td>
                <td>{{$us->updated_at}}</td>
                <td>
                    @foreach ($us->roles as $r)
                    {{$r->display_name}}
                    @endforeach
                </td>
                </tr>
        @endforeach
    </tbody>
    </table>
</body>
</html>