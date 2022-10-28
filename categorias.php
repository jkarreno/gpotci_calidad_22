<?php
include("conexion.php");

$ResCategorias=mysqli_query($conn, "SELECT * FROM secciones WHERE Tipo='C' AND Depende='0' ORDER BY Id ASC");

$cadena='<div class="c100" style="display: flex;">';
while($RResCat=mysqli_fetch_array($ResCategorias))
{
    $cadena.='<div class="titulos_top" onclick="categoria(\''.$RResCat["Id"].'\')">'.$RResCat["Nombre"].'</div>';
}
$cadena.='</div>';

echo $cadena;