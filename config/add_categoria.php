<?php
include("../conexion.php");

$cadena='<div class="c100">
            <form name="fadcategoria" id="fadcategoria">
            <table>
                <thead>
                    <tr>
                        <th>Agregar Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Nombre:</label>
                                <input type="text" name="categoria" id="categoria">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Depende de:</label>
                                <select name="depende" id="depende">
                                    <option value="0">No depende</option>';
$ResCategorias=mysqli_query($conn, "SELECT * FROM secciones WHERE Tipo='C' AND Depende='0' ORDER BY Nombre ASC");
while($RResCategorias=mysqli_fetch_array($ResCategorias))
{
    $cadena.='                      <option value="'.$RResCategorias["Id"].'">'.$RResCategorias["Nombre"].'</option>';
}
$cadena.='                      </selecta>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <input type="hidden" name="hacer" id="hacer" value="addcategoria">
                                <input type="submit" name="botadcategoria" id="botadcategoria" value="Agregar>>">
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
$("#fadcategoria").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadcategoria"));

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