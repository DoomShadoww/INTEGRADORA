<?php
  require 'config/database.php';
  require 'config/config.php';


  $db = new Database();
  $con = $db->conectar();
  
  $productos = isset($_SESSION['carrito']['producto']) ? $_SESSION['carrito']['producto'] : null;
  
  $lista_carrito = array(); //Creación de arreglo para almancenar N productos
  if($productos != null) //Si carrito no está vacío
  {
        foreach ( $productos as $clave => $cantidad )
        {
            $sql = $con->prepare("SELECT ID, Nombre, Precio, $cantidad AS cantidad FROM producto WHERE ID=? AND Activo=1 ");
            $sql->execute([$clave]);
            $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
        }
  }

?>

<script>
function mostrarFechaHora() {
  var ahora = new Date();
  var fecha = ahora.toLocaleDateString();
  var hora = ahora.toLocaleTimeString();
  document.getElementById("fecha-hora").innerHTML = fecha + " " + hora;
}

window.onload = mostrarFechaHora;
</script>







<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TICKET</title>
  <link rel="shortcut icon" href="img/pago.png">
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="imges/favicon.png" rel="icon">
  <link href="imges/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="boton.css">
  <link rel="stylesheet" href="carga.css">
  

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Template Main CSS File -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/animate.css">
	
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	
	<link rel="stylesheet" href="css/flaticon.css">

  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
 

</head>
<body>
<script>

   window.addEventListener('load', function() {
  var loadingScreen = document.getElementById('loading-screen');
  setTimeout(function() {
        loadingScreen.style.opacity = '0';
        setTimeout(function() {
          loadingScreen.style.display = 'none';
        }, 1000);
      }, 1500);
    });
  </script>
    <div id="loading-screen">
      <div class="loader">
      <img src="img/1.png" alt="Cargando..." style="width:50%">
      </div>
    </div>

  

   
        <section>

        <main id="main">

                <section id="breadcrumbs" class="breadcrumbs">
                <div class="container">
                  <hr>
                  <h1 class="text-center">TICKET DE COMPRA</h1>
                    <h2 class="text-center">DETALLE DE PRODUCTOS</h2>
                    <div id="fecha-hora"><strong></strong></div>

                    <hr>
                    <label for="texto">Cajero(a):</label>
                    <input type="text" id="texto">
                   &nbsp  &nbsp  &nbsp  &nbsp
                    <label for="texto">Cliente:</label>
                    <input type="text" id="texto2">
                    
            &nbsp  &nbsp  &nbsp  &nbsp  &nbsp  &nbsp  &nbsp
                    <button   id="bloquear"class="no-imprimir" onclick="bloquearInput()">ACEPTAR</button>
                    <script>
                      function bloquearInput() {
                        var input = document.getElementById("texto");
                        input.disabled = true;
                        var input = document.getElementById("texto2");
                        input.disabled = true;
                      }
                    </script>
                    <hr>
                </div>
                
               

                </section>

                <div class="container">
                <div class="table-responsive">
                    <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                                <tbody>
                                    <?php
                                        if ($lista_carrito == null){
                                            echo '<tr> <td colspan="5" class="text-center"><b>Lista Vacía </b></td> </tr>';
                                        }
                                        else{
                                            
                                                $total= 0;
                                                foreach ($lista_carrito as $fila)
                                                {
                                                        $_id =       $fila['ID'];
                                                        $nombre =    $fila['Nombre'];
                                                        $precio =    $fila['Precio'];
                                                        $cantidad = $fila['cantidad'];
                                                        $subtotal = $precio * $cantidad;
                                                        $total = $total + $subtotal;
                                                ?>

                                                <tr>
                                                    <td>  <?php echo $nombre; ?> </td>
                                                    <td> $<?php echo number_format($precio,2,'.',','); ?> </td>
                                                    <td> 
                                                        <?php echo $cantidad; ?>     
                                                    </td>
                                                    <td> 
                                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                                            $<?php echo  number_format($subtotal,2,'.',','); ?>
                                                        </div>
                                                    </td> 
                                                                                          
                                                </tr>

                                    <?php
                                                }                                
                                    ?>  
                                
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td colspan="2">
                                                        <p class="h3" id="total">
                                                            TOTAL $<?php echo number_format($total,2,'.',','); ?>
                                                        </p>
                                                    </td>
                                                </tr>
                            </tbody>

                                <?php
                                        }                                
                                    ?> 
                            </thead>
                    </table>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 offset-md-6 d-grid gap-2">
                            <button id="boton-imprimir" class="no-imprimir">IMPRIMIR RECIBO</button>
                            <script>
                            document.getElementById("boton-imprimir").addEventListener("click", function() {
                              window.print();
                            });
                            </script>
                                                
                            <form action="destroy_session.php" method="post">
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            
                            <input type="submit" name="destroy_session" value="NUEVA TRANSACCION" class="no-imprimir">
                           
                            </form>
                           
                              
                    </div>
                </div>                     

                </div>

        </main>

            
        </section>



  <!-- Modal para Eliminar -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eliminaModalLabel">Advertencia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Desea Eliminar el Producto del Carrito?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal"> Cancelar </button>
        <button id="btn-elimina" type="button" class="btn btn-outline-danger" onclick="eliminar()"> Eliminar </button>
      </div>
    </div>
  </div>
</div>


  <!-- ======= Footer ======= -->
 

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="js/main.js"></script>

  <script>


    let eliminaModal = document.getElementById('eliminaModal');
    eliminaModal.addEventListener('show.bs.modal', function(event){
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');
        let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina');
        buttonElimina.value = id;
    })
    
    function actualizarCantidad(cantidad, id)
    {
        let url = 'actualizar.php';
        let formData = new FormData();
        formData.append('action', 'agregar');
        formData.append('ID', id);
        formData.append('cantidad', cantidad);

        fetch(url, {
          method: 'POST',
          body: formData,
          mode: 'cors'
        }).then(response => response.json())
        .then(data => {
          if(data.ok){

              let divsubtotal = document.getElementById('subtotal_' + id);
              divsubtotal.innerHTML = data.sub;

              let total = 0.00;
              let list = document.getElementsByName('subtotal[]');

              for (let i=0; i<list.length; i++)
              {
                  total = total + parseFloat(list[i].innerHTML.replace(/[$,]/g, ''));
              }

              total = new Intl.NumberFormat('en-US',{
                minimumFractionDigits: 2
              }).format(total);

              document.getElementById('total').innerHTML = '$' + total;

          }
        })
    }


    function eliminar()
    {
        let botonElimina = document.getElementById ('btn-elimina');
        let id = botonElimina.value;

        let url = 'actualizar.php';
        let formData = new FormData();
        formData.append('action', 'eliminar');
        formData.append('ID', id);
 
        fetch(url, {
          method: 'POST',
          body: formData,
          mode: 'cors'
        }).then(response => response.json())
        .then(data => {
          if(data.ok)
          {
              location.reload();
          }
        })
    }

  

  </script>
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>