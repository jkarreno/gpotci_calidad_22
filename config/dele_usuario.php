<?php
include("../conexion.php");

$ResUsuario=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE Id='".$_POST["usuario"]."' LIMIT 1"));

$cadena='<div class="c100">
            <table>
                <thead>
                    <tr>
                        <th>Borrar Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form"><i class="fa-solid fa-triangle-exclamation" style="color: #efec25"></i> ¿Esta seguro de borrar el usuario: <span class="palabra">'.$ResUsuario["Nombre"].'</span> ?</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form" style="text-align: center"><a hreF="#" class="botona" onclick="del_usuario(\''.$ResUsuario["Id"].'\')">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:voic(0)" class="botona" onclick="usuarios()">No</a></label>
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
//sube nivel
function del_usuario(usuario){
	$.ajax({
				type: 'POST',
				url : 'config/usuarios.php',
                data: 'usuario=' + usuario +'&hacer=delusuario'
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}