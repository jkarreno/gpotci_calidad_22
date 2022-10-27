<?php
include("../conexion.php");

$ResCategoria=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$_POST["categoria"]."' AND Tipo='C' LIMIT 1"));

$cadena='<div class="c100">
            <form name="feditcategoria" id="feditcategoria">
            <table>
                <thead>
                    <tr>
                        <th>Editar categoría</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Nombre:</label>
                                <input type="text" name="categoria" id="categoria" value="'.$ResCategoria["Nombre"].'">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Depende de:</label>
                                <select name="depende" id="depende">
                                    <option value="0"';if($ResCategoria["Depende"]==0){$cadena.=' selected';}$cadena.='>No depende</option>';
$ResCategorias=mysqli_query($conn, "SELECT * FROM secciones WHERE Tipo='C' AND Depende='0' ORDER BY Nombre ASC");
while($RResCategorias=mysqli_fetch_array($ResCategorias))
{
    $cadena.='                      <option value="'.$RResCategorias["Id"].'"';if($ResCategoria["Depende"]==$RResCategorias["Id"]){$cadena.=' selected';}$cadena.='>'.$RResCategorias["Nombre"].'</option>';
}
$cadena.='                      </selecta>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <input type="hidden" name="hacer" id="hacer" value="editcategoria">
                                <input type="hidden" name="idcategoria" id="idcategoria" value="'.$ResCategoria["Id"].'">
                                <input type="submit" name="boteditcategoria" id="boteditcategoria" value="Editar>>">
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
$("#feditcategoria").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditcategoria"));

	$.ajax({
		url: "config/categorias.php",
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