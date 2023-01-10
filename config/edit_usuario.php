<?php
include("../conexion.php");

$ResUsuario=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE Id='".$_POST["usuario"]."' LIMIT 1"));

$cadena='<div class="c100">
            <form name="feditusuario" id="feditusuario">
            <table>
                <thead>
                    <tr>
                        <th>Modificar Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" value="'.$ResUsuario["Nombre"].'">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Usuario:</label>
                                <input type="text" name="usuario" id="usuario" value="'.$ResUsuario["Usuario"].'">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Contraseña:</label>
                                <input type="text" name="contrasena" id="contrasena">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Perfil:</label>
                                <select name="perfil" id="perfil">
                                    <option value="0"';if($ResUsuario["Tipo"]==0){$cadena.=' selected';}$cadena.='>Usuario</option>
                                    <option value="1"';if($ResUsuario["Tipo"]==1){$cadena.=' selected';}$cadena.='>Administrador</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div class="c100">
                                <input type="hidden" name="idusuario" id="idusuario" value="'.$ResUsuario["Id"].'">
                                <input type="hidden" name="hacer" id="hacer" value="editusuario">
                                <input type="submit" name="boteditusuario" id="boteditusuario" value="Modificar>>">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            </form>
        </div>';
    
echo $cadena;
?>
<script>
$("#feditusuario").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditusuario"));

	$.ajax({
		url: "config/usuarios.php",
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