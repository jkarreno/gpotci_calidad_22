<?php
include('../conexion.php');

$ResSeccion=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$_POST["seccion"]."' LIMIT 1"));

if($ResSeccion["Depende"]!=0)
{
    $ResSecSup=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$ResSeccion["Depende"]."' LIMIT 1"));

    $superior=$ResSecSup["Nombre"].' / ';
}

$mesaje='';

if(isset($_POST["hacer"]))
{
    //agregar archivo
    if($_POST["hacer"]=='adfile')
    {
        //carga el archivo
        if($_FILES['filer']!='')
        {
            $nombre_archivo_r =$_FILES['filer']['name']; 

            $ext_r=explode('.', $nombre_archivo_r);

            if (is_uploaded_file($_FILES['filer']['tmp_name']))
            { 
                if(copy($_FILES['filer']['tmp_name'], '../files/'.$_POST["seccion"].'/'.$nombre_archivo_r))
                {
                    $copyfile=1;
                }
                else
                {
                    $copyfile=2;
                    $error=', no se pudo cargar el archivo '.$nombre_archivo_r;
                }
            }
            else
            {
                $copyfile=3;
                $error=', no se pudo cargar el archivo '.$nombre_archivo_r;
            }
        }
        else
        {
            $nombre_archivo_r = ''; 
            $ext_r='';
        }
        
        mysqli_query($conn, "INSERT INTO Archivos (Seccion, Codigo, SubCodigo, Nombre, Subtitulo, Url_d, Archivo_r, Extension_r, FechaUpdate)
                                            VALUES ('".$_POST["seccion"]."', '".$_POST["codigo"]."', '".$_POST["subcodigo"]."', 
                                                    '".$_POST["titulo"]."', '".$_POST["subtitulo"]."', '".$_POST["dirdocumento"]."', 
                                                    '".$nombre_archivo_r."', '".$ext_r[1]."', '".date("Y-m-d")."')") or die(mysqli_error($conn));

        $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego '.$_POST["titulo"].' satisfactoriamente'.$error.'</div>';
        
    }
    //editar archivo
    if($_POST["hacer"]=='editfile')
    {
        //carga el archivo
        if(isset($_FILES['filer']) AND $_FILES['filer']!=NULL)
        {
            $nombre_archivo_r =$_FILES['filer']['name']; 

            $ext_r=explode('.', $nombre_archivo_r);

            if (is_uploaded_file($_FILES['filer']['tmp_name']))
            { 
                if(copy($_FILES['filer']['tmp_name'], '../files/'.$_POST["seccion"].'/'.$nombre_archivo_r))
                {
                    $copyfile=1;
                }
                else
                {
                    $copyfile=2;
                    $error=', no se pudo cargar el archivo '.$nombre_archivo_r;
                }
            }
            else
            {
                $copyfile=3;
                $error=', no se pudo cargar el archivo '.$nombre_archivo_r;
            }
        }
        else
        {
            $nombre_archivo_r = ''; 
            $ext_r='';
        }
        
        mysqli_query($conn, "UPDATE Archivos SET Codigo='".$_POST["codigo"]."', 
                                                    SubCodigo='".$_POST["subcodigo"]."', 
                                                    Nombre='".$_POST["titulo"]."', 
                                                    Subtitulo='".$_POST["subtitulo"]."', 
                                                    Url_d='".$_POST["dirdocumento"]."', 
                                                    Archivo_r='".$nombre_archivo_r."', 
                                                    Extension_r='".$ext_r[1]."', 
                                                    FechaUpdate='".date("Y-m-d")."'
                                            WHERE Id='".$_POST["idfile"]."'") or die(mysqli_error($conn));

        $mensaje='<div class="mesaje" ><i class="fas fa-thumbs-up"></i> Se actualizo '.$_POST["titulo"].' satisfactoriamente.'.$error.'</div>';
        
    }
}

$cadena=$mensaje.'<div class="c100" style="display: flex; flex-wrap:wrap;">
            <h2>'.$superior.$ResSeccion["Nombre"].'</h2>
        </div>
        <div class="c100" style="display: flex; flex-wrap: wrap;">
            <table>
                <thead>
                    <tr>
                        <td colspan="7" align="right">| <a href="javascript:void(0)" onclick="limpiar(); abrirmodal(); addfile(\''.$ResSeccion["Id"].'\')">Agregar Archivo</a> |</td>
                    </tr>
                    <tr>
                        <th align="center" class="textotitable">#</th>
                        <th align="center" class="textotitable">Código</th>
                        <th align="center" class="textotitable">Documento</th>
                        <th align="center" class="textotitable">Url documento</th>
                        <th align="center" class="textotitable">Archivo</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                        <th align="center" class="textotitable">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>';
$ResFiles=mysqli_query($conn, "SELECT * FROM Archivos WHERE Seccion='".$_POST["seccion"]."' ORDER BY Codigo ASC");
$bgcolor="#ffffff"; $J=1;
while($RResFiles=mysqli_fetch_array($ResFiles))
{
    $cadena.='      <tr style="background: '.$bgcolor.'" id="row_'.$J.'">
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$J.'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$RResFiles["Codigo"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$RResFiles["Nombre"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$RResFiles["Url_d"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$RResFiles["Archivo_r"].'</td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)" onclick="limpiar(); abrirmodal(); edit_file(\''.$RResFiles["Id"].'\')"><i class="fa-solid fa-pen"></i></a></td>
                        <td onmouseover="row_'.$J.'.style.background=\'#badad8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle"><a href="javascript:void(0)"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>';

    if($bgcolor=="#ffffff"){$bgcolor="#cccccc";}
    elseif($bgcolor=="#cccccc"){$bgcolor="#ffffff";}
                
    $J++;
}
$cadena.='    </tbody>
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