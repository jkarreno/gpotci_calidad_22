<?php
include("conexion.php");

$cadena='<div class="c100" style="display: flex;">
            <div class="titulos_top" onclick="area(\'0\', \'0\')">Manual de Calidad</div>
            <div class="titulos_top" onclick="area(\'0\', \'18\')">Mercancias Vulnerables</div>
            <div class="titulos_top" onclick="area(\'0\', \'1\')">Información Documentada</div>
            <div class="titulos_top" onclick="area(\'0\', \'10\')">Satisfacción del Cliente y Tratamiento de Quejas</div>
            <div class="titulos_top" onclick="area(\'0\', \'11\')">Acciones Correctivas y de mejora</div>
            <div class="titulos_top" onclick="area(\'0\', \'12\')">Servicio no Conforme</div>
            <div class="titulos_top" onclick="area(\'0\', \'14\')">Analisis de riesgo</div>
            <div class="titulos_top" onclick="area(\'0\', \'15\')">Seguridad Física</div>
            <div class="titulos_top" onclick="area(\'0\', \'16\')">Seguridad de Acceso</div>
        </div>
        
        <div class="c100" id="conteni2">
        </div>';

echo $cadena;
?>
<script>
function area(area, categoria){
	$.ajax({
				type: 'POST',
				url : 'area.php',
				data: 'area=' + area + '&categoria=' + categoria
	}).done (function ( info ){
		$('#conteni2').html(info);
	});

}
</script>