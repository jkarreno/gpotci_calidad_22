<?php
include('../conexion.php');

$ResSeccion=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$_POST["seccion"]."' LIMIT 1"));

$mesaje='';

if(isset($_POST["hacer"]))
{
    //agregar archivo
    if(isset($_POST["hacer"])=='adfile')
    {
        //carga el archivo
        if($_FILES['filer']!='')
        {
            $nombre_archivo_r =$_FILES['filer']['name']; 

            if (is_uploaded_file($_FILES['filer']['tmp_name']))
            { 
                if(copy($_FILES['filer']['tmp_name'], '../files/'.$_POST["seccion"].'/'.$nombre_archivo_r))
                {
                    $copyfile=1;
                }
                else
                {
                    $copyfile=2;
                }
            }
            else
            {
                $copyfile=3;
            }
        }
        if($copyfile==1)
        {
            mysqli_query($conn, "INSERT INTO Archivos (Seccion, Codigo, SubCodigo, Nombre, Subtitulo, Url_d, Archivo_r, Extension_r)
                                                VALUES ('".$_POST["seccion"]."', '".$_POST["codigo"]."', '".$_POST["subcodigo"]."', 
                                                        '".$_POST["titulo"]."', '".$_POST["subtitulo"]."', '".$_POST["dirdocumento"]."', 
                                                        '".$nombre_archivo_r."', 'doc')") or die(mysqli_error($conn));

            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-thumbs-up"></i> Se agrego el archivo '.$_POST["titulo"].' satisfactoriamente</div>';
        }
        else
        {
            $mensaje='<div class="mesaje" id="mesaje"><i class="fas fa-exclamation-triangle"></i> Ocurrio un error, no se pudo cargar el archivo, intente nuevamente</div>'; 
        }
    }
}

$cadena=$mensaje.'<div class="c100" style="display: flex; flex-wrap:wrap;">
            <h2>'.$ResSeccion["Nombre"].'</h2>
        </div>
        <div class="c100" style="display: flex; flex-wrap: wrap;">
            <table>
                <thead>
                    <tr>
                        <td colspan="5" align="right">| <a href="javascript:void(0)" onclick="limpiar(); abrirmodal(); addfile(\''.$ResSeccion["Id"].'\')">Agregar Archivo</a> |</td>
                    </tr>
                    <tr>
                        <th align="center" class="textotitable">#</th>
                        <th align="center" class="textotitable">Código</th>
                        <th align="center" class="textotitable">Documento</th>
                        <th align="center" class="textotitable"></th>
                        <th align="center" class="textotitable"></th>
                    </tr>
                </thead>
            </table>
        </div>';

echo $cadena;