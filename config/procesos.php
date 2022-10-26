<?php
include("../conexion.php");

//Acciones
if(isset($_POST["hacer"]))
{
    if($_POST["hacer"]=='addproceso')
    {
        mysqli_query($conn, "INSERT INTO secciones (Nombre, Tipo, Depende) VALUES ('".$_POST["proceso"]."', 'P', '".$_POST["depende"]."')") or die(mysqli_error($conn));

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego el proceso '.$_POST["proceso"].'</div>';
    }
}


$cadena=$mensaje.'<div class="c100" id="conteni2">
            <table>
                <thead>
                    <tr>
                        <td colspan="4" align="right">| <a href="#" onclick="add_proceso()">Agregar Proceso</a> |</td>
                    </tr>
                    <tr>
                        <th align="center" class="textotitable">#</th>
                        <th align="center" class="textotitable">Proceso</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>';
$bgcolor="#ffffff"; $J=1;
$ResProcesos=mysqli_query($conn, "SELECT * FROM secciones WHERE TIpo='P' ORDER BY Nombre ASC");
while($RResProcesos=mysqli_fetch_array($ResProcesos))
{
    $cadena.='      <tr style="background: '.$bgcolor.'" id="row_'.$J.'">
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$J.'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResProcesos["Nombre"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><i class="fa-solid fa-pen"></i></td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><i class="fa-solid fa-trash"></i></td>
                    </tr>';

    if($bgcolor=="#ffffff"){$bgcolor="#cccccc";}
    elseif($bgcolor=="#cccccc"){$bgcolor="#ffffff";}

    $J++;
    
}
$cadena.='      </tbody>
            </table>
        </div>';

echo $cadena;