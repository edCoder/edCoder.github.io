<?php
//Last Updated: 15-Mar-2016

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/PHPMailer/src/Exception.php';
require 'includes/PHPMailer/src/PHPMailer.php';
require 'includes/PHPMailer/src/SMTP.php';

if(isset($_POST['btnsubmit'])) {
	$name = $email = $phone = $subject = $message = '';
	$i=0;

	if (isset($_POST['name']) && $_POST['name']!='') {
		$name = $_POST['name'];
		$i++;
	}
	
	if (isset($_POST['email']) && $_POST['email']!='') {
		$email = $_POST['email'];
		$i++;
	}
	
	if (isset($_POST['phone']) && $_POST['phone']!='') {
		$phone = $_POST['phone'];
		$i++;
	}

	if (isset($_POST['subject']) && $_POST['subject']!='') {
		$subject = $_POST['subject'];
		$i++;
	}
	
	if (isset($_POST['message']) && $_POST['message']!='') {
		$message = $_POST['message'];
		$i++;
	}
	
	if ($i>=5) {
		$to = 'edwinthomas25@gmail.com';
		$html='<table width="100%" border="0" bgcolor="white" cellpadding="10" style="border: 1px solid #000;">
			<tr>
				<td width="30%" align="center">
					<img src="http://edcoder.github.io/assets/images/logo.png" alt="edcoder.github.io" style="width: 70%;">
				</td>
				<td width="60%" style="text-align: right; line-height: 2;">
					edcoder.github.io,<br>
					Thrissur, Kerala<br>
					Date: '.date('d-M-Y').'<br>
				</td>
			</tr>
			<tr>
				<td colspan="2"><div style="border-top: 1px solid #000;"></div></td>
			</tr>
			<tr>
				<td width="100%" colspan="2">
					Hello Admin,
				</td>
			</tr>
			<tr>
				<td style="padding:5px;">Name</td><td style="padding:5px;">'.$name.'</td>
			</tr>
			<tr>
				<td style="padding:5px;">Email</td><td style="padding:5px;">'.$email.'</td>
			</tr>
			<tr>
				<td style="padding:5px;">Phone</td><td style="padding:5px;">'.$phone.'</td>
			</tr>
			<tr>
				<td style="padding:5px;">Subject</td><td style="padding:5px;">'.$subject.'</td>
			</tr>
			<tr>
				<td style="padding:5px;">Message</td><td style="padding:5px;">'.str_replace('\r\n','<br/>',$message).'</td>
			</tr>
			<tr>
				<td style="padding:5px;">Enquiry Date</td><td style="padding:5px;">'.date('d-M-Y').'</td>
			</tr>
		</table>';
		
		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = true; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMailtls
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = '';
		$mail->Password = '';
		$mail->From = '';
		$mail->FromName = $name;
		$mail->Subject = 'Feedback From edcoder.github.io';
		$mail->Body = $html;
		$mail->AddAddress($to);
		if($mail->send()) {
			$message='Feedback Sent. We Will Contact You Soon.';
			$status='success';
		} else {
			$message=$mail->ErrorInfo;
			$status='error';
		}
	}
	else {
		$message='Please fill all required fields.';
		$status='error';
	}

	$data = array(
		"message" => $message,
		"status" => $status
	);
	echo json_encode($data);
}
?>