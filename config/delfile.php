<?php
include("../conexion.php");

$ResFile=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM Archivos WHERE Id='".$_POST["file"]."' LIMIT 1"));

if($_POST["accion"]=='NO')
{
    $cadena=$ResFile["Archivo_r"].' <a href="#" onclick="del_file(\''.$ResFile["Id"].'\')"><i class="fa-solid fa-trash" style="font-size: 16px;"></i></a>';
}
elseif($_POST["accion"]=='SI')
{
    $cadena='<label class="l_form">Se elimino el archivo <span style="color:#0099ff;">'.$ResFile["Archivo_r"].'</span> satisfactoriamente</label>
            <label class="l_form">Registro: </label>
            <div style="">
                <div class="file-input-container">
                    <input type="file" class="sm-input-file" id="sm-ip-1" name="filer"/>
                    <label class="for-sm-input-file" for="sm-ip-1">Agregar Archivo</label>
                    <span class="span-text" id="file-name"></span>
                </div>
            </div>';

    unlink('../files/'.$ResFile["Seccion"].'/'.$ResFile["Archivo_r"]);

    mysqli_query($conn, "UPDATE Archivos SET Archivo_r='', Extension_r='' WHERE Id='".$ResFile["Id"]."'");
}
else
{
    $cadena='<label class="l_form">Se eliminara el archivo <span style="color:#0099ff;">'.$ResFile["Archivo_r"].'</span>?</label>
        <label class="l_form"><a href="#" onclick="del_file(\''.$ResFile["Id"].'\', \'SI\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="del_file(\''.$ResFile["Id"].'\', \'NO\')">No</a></label>';
}

echo $cadena;