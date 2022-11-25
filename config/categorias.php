<?php
include("../conexion.php");

//Acciones
if(isset($_POST["hacer"]))
{
    if($_POST["hacer"]=='addcategoria')
    {
        $ResC=mysqli_fetch_array(mysqli_query($conn, "SELECT Orden, Depende FROM secciones WHERE Tipo='C' AND Depende='".$_POST["depende"]."' ORDER BY Orden DESC LIMIT 1"));

        if($ResC["Depende"]==0)
        {
            $orden=$ResC["Orden"]+1000;
        }
        else
        {
            $orden=$ResC["Orden"];
            $orden++;
        }

        mysqli_query($conn, "INSERT INTO secciones (Orden, Nombre, Tipo, Depende) VALUES ('".$orden."', '".$_POST["categoria"]."', 'C', '".$_POST["depende"]."')") or die(mysqli_error($conn));

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
    //baja nivel
    if($_POST["hacer"]=='baja')
    {
        //superior
        $ResCat=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, Orden, Depende FROM secciones WHERE Id='".$_POST["categoria"]."' LIMIT 1"));
        $ResSup=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, Orden, Depende FROM secciones WHERE Tipo='C' AND Depende='".$ResCat["Depende"]."' AND Orden > '".$ResCat["Orden"]."' ORDER BY Orden ASC LIMIT 1"));

        mysqli_query($conn, "UPDATE secciones SET Orden='".$ResSup["Orden"]."' WHERE Id='".$ResCat["Id"]."'");
        mysqli_query($conn, "UPDATE secciones SET Orden='".$ResCat["Orden"]."' WHERE Id='".$ResSup["Id"]."'");

    }
    //sube nivel
    if($_POST["hacer"]=='sube')
    {
        //superior
        $ResCat=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, Orden, Depende FROM secciones WHERE Id='".$_POST["categoria"]."' LIMIT 1"));
        $ResInf=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, Orden, Depende FROM secciones WHERE Tipo='C' AND Depende='".$ResCat["Depende"]."' AND Orden < '".$ResCat["Orden"]."' ORDER BY Orden DESC LIMIT 1"));

        mysqli_query($conn, "UPDATE secciones SET Orden='".$ResCat["Orden"]."' WHERE Id='".$ResInf["Id"]."'");
        mysqli_query($conn, "UPDATE secciones SET Orden='".$ResInf["Orden"]."' WHERE Id='".$ResCat["Id"]."'");

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
                        <th align="center" class="textotitable"></th>
                        <th align="center" class="textotitable"></th>
                        <th align="center" class="textotitable">Categoria</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>';
$bgcolor="#ffffff"; $J=1; $T=1000;
$ResCategoria=mysqli_query($conn, "SELECT * FROM secciones WHERE TIpo='C' AND Depende='0' ORDER BY Orden ASC");
$numcat=mysqli_num_rows($ResCategoria); $A=1;
while($RResCategoria=mysqli_fetch_array($ResCategoria))
{
    $cadena.='      <tr style="background: '.$bgcolor.'" id="row_'.$J.'">
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$J.'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';if($J>1){$cadena.='<a href="javascript:void(0)" onclick="nivelc(\''.$RResCategoria["Id"].'\', \'sube\')"><i class="fa-solid fa-caret-up"></i></a>';}$cadena.='</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';if($A<$numcat){$cadena.='<a href="javascript:void(0)" onclick="nivelc(\''.$RResCategoria["Id"].'\', \'baja\')"><i class="fa-solid fa-caret-down"></i></a>';}$cadena.='</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle">'.$RResCategoria["Nombre"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="edit_categoria(\''.$RResCategoria["Id"].'\')"><i class="fa-solid fa-pen"></i></a></td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="dele_categoria(\''.$RResCategoria["Id"].'\')"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>';

    if($bgcolor=="#ffffff"){$bgcolor="#cccccc";}
    elseif($bgcolor=="#cccccc"){$bgcolor="#ffffff";}

    $J++; $A++;
    
    $ResSubCategoria=mysqli_query($conn, "SELECT * FROM secciones WHERE Tipo='C' AND Depende='".$RResCategoria["Id"]."' ORDER BY Orden ASC");
    if(mysqli_num_rows($ResSubCategoria)>0)
    {
        $numsubcat=mysqli_num_rows($ResSubCategoria); $K=1;
        while($RResSC=mysqli_fetch_array($ResSubCategoria))
        {
            $cadena.='<tr style="background: '.$bgcolor.'" id="row_'.$T.'">
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"></td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';if($K>1){$cadena.='<a href="javascript:void(0)" onclick="nivelc(\''.$RResSC["Id"].'\', \'sube\')"><i class="fa-solid fa-caret-up"></i></a>';}$cadena.='</td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">';if($K<$numsubcat){$cadena.='<a href="javascript:void(0)" onclick="nivelc(\''.$RResSC["Id"].'\', \'baja\')"><i class="fa-solid fa-caret-down"></i></a>';}$cadena.='</td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="middle"><i class="fa-solid fa-folder-tree itree"></i> '.$RResSC["Nombre"].'</td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="edit_categoria(\''.$RResSC["Id"].'\')"><i class="fa-solid fa-pen"></i></a></td>
                        <td onmouseover="row_'.$T.'.style.background=\'#badad8\'" onmouseout="row_'.$T.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="dele_categoria(\''.$RResSC["Id"].'\')"><i class="fa-solid fa-trash"></i></a></td>
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
function nivelc(categoria, nivel){
	$.ajax({
				type: 'POST',
				url : 'config/categorias.php',
                data: 'categoria=' + categoria +'&hacer=' + nivel
	}).done (function ( info ){
		$('#conteni2').html(info);
	});
}
//mostrar mensaje despues de los cambios
setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000)
</script>