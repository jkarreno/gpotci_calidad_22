<?php
include("../conexion.php");

//Acciones
if(isset($_POST["hacer"]))
{
    if($_POST["hacer"]=='addusuario')
    {
        mysqli_query($conn, "INSERT INTO usuarios (Usuario, Contrasena, Tipo, Nombre, Calidad, Mercancias) 
                                            VALUES ('".$_POST["usuario"]."', '".$_POST["contrasena"]."', '".$_POST["perfil"]."', 
                                                    '".$_POST["nombre"]."', '1', '0')");

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego el usuario '.$_POST["nombre"].'</div>';
    }
    if($_POST["hacer"]=='editusuario')
    {
        $sql="UPDATE usuarios SET Usuario='".$_POST["usuario"]."', ";
        if($_POST["contrasena"]!='')
        {
            $sql.="                  Contrasena='".$_POST["contrasena"]."', ";
        }
        $sql.="                     Tipo='".$_POST["perfil"]."', 
                                    Nombre='".$_POST["nombre"]."'
                            WHERE Id='".$_POST["idusuario"]."'";

        mysqli_query($conn, $sql);

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se modifico el usuario '.$_POST["nombre"].'</div>';
    }
    if($_POST["hacer"]=='delusuario')
    {
        $ResUsuario=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM usuarios WHERE Id='".$_POST["usuario"]."' LIMIT 1"));

        mysqli_query($conn, "DELETE FROM usuarios WHERE Id='".$_POST["usuario"]."'");

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se modifico el usuario '.$ResUsuario["Nombre"].'</div>';
    }
}

$cadena=$mensaje.'<div class="c100" id="conteni2">
            <table>
                <thead>
                    <tr>
                        <td colspan="6" align="right">| <a href="#" onclick="add_usuario()">Agregar Usuario</a> |</td>
                    </tr>
                    <tr>
                        <th align="center" class="textotitable">#</th>
                        <th align="center" class="textotitable">Nombre</th>
                        <th align="center" class="textotitable">Usuario</th>
                        <th align="center" class="textotitable">Perfil</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>';
$ResUsuarios=mysqli_query($conn, "SELECT * FROM usuarios ORDER BY Nombre ASC");
$T=1; $bgcolor="#ffffff";
while($RResUsuarios=mysqli_fetch_array($ResUsuarios))
{
    if($RResUsuarios["Tipo"]==1){$tipo='Administrador';}
    elseif($RResUsuarios["Tipo"]==0){$tipo='Usuario';}
    $cadena.='      <tr style="background: '.$bgcolor.'" id="row_'.$T.'">
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$T.'</td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResUsuarios["Nombre"].'</td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$RResUsuarios["Usuario"].'</td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$tipo.'</td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="edit_usuario(\''.$RResUsuarios["Id"].'\')"><i class="fa-solid fa-pen"></i></a></td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="dele_usuario(\''.$RResUsuarios["Id"].'\')"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>';
    $T++;
    if($bgcolor=='#ffffff'){$bgcolor='#cccccc';}
    elseif($bgcolor=='#cccccc'){$bgcolor="#ffffff";}
}
echo $cadena;
?>
<script>
//agregar usuario
function add_usuario(){
	$.ajax({
				type: 'POST',
				url : 'config/add_usuario.php'
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
function edit_usuario(usuario){
	$.ajax({
				type: 'POST',
				url : 'config/edit_usuario.php',
                data: 'usuario=' + usuario
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
function dele_usuario(usuario){
	$.ajax({
				type: 'POST',
				url : 'config/dele_usuario.php',
                data: 'usuario=' + usuario
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>