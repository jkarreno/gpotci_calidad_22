<?php 
date_default_timezone_set('America/Mexico_City');
//Inicio la sesion 
//ini_set("session.cookie_lifetime","7200");
//ini_set("session.gc_maxlifetime","7200");
session_start();
//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p?gina de autentificacion 
    header("Location: index.php"); 
    //ademas salgo de este script 
    exit(); 
} 



include ("conexion.php");



include ("funciones.php");
?>
<html lang="es-mx">
<head>
	<meta charset="UTF-8" />
	<title>Administración</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	
	<link rel="stylesheet" href="estilos/estilos_principal.css">
	<link rel="stylesheet" href="estilos/estilos.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!--<script src="https://kit.fontawesome.com/2df1cf6d50.js" crossorigin="anonymous"></script>-->
	<script src="https://kit.fontawesome.com/a5e678cc82.js" crossorigin="anonymous"></script>
	

	<script language="JavaScript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
	
	<script src="js/codigo.js"></script>


</head>
<body onload="<?php echo 'areas(0)';?>; ini()" onkeypress="parar()" onclick="parar()">

	<input type="checkbox" id="check">
	<header>
		<div class="menu_bar" style="width: 100px"><label for="check" id="chk_btn"><i class="fas fa-bars"></i></label></div>
		<div class="logo_img" style="width: calc(100% - 553px); align-content: "><i class="fa-solid fa-user-tie" style="margin-right: 20px"></i> Bienvenido <?php echo $_SESSION["nombre"];?></div>
		<div class="logo_img" style="width: 300px">
			<form id="fbuscar" name="fbuscar" style="display:inline;">
				<input id="namanyay-search-box" name="q" size="40" type="text" placeholder=""/>
				<input id="namanyay-search-btn" value="Buscar" type="submit"/>
			</form>
		</div>
		<div class="logo_img" style="width: 153px"><img src="images/logo.jpg"></div>
	</header>

	<div class="menu_principal">
		<?php 
			$ResAreas=mysqli_query($conn, "SELECT * FROM areas ORDER BY Id ASC");
			while($RResAreas=mysqli_fetch_array($ResAreas))
			{
				echo '<div><p style="display: block"><a href="#" onclick="area(\''.$RResAreas["Id"].'\')"><i class="fa-solid fa-folder-closed" style="margin-right: 10px"></i>'.utf8_encode($RResAreas["Nombre"]).'</a></p></div>';
			}
		?>
		<div><p style="display: block"><a href="#"><i class="fa-solid fa-screwdriver-wrench"></i> Configuración</a></p></div>
		<div><p style="display: block"><a href="#"><i class="fas fa-sign-out-alt" onclick="location='logout.php'"></i> Salir</a></p></div>
	</div>

	<div class="contenido" id="contenido">
		
	</div>

	<!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-body" id="modal-body">
    
            </div>
    
        </div>
    </div>
	
</body>
</html>
<script>
//definimos el modal
var modal = document.getElementById('myModal');

function limpiar(){
    document.getElementById("modal-body").innerHTML="";
}

function abrirmodal(){
	modal.style.display = "block";
}
function cerrarmodal(){
	modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}

//funciones ajax
function areas(area){
	$.ajax({
				type: 'POST',
				url : 'areas.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});

}


//cerrar sesion
var bloqueo;
  function ini() {
    bloqueo = setTimeout('location="logout.php"', 3120000);
  }

  function parar() {
    clearTimeout(bloqueo);
    bloqueo = setTimeout('location="logout.php"', 3120000);
  }

//funcion buscar
$("#fbuscar").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fbuscar"));

	$.ajax({
		url: "encontrar.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#conteni2").html(echo);
	});
});
</script>