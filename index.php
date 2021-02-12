<?php
session_start();
require_once './BD/connecta_db_persistent.php';
if (isset($_SESSION["usuario"])) {
    header("Location: ./pages/home.php");
} else {
	if(isset($_POST['mailreset']))
	{
		$sql = 'SELECT  mail FROM `users` WHERE mail = :mail';
        $preparada = $db->prepare($sql);
        $preparada->execute(array(':mail' => $_POST['mailreset']));
		$result = $preparada->fetch(PDO::FETCH_ASSOC);

			if($result !=false)
			{
					////////////////////////////////////////////
					$code = hash("sha256",rand());
					$mailreset = $_POST['mailreset'];
					$link = "http://localhost/php/Practica_Instagram/pages/resetPassword.php?code=".$code."&mail=".$mailreset;
					$fecha = date('Y-m-d H:i:s');;
					$nuevafecha = strtotime ( '+10 minute' , strtotime ( $fecha ) ) ;
					$nuevafecha = date ( 'Y-m-d H:i:s' , $nuevafecha );
					$sql = 'UPDATE users SET resetPass=1, resetPassExpiry=:fecha, resetPassCode=:code WHERE mail=:mail';
					$preparada = $db->prepare($sql);
					$preparada->execute(array(':mail' => $mailreset,
												':fecha'=> $nuevafecha,
												':code' => $code));
					echo'tu cuenta ha sido verificada';
				


					require_once'./pages/sendMailRESET.php';
					//header("Location: ../index.php");
					echo'Registro correcto';



			}
			else
			{
				echo'No existe una cuenta con ese mail';
			}
	}
    else if (isset($_POST['nombre']) && isset($_POST['pass'])) {

        $sql = 'SELECT passHash, userFirstName,username FROM `users` WHERE username = :nombre';
        $preparada = $db->prepare($sql);
        $preparada->execute(array(':nombre' => $_POST['nombre']));
		$result = $preparada->fetch(PDO::FETCH_ASSOC);

		$sql2 = 'SELECT passHash, userFirstName,mail FROM `users` WHERE mail = :mail';
        $preparada2 = $db->prepare($sql2);
        $preparada2->execute(array(':mail' => $_POST['nombre']));
		$result2 = $preparada2->fetch(PDO::FETCH_ASSOC);
		if($result !=false)
		{

			comprobarcontraseña($result["passHash"],1,$result["userFirstName"],$result["username"],$db);
		}
		else if($result2 !=false)
		{

			comprobarcontraseña($result2["passHash"],2,$result2["userFirstName"],$result2["mail"],$db);
		}
		else echo'login incorrecto';

    }
}

function comprobarcontraseña($pass,$consulta,$nombre,$updateN,$db){

	
	if(password_verify($_POST['pass'],$pass))
	{
		if($consulta == 1)
		{
			$_SESSION["usuario"] = $nombre;

			$sql2 = 'UPDATE users SET lastSignIn=sysdate() WHERE username=:Uname';
		}
		if($consulta == 2)
		{
			$_SESSION["usuario"] =  $nombre;
			$sql2 = 'UPDATE users SET lastSignIn=sysdate() WHERE mail=:Uname';
		}
		
		$preparada2 = $db->prepare($sql2);
		$preparada2->execute(array(':Uname' => $updateN));
		header("Location: ./pages/home.php");
	}else echo'login incorrecto';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>ImagiNest Inicio de sesión</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/logo3.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body >

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" name="login" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="POST">
					<span class="login100-form-logo">
						<img src="./images/logo.png" width="250px">
					</span>
					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="nombre" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="btn btn-primary">
							Login
						</button>
						<br>

					</div>
					<div class="container-login100-form-btn separartop">
					<div class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#centralModalLg">Reset password</div>
					</div>
						<a class="txt1 btSgn" href="./pages/sigin.php">
							Don’t have account yet? Sign Up
						</a>
				</form>
				
			</div>
			
		</div>
<!-- Central Modal Large -->
<div class="modal fade" id="centralModalLg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-mg" role="document">
        <!--Content-->
        <div class="modal-content">
			          <!--Header-->
					  <div class="modal-header">
            <h4 class="modal-title w-100" id="myModalLabel">Reset password</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!--Body-->
          
		  <form name="reset" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="POST">
		  <div class="wrap-input100 validate-input" >
						<input  type="text" name="mailreset" placeholder="Introduce tu mail:">
					</div>

		 
		 
		  <!--Footer-->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button class="btn btn-primary">
							Resetear
						</button>
				</div>




				</form>
          </div>
        <!--/.Content-->
      </div>
    </div>
    <!-- Central Modal Large -->

	</div>


	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>