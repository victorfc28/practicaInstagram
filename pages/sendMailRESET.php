<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require './vendor/autoload.php';
    $mail2 = new PHPMailer();
    $mail2->IsSMTP();

    //Configuració del servidor de Correu
    //Modificar a 0 per eliminar msg error
    $mail2->SMTPDebug = 2;
    $mail2->SMTPAuth = true;
    $mail2->SMTPSecure = 'tls';
    $mail2->Host = 'smtp.gmail.com';
    $mail2->Port = 587;
    
    //Credencials del compte GMAIL
    $mail2->Username = 'victorfabregascastro@gmail.com';
    $mail2->Password = '';

    //Dades del correu electrònic
    $mail2->SetFrom('emissor@gmail.com','Test');
    $mail2->Subject = 'Activación de cuenta';
    $body = file_get_contents("./pages/BodyRESET.html");
    $find = array("#link#");
    $replace = array($link);
    $BodyR = str_replace($find,$replace,$body);  
    $mail2->MsgHTML($BodyR);
    
    //Destinatari
    $address = $mailreset;
    $mail2->AddAddress($address);

    //Enviament
    $result = $mail2->Send();
    if(!$result){
        echo 'Error: ' . $mail2->ErrorInfo;
    }else{

        echo "Correu enviat";
    }