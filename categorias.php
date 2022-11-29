<?php
include("conexion.php");

$ResCategorias=mysqli_query($conn, "SELECT * FROM secciones WHERE Tipo='C' AND Depende='0' ORDER BY Orden ASC");

$cadena='<div class="c100" style="display: flex; flex-wrap:wrap;">';
while($RResCat=mysqli_fetch_array($ResCategorias))
{
    $cadena.='<div class="titulos_top" onclick="seccion(\''.$RResCat["Id"].'\')">'.$RResCat["Nombre"].'</div>';
}
$cadena.='</div>
        <div class="c100" id="conteni2" style="display: flex; flex-wrap:wrap;"></div>';

echo $cadena;