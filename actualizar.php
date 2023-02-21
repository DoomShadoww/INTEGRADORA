<?php

        require 'config/config.php';
        require 'config/database.php';
        
        if(isset($_POST['action']))
        {
                $action = $_POST['action'];
                $id = isset($_POST['ID']) ? $_POST['ID'] : 0;

                if ($action == 'agregar')
                {
                    $cantidad = isset ($_POST['cantidad']) ? $_POST['cantidad'] : 0;
                    $respuesta = agregar($id, $cantidad);
                    if ($respuesta > 0)
                    {
                        $datos['ok'] = true;
                    }
                    else
                    {
                        $datos['ok'] = false;
                    }

                    $datos['sub'] = '$'.number_format($respuesta, 2, '.',',');
                } 
                else if ($action=='eliminar')
                    {
                        $datos['ok'] = eliminar($id);
                    }
                else
                {
                    $datos['ok'] = false;
                }
        }
        else
        {
            $datos['ok'] = false;
        }

        echo json_encode($datos);

        function agregar($id, $cantidad){
            $res = 0;
            if ($id > 0 && $cantidad > 0 && is_numeric(($cantidad)))
            {
                if(isset($_SESSION['carrito']['producto'][$id])){
                    $_SESSION['carrito']['producto'][$id] = $cantidad;

                    $db = new Database();
                    $con = $db->conectar();
                    $sql = $con->prepare("SELECT Precio FROM producto WHERE ID=? AND Activo=1");
                    $sql->execute([$id]);

                    $row = $sql->fetch(PDO::FETCH_ASSOC);

                    $precio = $row['Precio'];
                    $res = $cantidad * $precio;

                    return $res;
                }
            }
            else
            {
                return $res;
            }
        }

        function eliminar($id)
        {
            if ($id>0)
            {
                if(isset($_SESSION['carrito']['producto'][$id]))
                {
                    unset($_SESSION['carrito']['producto'][$id]);
                    return true;
                }
            }
            else
            {
                return false;
            }
        }

?>