<?php
include("conexion.php");

$ResSeccion=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$_POST["seccion"]."' LIMIT 1"));

$ResSubSeccion=mysqli_query($conn, "SELECT * FROM secciones WHERE Depende='".$_POST["seccion"]."' ORDER BY Nombre ASC");

$cadena='<div class="c100" style="display: flex; flex-wrap:wrap;">
            <h2>'.$ResSeccion["Nombre"].'</h2>
        </div>';
//subsecciones
if(mysqli_num_rows($ResSubSeccion)>0)
{
    $cadena.='<div class="c100" style="display: flex;">';
    while($RResSS=mysqli_fetch_array($ResSubSeccion))
    {
        $cadena.='<div class="titulos_top" onclick="seccion(\''.$RResSS["Id"].'\')">'.$RResSS["Nombre"].'</div>';
    }
    $cadena.='</div>';
}
//archivos de seccion
$cadena.='<div class="c100" style="display: flex; flex-wrap:wrap;">
            <table>
            <thead>
                <tr>
                    <th align="center" class="textotitable">#</th>
                    <th align="center" class="textotitable">Codigo</th>
                    <th align="center" class="textotitable">Titulo</th>
                    <th align="center" class="textotitable">&nbsp;</th>
                    <th align="center" class="textotitable">&nbsp;</th>
                </tr>
            </thead>
            <tbody>';

echo $cadena;