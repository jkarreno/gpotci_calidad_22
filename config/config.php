<?php
include("../conexion.php");


$cadena='<div class="c100" style="display: flex;">
            <div class="titulos_top" onclick="procesos()"><i class="fa-solid fa-folder"></i> Procesos</div>
            <div class="titulos_top" onclick="categorias()"><i class="fa-solid fa-folder"></i> Categorias</div>
            <div class="titulos_top" onclick="area(\'0\', \'1\')"><i class="fa-solid fa-users"></i> Usuarios</div>
            <div class="titulos_top" onclick="area(\'0\', \'10\')"><i class="fa-solid fa-book"></i> Bitacora</div>
        </div>
        
        <div class="c100" id="conteni2"></div>';

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

//archivos
function files(seccion){
	$.ajax({
				type: 'POST',
				url : 'config/files.php',
                data: 'seccion=' + seccion
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
function addfile(seccion){
	$.ajax({
				type: 'POST',
				url : 'config/addfiles.php',
                data: 'seccion=' + seccion
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}
function edit_file(file){
	$.ajax({
				type: 'POST',
				url : 'config/editfile.php',
                data: 'file=' + file
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}
</script>