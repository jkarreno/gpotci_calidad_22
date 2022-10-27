<?php
include("../conexion.php");

$ResProceso=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$_POST["proceso"]."' AND Tipo='P' LIMIT 1"));

$cadena='<div class="c100">
            <form name="feditproceso" id="feditproceso">
            <table>
                <thead>
                    <tr>
                        <th>Editar Proceso</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Nombre:</label>
                                <input type="text" name="proceso" id="proceso" value="'.$ResProceso["Nombre"].'">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form">Depende de:</label>
                                <select name="depende" id="depende">
                                    <option value="0"';if($ResProceso["Depende"]==0){$cadena.=' selected';}$cadena.='>No depende</option>';
$ResProcesos=mysqli_query($conn, "SELECT * FROM secciones WHERE Tipo='P' AND Depende='0' ORDER BY Nombre ASC");
while($RResProcesos=mysqli_fetch_array($ResProcesos))
{
    $cadena.='                      <option value="'.$RResProcesos["Id"].'"';if($ResProceso["Depende"]==$RResProcesos["Id"]){$cadena.=' selected';}$cadena.='>'.$RResProcesos["Nombre"].'</option>';
}
$cadena.='                      </selecta>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <input type="hidden" name="hacer" id="hacer" value="editproceso">
                                <input type="hidden" name="idproceso" id="idproceso" value="'.$ResProceso["Id"].'">
                                <input type="submit" name="boteditproceso" id="boteditproceso" value="Editar>>">
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
$("#feditproceso").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditproceso"));

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