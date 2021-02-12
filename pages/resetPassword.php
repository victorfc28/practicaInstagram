<?php
session_start();
require_once '../BD/connecta_db_persistent.php';
if (isset($_GET["mail"]) && isset($_GET["code"])) {
    
    $sql = 'SELECT resetPass, resetPassExpiry FROM `users` WHERE resetPassCode = :code AND mail= :mail';
    $preparada = $db->prepare($sql);
    $preparada->execute(array(':code' => $_GET["code"],
                                ':mail' => $_GET["mail"]));
    $result = $preparada->fetch(PDO::FETCH_ASSOC);

    if($result !=false)
	{
		if($result["resetPass"] == 0 || $result["resetPassExpiry"]<date('Y-m-d H:i:s'))
		{
			echo'El link a caducado.';
		}
		else
		{
			echo'puedes cambiar la contraseña'; 
			
		}       
    }
	else	echo'No tienes permiso para cambiar tu contraseña.';
	
	
	


}
else if(isset($_POST["newpassword"]) && isset($_POST["rpassword"]))
{
	if($_POST["newpassword"] === $_POST["rpassword"])
	{
		$sql = 'UPDATE users SET resetPass=0, resetPassExpiry=null, resetPassCode=null, passhash = :pass WHERE mail=:mail';
		$preparada = $db->prepare($sql);
		$preparada->execute(array(':mail' => $_POST["mail"],
									':pass' => password_hash($_POST['newpassword'],PASSWORD_DEFAULT)));
	}
	else
	{
		echo'Las contraseñas no coinciden.'; 
	}
}
else
{
    header("Location: ../index.php");
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
						Reset Password
					</span>
					<div class="wrap-input100 validate-input" data-validate = "Enter new password">
						<input class="input100" type="password" name="newpassword" placeholder="Password">
					</div>
                    <div class="wrap-input100 validate-input" data-validate = "repeat password">
						<input class="input100" type="password" name="rpassword" placeholder="Repeat Password">
					</div>
						<input class="ihidden" type="hidden" name="mail" value=<?php if(isset($_GET["mail"])) echo '"'.$_GET["mail"].'"';?>>
					<div class="container-login100-form-btn">
						<button class="btn btn-primary">
							Reset
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