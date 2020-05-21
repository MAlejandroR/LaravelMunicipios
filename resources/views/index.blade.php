<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado de comunidades</title>
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
</head>
<body>
<form action="{{action('ControladorLocalidades@gestionar_accion')}}" method="POST">
    @csrf
    <div class="container_ppal">
    <fieldset > {{-- Comunidades, esto siempre--}}
        <legend>Listado de Comunidades</legend>
        <select name="comunidad" id="">
            @foreach($comunidades as $cod =>$comunidad)
                <option value="{{$cod}}">{{$comunidad}}</option>
            @endforeach
        </select>
        <!-- Anotamos los nombres de la comunidad-->
        @foreach($comunidades as $cod =>$comunidad)
            <input type="hidden" name = name_comunidad[{{$cod}}] value ='{{$comunidad}}'>
        @endforeach
    <!-- Anotamos los nombres de la comunidad-->
        @foreach($comunidades as $cod =>$comunidad)
            <input type="hidden" name = name_comunidad[{{$cod}}] value ='{{$comunidad}}'>
        @endforeach
        <br /> <br />
        <input type="submit" value="Mostrar provincias de comunidad seleccionada" name="submit"/>
        <input type="submit" value="Mostrar todas las provincias" name="submit"/>
    </fieldset>
    <fieldset >{{--Provincias pueden ser todas o de una comunidad, pero siempre--}}
        @if(isset($name_comunidad))
           <legend>Listado de provincias de la comunidad {{$name_comunidad}}</legend>
        @else
           <legend>Listado de todas las provincias </legend>
        @endif
        <select name="provincia" id="">
            @foreach($provincias as $cod=> $provincia)
                <option value="{{$cod}}">{{$provincia}}</option>
            @endforeach
        </select>
            <!-- Anotamos los nombres de la provincias-->
            @foreach($provincias as $cod =>$provincia)
                <input type="hidden" name = name_provincia[{{$cod}}] value ='{{$provincia}}'>
            @endforeach
        <br />
        <input type="submit" value="Mostrar municipios" name="submit">
    </fieldset>
    </div>
    <hr />
    @if (isset($municipios))
    <fieldset class="big"> {{--Municipios de una provincia, solo si hay municipios--}}
       <legend>Listado de Municipios de la provincia {{$name_provincia}}</legend>
        <select name="municipio" id="">
            @foreach($municipios as$municipio)
                <option value="{{$municipio}}">{{$municipio}}</option>
            @endforeach
        </select>
        <br />
        <br />
    </fieldset>
    @endif

</form>

</body>
</html>
