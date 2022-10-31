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
$ResFiles($conn, "SELECT * FROM Archivos WHERE Seccion='".$_POST["seccion"]."' ORDER BY Codigo ASC");
$bgcolor="#ffffff"; $J=1;
while($RResFiles=mysqli_fetch_array($ResFiles))
{
    if()$ext_r=explode('.', $nombre_archivo_r);
    $cadena.='      <tr style="background: '.$bgcolor.'" id="row_'.$J.'">
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$J.'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$RResFiles["Codigo"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$RResFiles["Nombre"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="'.$RResFiles["Url_d"].'" target="_blank"><i class="fa-solid fa-file-pdf"></i></a></td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="files/'.$_POST["seccion"].'/'.$RResFiles["Archivo_r"].'" target="_blank">'.$ico.'</a><td>
                    </tr>';

    if($bgcolor=="#ffffff"){$bgcolor="#cccccc";}
    elseif($bgcolor=="#cccccc"){$bgcolor="#ffffff";}
                
    $J++;
}
$cadena.='  </tbody>
            </table>
        </div>';

echo $cadena;