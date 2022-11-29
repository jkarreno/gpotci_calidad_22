<?php
include("conexion.php");
include("funciones.php");

$ResSeccion=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$_POST["seccion"]."' LIMIT 1"));

$ResSubSeccion=mysqli_query($conn, "SELECT * FROM secciones WHERE Depende='".$_POST["seccion"]."' ORDER BY Nombre ASC");

if($ResSeccion["Depende"]!=0)
{
    $ResSecSup=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$ResSeccion["Depende"]."' LIMIT 1"));

    $superior=$ResSecSup["Nombre"].' / ';
}

$cadena='<div class="c100" style="display: flex; flex-wrap:wrap;">
            <h2>'.$superior.$ResSeccion["Nombre"].'</h2>
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
                    <th align="center" class="textotitable">Codigo</th>
                    <th align="center" class="textotitable">Actualizado</th>
                    <th align="center" class="textotitable">Titulo</th>
                    <th align="center" class="textotitable">&nbsp;</th>
                    <th align="center" class="textotitable">&nbsp;</th>
                </tr>
            </thead>
            <tbody>';
$ResFiles=mysqli_query($conn, "SELECT * FROM Archivos WHERE Seccion='".$_POST["seccion"]."' ORDER BY Codigo ASC");
$bgcolor="#ffffff"; $J=1;
while($RResFiles=mysqli_fetch_array($ResFiles))
{
    if($RResFiles["Archivo_r"]!='' AND $RResFiles["Extension_r"]!='')
    {
        if($RResFiles["Extension_r"]=='doc' OR $RResFiles["Extension_r"]=='docx'){$ico='<i class="fa-solid fa-file-word" style="color:#015097"></i>';}
        elseif($RResFiles["Extension_r"]=='xls' OR $RResFiles["Extension_r"]=='xlsx'){$ico='<i class="fa-solid fa-file-excel" style="color:#016e38"></i>';}
        elseif($RResFiles["Extension_r"]=='pdf'){$ico='<i class="fa-solid fa-file-pdf" style="color:#ad0b00"></i>';}

        $archivo='<a href="files/'.$_POST["seccion"].'/'.$RResFiles["Archivo_r"].'" target="_blank">'.$ico.'</a>';

        if($RResFiles["Extension_r"]=='' OR $RResFiles["Extension_r"]==NULL){$archivo='';}
    }
    $cadena.='      <tr style="background: '.$bgcolor.'" id="row_'.$J.'">
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$RResFiles["Codigo"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.fechados($RResFiles["FechaUpdate"]).'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResFiles["Nombre"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="'.$RResFiles["Url_d"].'" target="_blank"><i class="fa-solid fa-file-pdf" style="color:#ad0b00"></i></a></td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$archivo.'</td>
                    </tr>';

    if($bgcolor=="#ffffff"){$bgcolor="#cccccc";}
    elseif($bgcolor=="#cccccc"){$bgcolor="#ffffff";}
                
    $J++; $archivo='';
}
$cadena.='  </tbody>
            </table>
        </div>';

echo $cadena;