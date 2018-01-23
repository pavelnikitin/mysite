
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$name = strip_tags(trim($_POST['form_name']));
$name = str_replace(array('\r','\n'),array(' ',' '),$name);
$email = filter_var(trim($_POST['form_email']), FILTER_SANITIZE_EMAIL);
$message = trim($_POST['form_msg']);


if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
// Установить 400 (неудачный запрос) и выйти.
http_response_code(400);
echo 'Пожалуйста, заполните форму';
exit;
}
// включить файл PHPMailerAutoload.php
require_once dirname(__FILE__) . '/phpmailer/PHPMailerAutoload.php';
   
//формируем тело письма
$output = 'Дата: ' . date("d-m-Y H:i") ."\n";
$output .= 'Имя пользователя: ' . $name ."\n";
$output .= 'Email: ' . $email . "\n";
$output .= 'Сообщение: ' . $message ."\n" ;

// создаём экземпляр класса PHPMailer
$mail = new PHPMailer;

$mail->From      = 'no-reply@24verstka.ru';
$mail->FromName  = '24verstka.ru';
$mail->Subject   = 'Сообщение с сайта 24verstka.ru';
$mail->Body      = $output;
$mail->AddAddress( 'nikitin.pavel.nik@yandex.ru' );

// отправляем письмо
if ($mail->Send()) {
    $data['result']='success';
  } else {
    $data['result']='error';
  }
}

?>