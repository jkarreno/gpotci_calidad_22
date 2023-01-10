<?php
include("../conexion.php");

$cadena='<div class="c100">
            <form name="fadusuario" id="fadusuario">
            <table>
                <thead>
                    <tr>
                        <th>Agregar Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Nombre:</label>
                                <input type="text" name="nombre" id="nombre">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Usuario:</label>
                                <input type="text" name="usuario" id="usuario">
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
                                    <option value="0">Usuario</option>
                                    <option value="1">Administrador</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div class="c100">
                                <input type="hidden" name="hacer" id="hacer" value="addusuario">
                                <input type="submit" name="botadusuario" id="botadusuario" value="Agregar>>">
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
$("#fadusuario").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadusuario"));

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