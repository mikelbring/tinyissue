<?php
class Mail {
	/**
	 * Send the requested message
	 *
	 * @param   string  $message
	 * @param   string  $to
	 * @param   string  $subject
	 * @return  int
	 */
	public static function send_email($message, $to, $subject) {
		if ($options['transport'] == 'mail') {
			$message = str_replace('"', "``", $message); 
			$message = stripslashes($message);
			$message = str_replace("'", "`", $message); 
	
			$boundary = md5(uniqid(microtime(), TRUE));
			$headers = 'From: "'.$options['from']['name'].'" <'.$options['from']['email'].'>'.$passage_ligne;
			$headers .= 'Mime-Version: 1.0'.$passage_ligne;
			$headers .= 'Content-Type: multipart/mixed; boundary="'.$boundary.'"';
			$headers .= $passage_ligne;
	
			$body = strip_tags( str_replace("<br />", "\n", str_replace("</p>", "<br /><br />", $message)));
			$body .= $passage_ligne; 	
			$body .= $passage_ligne; 	
			$body .= '--'.$boundary.''.$passage_ligne;
			$body .= 'Content-Type: text/html; charset="'.$options['encoding'].'"'.$passage_ligne;
			$body .= $passage_ligne; 	
			$body .= $passage_ligne;
			$body .= $message;
			$body .= $passage_ligne;
			$body .= '--'.$boundary."n";
	
			$body .= $passage_ligne.'';
			mail($to, $subject, $body, $headers);
		} else {
			require_once  path('app') .  'libraries/PHPmailer/class.phpmailer.php';
			$options = Config::get('application.mail');
	
			$mail = new PHPMailer();
			$mail->Mailer = $options['transport'];
			switch ($options['transport']) {
				case 'PHP':
					require_once path('app') . 'libraries/PHPmailer/class.phpmailer.php';
					//Please submit your code
					//On March 14th, 2017 I had no time to go further on this
					break;
				case 'sendmail':
					require_once path('app') . 'libraries/PHPmailer/class.phpmaileroauth.php';
					//Please submit your code
					//On March 14th, 2017 I had no time to go further on this
					break;
				case 'gmail':
					require_once path('app') . 'libraries/PHPmailer/class.phpmaileroauthgoogle.php';
					//Please submit your code
					//On March 14th, 2017 I had no time to go further on this
					break;
				case 'POP3':
					require_once path('pop3') . 'libraries/PHPmailer/class.pop3.php';
					//Please submit your code
					//On March 14th, 2017 I had no time to go further on this
					break;
				default:																		//smtp is the second default value after "mail" which has its own code up
					require_once path('app') . 'libraries/PHPmailer/class.smtp.php';
					$mail->SMTPDebug = 1;												// 0 = no output, 1 = errors and messages, 2 = messages only.
					if ($options['smtp']['encryption'] == '') {
					} else {
						$mail->SMTPAuth = true;											// enable SMTP authentication
						$mail->SMTPSecure = $options['smtp']['encryption'];	// sets the prefix to the server
						$mail->Host = $options['smtp']['server'];
						$mail->Port = $options['smtp']['port'];
						$mail->Username = $options['smtp']['username'];
						$mail->Password = $options['smtp']['password'];
					}
					//Please submit your code
					//On March 14th, 2017 I had no time to go further on this
					break;
			}
	
			$mail->CharSet = (isset($options['encoding'])) ? $options['encoding'] : 'windows-1250';
			$mail->SetFrom ($options['from']['email'], $options['from']['name']);
			$mail->Subject = $subject;
			$mail->ContentType = (isset($option['plainHTML'])) ? $option['plainHTML'] : 'text/plain';
			if ($mail->ContentType == 'html') {
				$mail->IsHTML(true);
				$mail->WordWrap = (isset($options['linelenght'])) ? $options['linelenght'] : 80;
				$mail->Body = $message;
				$mail->AltBody = strip_tags($message);
			} else {
				$mail->IsHTML(false);
				$mail->Body = strip_tags($message);
			}
	
			$mail->AddAddress ($to);
			$result = $mail->Send() ? "Successfully sent!" : "Mailer Error: " . $mail->ErrorInfo;
		}
		return $result;
	}
}
