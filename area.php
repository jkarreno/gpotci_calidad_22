<?php
include("conexion.php");

$ResArea=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM areas WHERE Id='".$_POST["area"]."' LIMIT 1"));
$ResFiles=mysqli_query($conn, "SELECT * FROM Archivos WHERE Area='".$_POST["area"]."' AND Categoria='".$_POST["categoria"]."' ORDER BY Codigo ASC");

$cadena='<div class="c100"">
            <table>
            <thead>
                <tr>
                    <th colspan="12" align="center" class="textotitable">'.$ResA["Nombre"].'</td>
                </tr>
                <tr>
                    <th align="center" class="textotitable">Codigo</th>
                    <th align="center" class="textotitable">Documento</th>
                    <th align="center" class="textotitable">&nbsp;</th>
                    <th align="center" class="textotitable">&nbsp;</th>
                </tr>
            </thead>
            <tbody>';
$bgcolor='#ffffff'; $J=1;
while($RResFiles=mysqli_fetch_array($ResFiles))
{
    $cadena.='  <tr style="background: '.$bgcolor.'" id="row_'.$J.'">
                    <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$RResFiles["Codigo"].'</td>
                    <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResFiles["Nombre"].'</td>
                    <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';
    if($RResFiles["Url_d"]!='')
    {
        $cadena.='<a href="'.$RResFiles["Url_d"].'" target="_blank">';
        if($RResFiles["Extension_d"]=='pdf')
        {
            $cadena.='<i class="fa-solid fa-file-pdf"></i>';
        }
        $cadena.='</a>';
    }
    $cadena.='      </td>
                    <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';
    if($RResFiles["Archivo_r"]!='')
    {
        $cadena.='<a href="'.$RResFiles["Archivo_r"].'" download>';
        if($RResFiles["Extension_r"]=='doc' OR $RResFiles["Extension_r"]=='docx')
        {
            $cadena.='<i class="fa-solid fa-file-word"></i>';
        }
        elseif($RResFiles["Extension_r"]=='xls' OR $RResFiles["Extension_r"]=='xlsx')
        {
            $cadena.='<i class="fa-solid fa-file-excel"></i>';
        }
        $cadena.='</a>';
    }
    $cadena.='      </td>
                </tr>';

    if($bgcolor=="#ffffff"){$bgcolor="#cccccc";}
    elseif($bgcolor=="#cccccc"){$bgcolor="#ffffff";}

    $J++;
}
$cadena.='  </tbody>
            </table>
        </div>';

echo $cadena;