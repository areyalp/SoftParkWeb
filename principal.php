<?php require_once('Connections/softPark.php'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SoftPark - Principal</title>
<link rel="stylesheet" type="text/css" href="styles/base.css"/>
</head>

<body>
	<div id="container">
  		
        <header>
        	<h1>SoftPark</h1>
            <div id="user">
            	<?php 
				if((isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username'] !=""))
                {
                	echo Obtenernameuser($_SESSION['MM_Idusuario']);
                }?>
            </div>
    	</header><!-- end header -->
        
        <section>
  			<div id="content">
            	<div class="content">
            		<div class="title">
                		<h2>Administracion</h2>
                	</div><!-- end title -->
                    <div class="options">
                    	<a href="usertypeList.php"><img src="images/advantagediagram.png"></a>
                	</div>
                    <div class="options">
                    	<a href=""><img src="images/advantagediagram.png"></a>
                	</div>
                    <div class="options">
                    	<a href=""><img src="images/advantagediagram.png"></a>
                	</div>
                    <div class="options">
                    	<a href=""><img src="images/advantagediagram.png"></a>
                	</div>
                    <div class="options">
                    	<a href=""><img src="images/advantagediagram.png"></a>
                	</div>
                    <div class="options">
                    	<a href=""><img src="images/advantagediagram.png"></a>
                	</div>
                </div>
                
                <div class="content">
                	<div class="title">
                		<h2>Configuracion</h2>
                	</div><!-- end title -->
                	<div class="options">
                    	<img src="images/tools.png">
                	</div>
                	<div class="options">
                    	<img src="images/tools.png">
                	</div>
                	<div class="options">
                    	<img src="images/tools.png">
                	</div>
                    <div class="options">
                    	<img src="images/tools.png">
                	</div>
                	<div class="options">
                    	<img src="images/tools.png">
                	</div>
                	<div class="options">
                    	<img src="images/tools.png">
                	</div>
                  </div>
                  
                 <div class="content">
                	<div class="title">
                		<h2>Miscelaneos</h2>
                	</div><!-- end title -->
                	<div class="options">
                    	<img src="images/new_ticket.png">
                	</div>
                	<div class="options">
                    	<img src="images/new_ticket.png">
                	</div>
                	<div class="options">
                    	<img src="images/new_ticket.png">
                	</div>
                    <div class="options">
                    	<img src="images/new_ticket.png">
                	</div>
                	<div class="options">
                    	<img src="images/new_ticket.png">
                	</div>
                	<div class="options">
                    	<img src="images/new_ticket.png">
                	</div>
                 </div>
    		</div><!-- end content -->
        </section><!-- end section -->
        
  		<footer>
    		<?php include("includes/footer.php"); ?>
    	</footer><!-- end footer -->
        
  </div><!-- end .container -->
  
</body>
</html>