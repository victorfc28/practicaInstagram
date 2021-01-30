<?php
session_start();
require_once '../BD/connecta_db_persistent.php';
if (isset($_SESSION["usuario"])) {
    header("Location: ./mainPage.php");
} else {
    if (isset($_POST['nombre'])) {
		if (isset($_POST['nombre']) && isset($_POST['pass'])) {

			$sql = 'SELECT username FROM `users` WHERE username = :nombre';
			$preparada = $db->prepare($sql);
			$preparada->execute(array(':nombre' => $_POST['nombre']));
			$result = $preparada->fetch(PDO::FETCH_ASSOC);
			if($result !=false)
			{
				echo'Este Usuario ya existe';
			}
			else
			{
				if($_POST['pass'] == $_POST['vpass'])
				{
		
					$sql = 'INSERT INTO users (mail,username,passhash,userFirstName,userLastName,creationDate,lastSignIn,removeDate,activado) VALUES (:mail,:nombre,:passhash,:Fname,:Lname,:creationDate,:LastSignIn,:RemoveDate,:Activado)';
					$preparada = $db->prepare($sql);
					$preparada->execute(array(':mail' => $_POST['mail'],
											':nombre' => $_POST['nombre'],
											':passhash' => password_hash($_POST['pass'],PASSWORD_DEFAULT),
											':Fname' => $_POST['fname'],
											':Lname' => $_POST['sName'],
											':creationDate' => date('d-m-Y H:i'),
											':LastSignIn' => null,
											':RemoveDate' => null,
											':Activado' => 1));
					if($preparada !=false)
					{
						echo'Registro correcto';
					}			
				}
				else
				{
					echo'Las contraseñas no coinciden.';
				}
			}




    }
}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>ImagiNest Registro de usuario</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="../images/logo3.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../css/util.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" name="login" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="POST">
					<span class="login100-form-logo">
						<img src="../images/logo.png" width="250px">
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Registro de usuario
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="nombre" placeholder="Username">
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Enter mail">
						<input class="input100" type="text" name="mail" placeholder="Mail">
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Enter First Name">
						<input class="input100" type="text" name="fname" placeholder="First Name">
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Enter Second Name">
						<input class="input100" type="text" name="sName" placeholder="Second Name">
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" placeholder="Password">
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter validate password">
						<input class="input100" type="password" name="vpass" placeholder="Validate Password">
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Registrarse
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/bootstrap/js/popper.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/daterangepicker/moment.min.js"></script>
	<script src="../vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="../js/main.js"></script>

</body>
</html>