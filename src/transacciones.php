<?php
    include('conexion_bd.php');

    $verTrans = $con->real_escape_string($_POST['verTrans']);

    $sql = "SELECT COUNT(t.Folio) AS CANTIDAD, t.Date, SUM(t.Amount) AS TOTAL, t.User_User_Name, t.Stocktaking_ID, s.ID, s.Product_Name AS APN, s.Class FROM transaction AS t INNER JOIN stocktaking AS s ON t.Stocktaking_ID = s.ID WHERE s.Product_Name LIKE '%".$verTrans."%' OR s.Class LIKE '%".$verTrans."%'";
    $resultado = $con->query($sql);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = $resultado->fetch_assoc()) {                  
            echo "
                <thead class='thead-light'>
                    <tr>
                        <th scope='col'>Cantidad</th>
                        <th scope='col'>Fecha</th>
                        <th scope='col'>Cliente</th>
                        <th scope='col'>Producto</th>
                        <th scope='col'>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>".$fila['CANTIDAD']."</td>
                        <td>".$fila['Date']."</td>
                        <td>".$fila['User_User_Name']."</td>
                        <td>".$fila['APN']."</td>
                        <td class='text-success'> $ ".$fila['TOTAL'].".00</td>
                    </tr>
                </tbody>
            ";
        }
    }
?>
<script>
    //tabla inventario
    $(document).ready(function(){
        $('#editable_table').Tabledit({
        url: 'actualizarStock.php',
        columns: {
            identifier:[0, 'ID'],
            editable:[[2, 'Lot']]
        },
        editButton: false,
        deleteButton: false,
        hideIdentifier: true,
        restoreButton: false,
        onSuccess:function(data, textStatus, jqXHR) {
            if(data.action == 'delete') {
                $('#'+data.ID).remove();
            }
        }
        });
    });
    //tabla inventario
</script>