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





<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>DETALLE DE COMPRA</title>
  <link rel="shortcut icon" href="img/carro.png">
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="imges/favicon.png" rel="icon">
  <link href="imges/apple-touch-icon.png" rel="apple-touch-icon">

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
  <link rel="stylesheet" href="carga.css">

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
  

    
      <section class="hero-wrap hero-wrap-2 degree-right" style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="0.5">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row no-gutters slider-text js-fullheight align-items-end">
                    <div class="col-md-9 ftco-animate pb-5 mb-5">
                      <hr>
                    <h5 class="breadcrumbs"><span class="mr-2"><a href="index.php">PRODUCTOS <i class="fa fa-chevron-right"></i></a></span> <span>DETALLE DE COMPRA</span></h5>
                    <hr>
                    <h1 class="mb-3 bread">DETALLE DE COMPRA</h1>
                    </div>
                </div>
                </div>
    </section>

     

    </div>
    <br>
    <br>
  


   
        <section>

        <main id="main">

                <section id="breadcrumbs" class="breadcrumbs">
                <div class="container">
                    <h2>Productos</h2>

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
                                                        <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad; ?>" size="5" id=cantidad_<?php echo $_id; ?> onchange="actualizarCantidad( this.value, <?php echo $_id; ?> )" >    
                                                    </td>
                                                    <td> 
                                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                                            $<?php echo number_format($subtotal,2,'.',','); ?>
                                                        </div>
                                                    </td> 
                                                    <td>
                                                        <a href="#" id="eliminar" class="btn btn-outline-danger btn-sm" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal"> Eliminar </a>
                                                    </td>                                       
                                                </tr>

                                    <?php
                                                }                                
                                    ?>  
                                
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td colspan="2">
                                                        <p class="h3" id="total">
                                                            $<?php echo number_format($total,2,'.',','); ?>
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
                            <a type="button" href="ticket.php"  class="btn btn-outline-info btn-lg"> REALIZAR PAGO &nbsp<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-wallet" viewBox="0 0 16 16">
                            <path d="M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5V3zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a1.99 1.99 0 0 1-1-.268zM1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1z"/>
                          </svg> </a>
                            <form action="destroy_session.php" method="post">
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            
                            <input type="submit" name="destroy_session" value="CANCELAR PAGO" class=" btn btn-outline-danger btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-x-octagon" viewBox="0 0 16 16">
                              <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
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