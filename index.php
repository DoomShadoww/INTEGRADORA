<?php
require 'config/database.php';
require 'config/config.php';




$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT ID, Nombre, Precio FROM producto WHERE Activo= 1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manjares del Rey </title>
    <link rel="shortcut icon" href="img/1.png">
    
    <script src="cargador.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="botones.css">
    <link rel="stylesheet" href="carga.css">
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
    
    
    <div>
        <div class="text-center difuminar">
          <img src="img/logo.jpg" class="rounded" alt="LOGO" style="width:95%">
        </div>

</div> 
    
   
  
    <h1 class="text-center text-light titulo"><strong>LISTA DE PRODUCTOS</strong> </h1>
    <br>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-md-11">
            <a href="prepago.php" class="btn btn-light btn-lg" id="sticky">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
</svg> &nbsp <span id="num_cart" class="badge bg-info"><?php echo $num_cart;?></span>  
                        </a>
                        <form action="destroy_session.php" method="post">
                        <input type="submit" name="destroy_session" value="NUEVA TRANSACCION" class="btn btn-lg btn-danger fs-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="red" class="bi bi-node-plus" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M11 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM6.025 7.5a5 5 0 1 1 0 1H4A1.5 1.5 0 0 1 2.5 10h-1A1.5 1.5 0 0 1 0 8.5v-1A1.5 1.5 0 0 1 1.5 6h1A1.5 1.5 0 0 1 4 7.5h2.025zM11 5a.5.5 0 0 1 .5.5v2h2a.5.5 0 0 1 0 1h-2v2a.5.5 0 0 1-1 0v-2h-2a.5.5 0 0 1 0-1h2v-2A.5.5 0 0 1 11 5zM1.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
                        </svg>
                        </form>
                        <hr>
                        
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col" id="cols" class="fs-2">ID</th>
                        <th scope="col" class="fs-2">NOMBRE</th>
                        <th scope="col" class="fs-2">PRECIO</th>
                        <th scope="col" class="fs-2">AÑADIR</th>
                      </tr>
                    </thead>

                </table>
            <?php foreach($resultado as $row) { ?>
                <?php
				    $id = $row['ID'];
				?>
                <table class="table">
                   
                    <tbody>
                      <tr>
                        
                      <th scope="row" id="cols" class="fs-3"><?php echo $row['ID']; ?></th>
                        <?php
                          $id = $row['ID'];
                          $imagen = "img/". $id ."/pan.png";

                         

                        ?>
							
                        <td  class="fs-5"> <strong><?php echo $row['Nombre']; ?> </strong> <img id="panes" src="<?php echo $imagen ?>" class="w-50"></td>
                        <td class="fs-1"><strong><?php echo number_format($row['Precio'],2,'.',',') ?></strong> <span>MXN</span></td>
                        <td class="addPerro"><a class="btn btn-outline-info btn-lg" type="button" onclick="addProducto( <?php echo $row['ID']; ?>, '<?php echo hash_hmac('sha1', $row['ID'], KEY_TOKEN); ?>' )"> <svg  xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
</svg></a></td>
                      </tr>
                     
                       
                      </tr>
                    </tbody>
                  </table>
                  <?php } ?>
            </div>
        </div>
        <div class="row">
				<div class="col-md-12 text-center">
					
					<p class="text-light fs-3">
						 | Copyright &copy;<script>document.write(new Date().getFullYear());</script>Todos los derechos reservados |</a>
						</p>
					</div>
				</div>
    </div>
   

    <script>
		
		function addProducto(id, token){
			let url = 'carrito.php';
			let formData = new FormData();
			formData.append('ID', id);
			formData.append('token', token);

			fetch(url, {
				method: 'POST',
				body: formData,
				mode: 'cors'
			}).then(response => response.json())
			.then(data => {
				if(data.ok){
				let elemento = document.getElementById("num_cart");
				elemento.innerHTML = data.numero;
				}
			})
		}

        window.onscroll = function() {
            myFunction()
            };

            function myFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("myButton").style.display = "block";
            } else {
                document.getElementById("myButton").style.display = "none";
            }
            }

       

		</script>
</body>
</html>



