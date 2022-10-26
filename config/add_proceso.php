<?php
include("../conexion.php");

$cadena='<div class="c100">
            <form name="fadproceso" id="fadproceso">
            <table>
                <thead>
                    <tr>
                        <th>Agregar Proceso</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Nombre:</label>
                                <input type="text" name="proceso" id="proceso">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Depende de:</label>
                                <select name="depende" id="depende">
                                    <option value="0">No depende</option>';
$ResProcesos=mysqli_query($conn, "SELECT * FROM secciones WHERE Tipo='P' AND Depende='0' ORDER BY Nombre ASC");
while($RResProcesos=mysqli_fetch_array($ResProcesos))
{
    $cadena.='                      <option value="'.$RResProcesos["Id"].'">'.$RResProcesos["Nombre"].'</option>';
}
$cadena.='                      </selecta>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <input type="hidden" name="hacer" id="hacer" value="addproceso">
                                <input type="submit" name="botadproceso" id="botadproceso" value="Agregar>>">
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
$("#fadproceso").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadproceso"));

	$.ajax({
		url: "config/procesos.php",
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