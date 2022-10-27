<?php
include("../conexion.php");


$cadena='<div class="c100" style="display: flex;">
            <div class="titulos_top" onclick="procesos()"><i class="fa-solid fa-folder"></i> Procesos</div>
            <div class="titulos_top" onclick="categorias()"><i class="fa-solid fa-folder"></i> Categorias</div>
            <div class="titulos_top" onclick="area(\'0\', \'18\')"><i class="fa-solid fa-file"></i> Archivos</div>
            <div class="titulos_top" onclick="area(\'0\', \'1\')"><i class="fa-solid fa-users"></i> Usuarios</div>
            <div class="titulos_top" onclick="area(\'0\', \'10\')"><i class="fa-solid fa-book"></i> Bitacora</div>
        </div>
        
        <div class="c100" id="conteni2">
            <table>
                <thead>
                    <tr>
                        <td align="left">
                            <select name="areas" id="areas" onchange="configuracion(this.value)">
                                <option value="0">Manual de calidad</option>';
$ResAreas=mysqli_query($conn, "SELECT * FROM areas ORDER BY Id ASC");
while($RResA=mysqli_fetch_array($ResAreas))
{
    $cadena.='                  <option value="'.$RResA["Id"].'">'.utf8_encode($RResA["Nombre"]).'</option>';
}
$cadena.='                 </select>
                        </td>
                        <td colspan="5" align="right">| <a href="#" onclick="xajax_agregar_archivo()">Agregar Archivo</a> |</td>
                    </tr>
                    <tr>
                        <th align="center" class="textotitable">Categoría</th>
                        <th align="center" class="textotitable">Código</th>
                        <th align="center" class="textotitable">Titulo</th>
                        <th align="center" class="textotitable">Subtitulo</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>';
$bgcolor='#ffffff'; $J=1;
$ResArchivos=mysqli_query($conn, "SELECT * FROM Archivos WHERE Area='".$_POST["area"]."' ORDER BY Id");
while($RResArchivos=mysqli_fetch_array($ResArchivos))
{
    $ResCat=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM categorias WHERE Id='".$RResArchivos["Categoria"]."' LIMIT 1"));

    $cadena.='      <tr style="background: '.$bgcolor.'" id="row_'.$J.'">
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$ResCat["Nombre"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$RResArchivos["Codigo"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResArchivos["Nombre"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResArchivos["Subtitulo"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle"></td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle"></td>
                    </tr>';

    if($bgcolor=="#ffffff"){$bgcolor="#cccccc";}
    elseif($bgcolor=="#cccccc"){$bgcolor="#ffffff";}

    $J++;
}
$cadena.='      </tbody>
        </div>';

echo $cadena;

?>
<script>
//procesos
function procesos(){
	$.ajax({
				type: 'POST',
				url : 'config/procesos.php'
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
function add_proceso(){
    $.ajax({
				type: 'POST',
				url : 'config/add_proceso.php'
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
function edit_proceso(proceso){
    $.ajax({
				type: 'POST',
				url : 'config/edit_proceso.php',
                data: 'proceso=' + proceso
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
function dele_proceso(proceso){
    $.ajax({
				type: 'POST',
				url : 'config/dele_proceso.php',
                data: 'proceso=' + proceso
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
function del_pro(proceso){
    $.ajax({
				type: 'POST',
				url : 'config/procesos.php',
                data: 'proceso=' + proceso + '&hacer=delproceso'
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
//categorias
function categorias(){
	$.ajax({
				type: 'POST',
				url : 'config/categorias.php'
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
function add_categoria(){
    $.ajax({
				type: 'POST',
				url : 'config/add_categoria.php'
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
function edit_categoria(categoria){
    $.ajax({
				type: 'POST',
				url : 'config/edit_categoria.php',
                data: 'categoria=' + categoria
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
function dele_categoria(categoria){
    $.ajax({
				type: 'POST',
				url : 'config/dele_categoria.php',
                data: 'categoria=' + categoria
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
function del_cat(categoria){
    $.ajax({
				type: 'POST',
				url : 'config/categorias.php',
                data: 'categoria=' + categoria + '&hacer=delcategoria'
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
</script>