<?php
session_start();
require_once("../../conexion.php");
require_once("../../libreria_menu.php");
$db->debug = true; // Descomenta esto para depuración si es necesario

echo "<html>
       <head>
         <link rel='stylesheet' href='../../css/estilos.css' type='text/css'>
       </head>
       <body>
       <p> &nbsp;</p>";

$sql = $db->Prepare("SELECT CONCAT_WS (' ', t.tipo_servicio, t.fec_creacion) AS servicio, s.*
                     FROM sindicatos s,tipos_servicios t
                     WHERE s.tipo_servicio_id = t.id
                     ORDER BY s.id DESC
                     ");

$rs = $db->GetAll($sql);

if ($rs) {
    echo "<center>
            <h1>LISTADO DE SINDICATOS</h1>
            <b><a href='sindicato_nuevo.php'>Nuevo Sindicato >>>></a></b>
            <table class='listado'>
              <tr>                                   
                <th>Nro</th><th>TIPO DE SERVICIO</th><th>NOMBRES</th><th>TELEFONO</th>
                <th>DIRECCION</th>
                <th><img src='../../imagenes/modificar.gif' alt='Modificar'></th><th><img src='../../imagenes/borrar.jpeg' alt='Eliminar'></th>
              </tr>";
    $b = 1;
    foreach ($rs as $fila) {                                       
        echo "<tr>
                <td align='center'>".$b."</td>
                <td>".$fila['servicio']."</td>
                <td>".$fila['nombres']."</td>                        
                <td>".$fila['telefono']."</td>
                <td>".$fila['direccion']."</td>
                <td align='center'>
                  <form name='formModif".$fila["id"]."' method='post' action='sindicato_modificar.php'>
                    <input type='hidden' name='id' value='".$fila['id']."'>
                    <a href='javascript:document.formModif".$fila['id'].".submit();' title='Modificar Sindicato'>
                      Modificar >>
                    </a>
                  </form>
                </td>
                <td align='center'>  
                  <form name='formElimi".$fila["id"]."' method='post' action='sindicato_eliminar.php'>
                    <input type='hidden' name='id' value='".$fila["id"]."'>
                    <a href='javascript:document.formElimi".$fila['id'].".submit();' title='Eliminar Sindicato' onclick='return confirm(\"¿Desea realmente eliminar el sindicato ".$fila['nombres']."?\")'> 
                      Eliminar >>
                    </a>
                  </form>                        
                </td>
             </tr>";
        $b++;
    }
    echo "</table>
         </center>";
} else {
    echo "<center><h2>No se encontraron sindicatos</h2></center>";
}

echo "</body>
      </html>";
?>
