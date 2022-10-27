<?php
include("../conexion.php");

//Acciones
if(isset($_POST["hacer"]))
{
    if($_POST["hacer"]=='addcategoria')
    {
        mysqli_query($conn, "INSERT INTO secciones (Nombre, Tipo, Depende) VALUES ('".$_POST["categoria"]."', 'C', '".$_POST["depende"]."')") or die(mysqli_error($conn));

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego la categoría '.$_POST["categoria"].'</div>';

        $ultimo=mysqli_fetch_array(mysqli_query($conn, "SELECT Id FROm secciones ORDER BY Id DESC LIMIT 1"));

        //crea carpeta
        mkdir("../files/".$ultimo["Id"], 0777, true);
        chmod("../files/".$ultimo["Id"], 0777);
    }
    if($_POST["hacer"]=='editcategoria')
    {
        mysqli_query($conn, "UPDATE secciones SET Nombre='".$_POST["categoria"]."', 
                                                    Depende='".$_POST["depende"]."'
                                            WHERE Id='".$_POST["idcategoria"]."' AND Tipo='C'") OR die(mysqli_error($conn));

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se actualizo la categoria '.$_POST["categoria"].'</div>';
    }
    if($_POST["hacer"]=='delcategoria')
    {
        $ResCategoria=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM secciones WHERE Id='".$_POST["categoria"]."' AND Tipo='C' LIMIT 1"));

        mysqli_query($conn, "DELETE FROM secciones WHERE Id='".$_POST["categoria"]."' AND Tipo='C'");

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se elimino la categoria '.$ResCategoria["Nombre"].'</div>';

        $files = glob('../files/'.$_POST["categoria"].'/*'); //obtenemos todos los nombres de los ficheros
        foreach($files as $file){
            if(is_file($file))
            unlink($file); //elimino el fichero
        }
        rmdir('../files/'.$_POST["categoria"]);
    }
}


$cadena=$mensaje.'<div class="c100" id="conteni2">
            <table>
                <thead>
                    <tr>
                        <td colspan="4" align="right">| <a href="#" onclick="add_categoria()">Agregar Categoría</a> |</td>
                    </tr>
                    <tr>
                        <th align="center" class="textotitable">#</th>
                        <th align="center" class="textotitable">Categoria</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>';
$bgcolor="#ffffff"; $J=1; $T=1000;
$ResCategoria=mysqli_query($conn, "SELECT * FROM secciones WHERE TIpo='C' AND Depende='0' ORDER BY Nombre ASC");
while($RResCategoria=mysqli_fetch_array($ResCategoria))
{
    $cadena.='      <tr style="background: '.$bgcolor.'" id="row_'.$J.'">
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$J.'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResCategoria["Nombre"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="edit_categoria(\''.$RResCategoria["Id"].'\')"><i class="fa-solid fa-pen"></i></a></td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="dele_categoria(\''.$RResCategoria["Id"].'\')"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>';

    if($bgcolor=="#ffffff"){$bgcolor="#cccccc";}
    elseif($bgcolor=="#cccccc"){$bgcolor="#ffffff";}

    $J++;
    
    $ResSubCategoria=mysqli_query($conn, "SELECT * FROM secciones WHERE Tipo='C' AND Depende='".$RResCategoria["Id"]."' ORDER BY Nombre ASC");
    if(mysqli_num_rows($ResSubCategoria)>0)
    {
        while($RResSC=mysqli_fetch_array($ResSubCategoria))
        {
            $cadena.='<tr style="background: '.$bgcolor.'" id="row_'.$T.'">
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"></td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle"><i class="fa-solid fa-folder-tree itree"></i> '.$RResSC["Nombre"].'</td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="edit_categoria(\''.$RResSC["Id"].'\')"><i class="fa-solid fa-pen"></i></a></td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="dele_categoria(\''.$RResSC["Id"].'\')"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>';

            if($bgcolor=="#ffffff"){$bgcolor="#cccccc";}
            elseif($bgcolor=="#cccccc"){$bgcolor="#ffffff";}
            
            $T++;
        }
    }
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