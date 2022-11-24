<?php
include("../conexion.php");

//Acciones
if(isset($_POST["hacer"]))
{
    if($_POST["hacer"]=='addproceso')
    {
        $ResO=mysqli_fetch_array(mysqli_query($conn, "SELECT Orden, Depende FROM secciones WHERE Tipo='P' AND Depende='".$_POST["depende"]."' ORDER BY Orden DESC LIMIT 1"));

        if($ResO["Depende"]==0)
        {
            $orden=$ResO["Orden"]+1000;
        }
        else
        {
            $orden=$ResO["Orden"];
            $orden++;
        }

        mysqli_query($conn, "INSERT INTO secciones (Orden, Nombre, Tipo, Depende) VALUES ('".$orden."', '".$_POST["proceso"]."', 'P', '".$_POST["depende"]."')") or die(mysqli_error($conn));

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego el proceso '.$_POST["proceso"].'</div>';

        $ultimo=mysqli_fetch_array(mysqli_query($conn, "SELECT Id FROm secciones ORDER BY Id DESC LIMIT 1"));

        //crea carpeta
        mkdir("../files/".$ultimo["Id"], 0777, true);
        chmod("../files/".$ultimo["Id"], 0777);
    }
    //editar proceso
    if($_POST["hacer"]=='editproceso')
    {
        mysqli_query($conn, "UPDATE secciones SET Nombre='".$_POST["proceso"]."', 
                                                    Depende='".$_POST["depende"]."'
                                            WHERE Id='".$_POST["idproceso"]."' AND Tipo='P'") OR die(mysqli_error($conn));

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se actualizo el proceso '.$_POST["proceso"].'</div>';
    }
    //eliminar proceso
    if($_POST["hacer"]=='delproceso')
    {
        $ResProceso=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM secciones WHERE Id='".$_POST["proceso"]."' AND Tipo='P' LIMIT 1"));

        mysqli_query($conn, "DELETE FROM secciones WHERE Id='".$_POST["proceso"]."' AND Tipo='P'");

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se elimino el proceso '.$ResProceso["Nombre"].'</div>';

        $files = glob('../files/'.$_POST["proceso"].'/*'); //obtenemos todos los nombres de los ficheros
        foreach($files as $file){
            if(is_file($file))
            unlink($file); //elimino el fichero
        }
        rmdir('../files/'.$_POST["proceso"]);
    }
    //baja nivel
    if($_POST["hacer"]=='baja')
    {
        //superior
        $ResPro=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, Orden, Depende FROM secciones WHERE Id='".$_POST["proceso"]."' LIMIT 1"));
        $ResSup=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, Orden, Depende FROM secciones WHERE Tipo='P' AND Depende='".$ResPro["Depende"]."' AND Orden > '".$ResPro["Orden"]."' ORDER BY Orden ASC LIMIT 1"));

        mysqli_query($conn, "UPDATE secciones SET Orden='".$ResSup["Orden"]."' WHERE Id='".$ResPro["Id"]."'");
        mysqli_query($conn, "UPDATE secciones SET Orden='".$ResPro["Orden"]."' WHERE Id='".$ResSup["Id"]."'");
    }
    //sube nivel
    if($_POST["hacer"]=='sube')
    {
        //superior
        $ResPro=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, Orden, Depende FROM secciones WHERE Id='".$_POST["proceso"]."' LIMIT 1"));
        $ResInf=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, Orden, Depende FROM secciones WHERE Tipo='P' AND Depende='".$ResPro["Depende"]."' AND Orden < '".$ResPro["Orden"]."' ORDER BY Orden DESC LIMIT 1"));

        mysqli_query($conn, "UPDATE secciones SET Orden='".$ResPro["Orden"]."' WHERE Id='".$ResInf["Id"]."'");
        mysqli_query($conn, "UPDATE secciones SET Orden='".$ResInf["Orden"]."' WHERE Id='".$ResPro["Id"]."'");

        //$mensaje="UPDATE secciones SET Orden='".$ResPro["Orden"]."' WHERE Id='".$ResInf["Id"]."'"."UPDATE secciones SET Orden='".$ResInf["Orden"]."' WHERE Id='".$ResPro["Id"]."'";
        //$mensaje="SELECT Id, Orden, Depende FROM secciones WHERE Tipo='P' AND Depende='".$ResPro["Depende"]."' AND Orden < '".$ResPro["Orden"]."' ORDER BY Orden DESC LIMIT 1";
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
                        <th align="center" class="textotitable"></th>
                        <th align="center" class="textotitable"></th>
                        <th align="center" class="textotitable">Proceso</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>';
$bgcolor="#ffffff"; $J=1; $T=1000;
$ResProcesos=mysqli_query($conn, "SELECT * FROM secciones WHERE TIpo='P' AND Depende='0' ORDER BY Orden ASC");
$numpro=mysqli_num_rows($ResProcesos); $A=1;
while($RResProcesos=mysqli_fetch_array($ResProcesos))
{
    $cadena.='      <tr style="background: '.$bgcolor.'" id="row_'.$J.'">
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$J.'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';if($J>1){$cadena.='<a href="javascript:void(0)" onclick="nivel(\''.$RResProcesos["Id"].'\', \'sube\')"><i class="fa-solid fa-caret-up"></i></a>';}$cadena.='</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';if($A<$numpro){$cadena.='<a href="javascript:void(0)" onclick="nivel(\''.$RResProcesos["Id"].'\', \'baja\')"><i class="fa-solid fa-caret-down"></i></a>';}$cadena.='</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResProcesos["Nombre"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="edit_proceso(\''.$RResProcesos["Id"].'\')"><i class="fa-solid fa-pen"></i></a></td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="files(\''.$RResProcesos["Id"].'\')"><i class="fa-solid fa-file-arrow-up"></i></a></td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="dele_proceso(\''.$RResProcesos["Id"].'\')"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>';

    if($bgcolor=="#ffffff"){$bgcolor="#cccccc";}
    elseif($bgcolor=="#cccccc"){$bgcolor="#ffffff";}

    $J++; $A++;
    
    $ResSubProcesos=mysqli_query($conn, "SELECT * FROM secciones WHERE Tipo='P' AND Depende='".$RResProcesos["Id"]."' ORDER BY Orden ASC");
    if(mysqli_num_rows($ResSubProcesos)>0)
    {
        $numsubpro=mysqli_num_rows($ResSubProcesos); $K=1;
        while($RResSP=mysqli_fetch_array($ResSubProcesos))
        {
            $cadena.='<tr style="background: '.$bgcolor.'" id="row_'.$T.'">
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"></td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';if($K>1){$cadena.='<a href="javascript:void(0)" onclick="nivel(\''.$RResSP["Id"].'\', \'sube\')"><i class="fa-solid fa-caret-up"></i></a>';}$cadena.='</td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';if($K<$numsubpro){$cadena.='<a href="javascript:void(0)" onclick="nivel(\''.$RResSP["Id"].'\', \'baja\')"><i class="fa-solid fa-caret-down"></i></a>';}$cadena.='</td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle"><i class="fa-solid fa-folder-tree itree"></i> '.$RResSP["Nombre"].'</td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="edit_proceso(\''.$RResSP["Id"].'\')"><i class="fa-solid fa-pen"></i></a></td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="files(\''.$RResSP["Id"].'\')"><i class="fa-solid fa-file-arrow-up"></i></a></td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="dele_proceso(\''.$RResSP["Id"].'\')"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>';

            if($bgcolor=="#ffffff"){$bgcolor="#cccccc";}
            elseif($bgcolor=="#cccccc"){$bgcolor="#ffffff";}
            
            $T++; $K++;
        }
    }
}
$cadena.='      </tbody>
            </table>
        </div>';

echo $cadena;
?>
<script>
//sube nivel
function nivel(proceso, nivel){
	$.ajax({
				type: 'POST',
				url : 'config/procesos.php',
                data: 'proceso=' + proceso +'&hacer=' + nivel
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>