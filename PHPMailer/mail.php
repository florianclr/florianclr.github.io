<?php
use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST['name']) && isset($_POST['email'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$subject = $_POST['subject'];
<<<<<<< Updated upstream
	$body = $_POST['body']
=======
	$body = $_POST['body'];
>>>>>>> Stashed changes

	require_once '../PHPMailer/src/PHPMailer.php';
	require_once '../PHPMailer/src/SMTP.php';
	require_once '../PHPMailer/src/Exception.php';

	$mail = new PHPMailer();

	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'testdupinf@gmail.com';
	$mail->Password = 'testdupinf123';
	$mail->isSMTP();
	$mail->Port = '465';
	$mail->SMTPSecure = 'ssl';

	$mail->isHTML(true);
	$mail->setFrom($email, $name);
	$mail->addAddress('florian.celary2@gmail.com');

	$mail->Subject = $subject;
	$mail->Body = $body;

	if ($mail->send())
	{
<<<<<<< Updated upstream
		$status = "success"
		$response = "sent"	
=======
		$status = "success";
		$response = "sent";
>>>>>>> Stashed changes
	}
	else
	{
		$status = "failed";
		$response = "Something is wrong: <br>" . $mail->ErrorInfo;
	}

	exit(json_encode(array("status" => $status, "response" => $response)));

}
?>