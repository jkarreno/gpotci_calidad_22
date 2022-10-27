<?php
include("../conexion.php");

$ResProceso=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$_POST["proceso"]."' AND Tipo='P' LIMIT 1"));

$cadena='<div class="c100">
            <table>
                <thead>
                    <tr>
                        <th>Borrar Proceso</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form"><i class="fa-solid fa-triangle-exclamation" style="color: #efec25"></i> ¿Esta seguro de borrar el proceso: <span class="palabra">'.$ResProceso["Nombre"].'</span> ?</label>
                                <label class="l_form">(Se perderan todos los archivos y documentos relacionados a este proceso)</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form" style="text-align: center"><a hreF="#" class="botona" onclick="del_pro(\''.$ResProceso["Id"].'\')">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:voic(0)" class="botona" onclick="procesos()">No</a></label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            </form>
        </div>';

echo $cadena;
?>
