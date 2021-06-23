<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SQLBloques</title>
  <script src="jquery-3.3.1.min.js"></script>
  <link href="style.css" rel="stylesheet" type="text/css">

</head>
<body>
 <h1>Ingrese los parámetros de conexión</h1>
 <div class="container">
  <form method='POST' action='entorno.php'>
  <div class="row">
    <div class="col-25">
    	<label>Servidor:</label>
    </div>
    <div class="col-75">
        <input type="text" name="servidor" placeholder="dirección del servidor..." required> 
    </div>
  </div>
  <div class="row">
    <div class="col-25">
        <label>Base:</label>
    </div>
    <div class="col-75">
        <input type="text" name="base" placeholder="nombre de la base..." required> 
    </div>
  </div>
  <div class="row">
    <div class="col-25">
        <label>Usuario:</label>
    </div>
    <div class="col-75">
        <input type="text" name="usuario" placeholder="nombre del usuario..." required>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
        <label>Contraseña:</label>
    </div>
    <div class="col-75">
        <input type="password" name="password" placeholder="contraseña..." required>
    </div>
  </div>
    <button type="submit" id='bot' >Conectar</button>
  </form>
 </div>
</body>
</html>
