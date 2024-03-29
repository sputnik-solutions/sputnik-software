<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';



$post = xss($_POST);

if(isset($post['name'])) {
    
    
    $mail = new PHPMailer();
    
    $mail->CharSet = 'utf-8';
    $mail->setFrom('admin@sputnik.ru', 'Заявка');
    $mail->addAddress('info@sputnik.software');   // Адрес, на который отправляются письма
    $mail->addReplyTo('admin@sputnik.ru', 'Information');
    $mail->isHTML(true);
    $mail->Subject = 'Новый заказ с сайта';
    
    
    $message = '';
    
    $message .= "Имя: {$post['name']}\r\n" . "<br>";
    
    if( isset($post['phone']) && !empty($post['phone']) ) $message .= "Телефон: {$post['phone']}\r\n" . "<br>";
    if( isset($post['email']) && !empty($post['email']) ) $message .= "Почта: {$post['email']}\r\n" . "<br>";
    if( isset($post['message']) && !empty($post['message']) ) $message .= "Сообщение: {$post['message']}\r\n" . "<br>";
    
    
    $mail->Body = $message;
    $mail->AltBody = $message;
    
    if($mail->send()) {
     echo "Письмо отправлено";   
    } else {
        echo 'Письмо не отправлено';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
    
}


function xss($data) {
    if(is_array($data)){
        $esc = array();
        foreach($data as $key => $value){
            $esc[$key] = xss($value);
        }
        return $esc;
    }
    return trim(htmlspecialchars($data));
}

?>