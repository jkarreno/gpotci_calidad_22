<?php
include("../conexion.php");

//Acciones
if(isset($_POST["hacer"]))
{
    if($_POST["hacer"]=='addproceso')
    {
        mysqli_query($conn, "INSERT INTO secciones (Nombre, Tipo, Depende) VALUES ('".$_POST["proceso"]."', 'P', '".$_POST["depende"]."')") or die(mysqli_error($conn));

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego el proceso '.$_POST["proceso"].'</div>';

        $ultimo=mysqli_fetch_array(mysqli_query($conn, "SELECT Id FROm secciones ORDER BY Id DESC LIMIT 1"));

        //crea carpeta
        mkdir("../files/".$ultimo["Id"], 0777, true);
        chmod("../files/".$ultimo["Id"], 0777);
    }
    if($_POST["hacer"]=='editproceso')
    {
        mysqli_query($conn, "UPDATE secciones SET Nombre='".$_POST["proceso"]."', 
                                                    Depende='".$_POST["depende"]."'
                                            WHERE Id='".$_POST["idproceso"]."' AND Tipo='P'") OR die(mysqli_error($conn));

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se actualizo el proceso '.$_POST["proceso"].'</div>';
    }
    if($_POST["hacer"]=='delproceso')
    {
        $ResProceso=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM secciones WHERE Id='".$_POST["proceso"]."' AND Tipo='P' LIMIT 1"));

        mysqli_query($conn, "DELETE FROM secciones WHERE Id='".$_POST["proceso"]."' AND Tipo='P'");

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se elimino el proceso '.$_POST["proceso"].'</div>';

        $files = glob('../files/'.$_POST["proceso"].'/*'); //obtenemos todos los nombres de los ficheros
        foreach($files as $file){
            if(is_file($file))
            unlink($file); //elimino el fichero
        }
        rmdir('../files/'.$_POST["proceso"]);
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
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="edit_proceso(\''.$RResProcesos["Id"].'\')"><i class="fa-solid fa-pen"></i></a></td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="dele_proceso(\''.$RResProcesos["Id"].'\')"><i class="fa-solid fa-trash"></i></a></td>
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
<script>
//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>