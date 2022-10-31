<?php
include("../conexion.php");

$ResSeccion=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$_POST["seccion"]."' LIMIT 1"));

if($ResSeccion["Depende"]!=0)
{
    $ResSecSup=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$ResSeccion["Depende"]."' LIMIT 1"));

    $superior=$ResSecSup["Nombre"].' / ';
}

$cadena='<div class="c100" style="display:flex; flex-wrap: wrap;">
            <h2>Agregar archivo para: '.$superior.$ResSeccion["Nombre"].'</h2>
        </div>
        
        <form name="fadfile" id="fadfile"  enctype="multipart/form-data">
        <div class="c100" style="display:flex; flex-wrap: wrap;">
            <div class="c25">
                <label class="l_form">Código: </label>
                <input type="text" name="codigo" id="codigo">
            </div>
            <div class="c25">
                <label class="l_form">Sub - Código: </label>
                <input type="text" name="subcodigo" id="subcodigo">
            </div>

            <div class="c100">
                <label class="l_form">Titulo: </label>
                <input type="text" name="titulo" id="titulo">
            </div>
            <div class="c100">
                <label class="l_form">Sub - Titulo: </label>
                <input type="text" name="subtitulo" id="subtitulo">
            </div>
            <div class="c100">
                <label class="l_form">Dirección del documento: </label>
                <input type="text" name="dirdocumento" id="dirdocumento" placeholder="https://">
            </div>
            <div class="c100">
                <label class="l_form">Registro: </label>
                <div style="">
                <div class="file-input-container">
                <input type="file" class="sm-input-file" id="sm-ip-1" name="filer"/>
                <label class="for-sm-input-file" for="sm-ip-1">Agregar Archivo</label>
                <span class="span-text" id="file-name"></span>
                </div>
                </div>
            </div>
            <div class="c100">
                <input type="hidden" name="seccion" id="seccion" value="'.$_POST["seccion"].'">
                <input type="hidden" name="hacer" id="hacer" value="adfile">
                <input type="submit" name="botadfile" id="botadfile" value="Agregar" onclick="cerrarmodal()">
            </div>
        </div>
        </form>';

echo $cadena;
?>
<script>
//file
$('#sm-ip-1').on('change',function(event){
    var name = event.target.files[0].name;
    $('#file-name').text(name);
})

$("#fadfile").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadfile"));

	$.ajax({
		url: "config/files.php",
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