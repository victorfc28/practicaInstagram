<?php
session_start();
require_once './BD/connecta_db_persistent.php';
if (isset($_SESSION["usuario"])) {
    header("Location: ./pages/home.php");
} else {
    if (isset($_POST['nombre']) && isset($_POST['pass'])) {

        $sql = 'SELECT passHash, userFirstName FROM `users` WHERE username = :nombre';
        $preparada = $db->prepare($sql);
        $preparada->execute(array(':nombre' => $_POST['nombre']));
		$result = $preparada->fetch(PDO::FETCH_ASSOC);

		$sql2 = 'SELECT passHash, userFirstName FROM `users` WHERE mail = :mail';
        $preparada2 = $db->prepare($sql2);
        $preparada2->execute(array(':mail' => $_POST['nombre']));
		$result2 = $preparada2->fetch(PDO::FETCH_ASSOC);
		if($result !=false)
		{

			comprobarcontraseña($result["passHash"],1,$result["userFirstName"]);
		}
		else if($result2 !=false)
		{

			comprobarcontraseña($result2["passHash"],2,$result2["userFirstName"]);
		}
		else echo'login incorrecto';

    }
}

function comprobarcontraseña($pass,$consulta,$nombre){

	
	if(password_verify($_POST['pass'],$pass))
	{
		if($consulta == 1)$_SESSION["usuario"] = $nombre;
		if($consulta == 2)$_SESSION["usuario"] =  $nombre;
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

					<span class="login100-form-title p-b-34 p-t-27">
						Log in
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
						<button class="login100-form-btn">
							Login
						</button>
					</div>
						<a class="txt1 btSgn" href="./pages/sigin.php">
							Don’t have account yet? Sign Up
						</a>

				</form>
			</div>
		</div>
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