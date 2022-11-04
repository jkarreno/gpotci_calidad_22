<?php
include("../conexion.php");

$ResFile=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM Archivos WHERE Id='".$_POST["file"]."' LIMIT 1"));

$ResSeccion=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$ResFile["seccion"]."' LIMIT 1"));

if($ResSeccion["Depende"]!=0)
{
    $ResSecSup=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$ResSeccion["Depende"]."' LIMIT 1"));

    $superior=$ResSecSup["Nombre"].' / ';
}

$cadena='<div class="c100" style="display:flex; flex-wrap: wrap;">
            <h2>Editar archivo para: '.$superior.$ResSeccion["Nombre"].'</h2>
        </div>
        
        <form name="feditfile" id="feditfile"  enctype="multipart/form-data">
        <div class="c100" style="display:flex; flex-wrap: wrap;">
            <div class="c25">
                <label class="l_form">Código: </label>
                <input type="text" name="codigo" id="codigo" value="'.$ResFile["Codigo"].'">
            </div>
            <div class="c25">
                <label class="l_form">Sub - Código: </label>
                <input type="text" name="subcodigo" id="subcodigo" value="'.$ResFile["SubCodigo"].'">
            </div>

            <div class="c100">
                <label class="l_form">Titulo: </label>
                <input type="text" name="titulo" id="titulo" value="'.$ResFile["Nombre"].'">
            </div>
            <div class="c100">
                <label class="l_form">Sub - Titulo: </label>
                <input type="text" name="subtitulo" id="subtitulo" value="'.$ResFile["Subtitulo"].'">
            </div>
            <div class="c100">
                <label class="l_form">Dirección del documento: </label>
                <input type="text" name="dirdocumento" id="dirdocumento" placeholder="https://" value="'.$ResFile["Url_d"].'">
            </div>
            <div class="c100" id="divfile" style="margin-top: 20px;">';
if($ResFile["Archivo_r"]=='' OR $ResFile["Archivo_r"]==NULL)
{
    $cadena.='  <label class="l_form">Registro: </label>
                <div style="">
                    <div class="file-input-container">
                        <input type="file" class="sm-input-file" id="sm-ip-1" name="filer"/>
                        <label class="for-sm-input-file" for="sm-ip-1">Agregar Archivo</label>
                        <span class="span-text" id="file-name"></span>
                    </div>
                </div>';
}
else
{
    $cadena.=$ResFile["Archivo_r"].' <a href="#" onclick="del_file(\''.$ResFile["Id"].'\')"><i class="fa-solid fa-trash" style="font-size: 16px;"></i></a>';
}
$cadena.='  </div>
            <div class="c100">
                <input type="hidden" name="seccion" id="seccion" value="'.$ResFile["Seccion"].'">
                <input type="hidden" name="idfile" id="idfile" value="'.$ResFile["Id"].'">
                <input type="hidden" name="hacer" id="hacer" value="editfile">
                <input type="submit" name="boteditfile" id="boteditfile" value="Editar" onclick="cerrarmodal()">
            </div>
        </div>
        </form>';

echo $cadena;
?>
<script>
function del_file(file, accion){
	$.ajax({
				type: 'POST',
				url : 'config/delfile.php',
                data: 'file=' + file + '&accion=' + accion
	}).done (function ( info ){
		$('#divfile').html(info);
	});
}

//file
$('#sm-ip-1').on('change',function(event){
    var name = event.target.files[0].name;
    $('#file-name').text(name);
})

$("#feditfile").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditfile"));

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
