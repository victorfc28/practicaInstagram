<?php
session_start();
require_once '../BD/connecta_db_persistent.php';
if (isset($_GET["mail"]) && isset($_GET["code"])) {
    
    $sql = 'SELECT mail FROM `users` WHERE activationCode = :code AND mail= :mail';
    $preparada = $db->prepare($sql);
    $preparada->execute(array(':code' => $_GET["code"],
                                ':mail' => $_GET["mail"]));
    $result = $preparada->fetch(PDO::FETCH_ASSOC);

    if($result !=false)
	{

        $sql2 = 'UPDATE users SET activado=1, activationDate=sysdate() WHERE mail=:mail';
        $preparada2 = $db->prepare($sql2);
        $preparada2->execute(array(':mail' => $_GET["mail"]));
        echo'tu cuenta ha sido verificada';
    }
    else echo'tu cuenta no ha sido verificada';

}
?>