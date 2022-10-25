<?php
include("conexion.php");

$cadena='Resultados obtenidos para: <span class="palabra">'.$_POST["q"].'</span>';

$cadena.='<div class="c100">
            <table>
                <thead>
                    <tr>
                        <th align="center" class="textotitable">Área/Proceso</th>
                        <th align="center" class="textotitable">Código</th>
                        <th align="center" class="textotitable">Documento</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>';
$ResResultado=mysqli_query($conn, "SELECT * FROM Archivos WHERE Nombre LIKE '%".$_POST["q"]."%' ORDER BY Id ASC");
$bgcolor='#ffffff'; $J=1;
while($RResRes=mysqli_fetch_array($ResResultado))
{
    if($RResRes["Area"]==0)
    {
        if($RRes["Categoria"]==0){$areaproceso='Manual de Calidad';}
        if($RRes["Categoria"]==18){$areaproceso='Mercancias Vulnerables';}
        if($RRes["Categoria"]==1){$areaproceso='Información Documentada';}
        if($RRes["Categoria"]==10){$areaproceso='Satisfacción del Cliente y Tratamiento de Quejas';}
        if($RRes["Categoria"]==11){$areaproceso='Acciones Correctivas y de mejora';}
        if($RRes["Categoria"]==12){$areaproceso='Servicio no Conform';}
        if($RRes["Categoria"]==14){$areaproceso='Analisis de riesgo';}
        if($RRes["Categoria"]==15){$areaproceso='Seguridad Física';}
        if($RRes["Categoria"]==16){$areaproceso='Seguridad de Acceso';}
    }
    else
    {
        $ResArea=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM areas WHERE Id='".$RResRes["Area"]."' LIMIT 1"));
        $areaproceso=$ResArea["Nombre"];
    }
    

    $cadena.='      <tr style="background: '.$bgcolor.'" id="row_'.$J.'">
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.utf8_encode($areaproceso).'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$RResRes["Codigo"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResRes["Nombre"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';
    if($RResRes["Url_d"]!='')
    {
        $cadena.='          <a href="'.$RResRes["Url_d"].'" target="_blank">';
        if($RResRes["Extension_d"]=='pdf')
        {
            $cadena.='          <i class="fa-solid fa-file-pdf"></i>';
        }
        $cadena.='          </a>';
    }
    $cadena.='          </td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';
    if($RResRes["Archivo_r"]!='')
    {
        $cadena.='          <a href="'.$RResRes["Archivo_r"].'" download>';
        if($RResRes["Extension_r"]=='doc' OR $RResRes["Extension_r"]=='docx')
        {
            $cadena.='          <i class="fa-solid fa-file-word"></i>';
        }
        elseif($RResRes["Extension_r"]=='xls' OR $RResRes["Extension_r"]=='xlsx')
        {
            $cadena.='          <i class="fa-solid fa-file-excel"></i>';
        }
        $cadena.='          </a>';
    }
    $cadena.='          </td>
                    </tr>';

    if($bgcolor=="#ffffff"){$bgcolor="#cccccc";}
    elseif($bgcolor=="#cccccc"){$bgcolor="#ffffff";}

    $J++;
}
$cadena.='      </tbody>
            </table>
        </div>';


echo $cadena;

?>