<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        @charset "utf-8";
        .panel{
            position: absolute;
            top:0;
            left:0;
            display:flex;
            justify-content: center;
            align-items: center;
            height:100%;
            width: 100%;
            transition: transform 300ms;
            z-index:-1;
        }
        .panel div{ 
            display:flex;
            flex-direction:column;
            justify-content: center;
            align-items: center;
            background: beige;
            width: 400px;
            height:400px;
            z-index:1000;
        }
        .panel[
            data-on='on'
        ] {transform: scale(1);}.panel[data-on='off']{transform: scale(0);}
    </style>
</head>
<body>
    <button onclick="document.getElementById('aviso').setAttribute('data-on','on')">Mostrar aviso</button> 
    <div class="panel" id="aviso" data-on="off" onclick="this.setAttribute('data-on','off')">  
        <div>  Esto es un panel de comunicación
            <p>Introduce tu nombre</p>
            <textarea name="datos" id="datos" cols="40" rows="5"></textarea>
            <?php
                $file = fopen("records.txt", "w");
                $texto = $_POST["dades"];
                fwrite($file, $texto);
            ?>
        </div>
    </div>
</body>
</html>
