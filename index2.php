<?php require_once('Connections/db.php'); ?>
<?php require_once('Connections/softPark.php'); ?>

		<?php include('header.php'); ?>
        <?php echo $arrays[] = obteneruserpermission(1);?>
		<div class="jumbotron">
		  <h1 class="display-3"><?php include("includes/sesionUser.php"); ?>! Bienvenido a SoftParkWeb!</h1>
		  <p class="lead">Desde esta pagina, podra gestionar su estacionamiento.</p>
		  <hr class="my-2">
		  <p>Ademas podra generar reportes en tiempo real, que le brindaran informacion oportuna sobre la operatividad.</p>
		  <p class="lead">
			<a class="btn btn-primary btn-lg" href="#" role="button">Ver Reportes</a>
		  </p>
		</div>
        
<?php include("footer.php"); ?>