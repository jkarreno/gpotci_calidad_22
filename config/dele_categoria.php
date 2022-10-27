<?php
include("../conexion.php");

$ResCategoria=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM secciones WHERE Id='".$_POST["categoria"]."' AND Tipo='C' LIMIT 1"));

$cadena='<div class="c100">
            <table>
                <thead>
                    <tr>
                        <th>Borrar Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form"><i class="fa-solid fa-triangle-exclamation" style="color: #efec25"></i> ¿Esta seguro de borrar la categoria: <span class="palabra">'.$ResCategoria["Nombre"].'</span> ?</label>
                                <label class="l_form">(Se perderan todos los archivos y documentos relacionados a esta categoria)</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="c100">
                                <label class="l_form" style="text-align: center"><a hreF="#" class="botona" onclick="del_cat(\''.$ResCategoria["Id"].'\')">Si</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:voic(0)" class="botona" onclick="categorias()">No</a></label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            </form>
        </div>';

echo $cadena;