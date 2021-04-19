<?php
	include "db.php";
	
	$Type = $Type ?? 'Issue';
	$UserID = $User ?? $_GET["User"] ?? Auth::user()->id ?? 1;
	$resu = mysqli_query ($dataSrc, "SELECT * FROM users WHERE id = ".$UserID);
	$QuelUser = Fetche($resu);
	$emailLng = require ("application/language/en/tinyissue.php");
	if ( file_exists("application/language/".$QuelUser["language"]."/tinyissue.php") && $QuelUser["language"] != 'en') {
		$Lng = require ("application/language/".$QuelUser["language"]."/tinyissue.php");
		$Lng = array_merge($emailLng, $Lng);
	} else {
		$Lng = $emailLng;
	}
	$optMail = $config["mail"];
	$message = $contenu." « xyz ».";

	//Select email addresses
	$query  = "SELECT DISTINCT FAL.project, FAL.attached, FAL.tags, USR.email, USR.firstname AS first, USR.lastname as last, CONCAT(USR.firstname, ' ', USR.lastname) AS user, USR.language, PRO.name, TIK.title ";
	$query .= "FROM following AS FAL ";
	$query .= "LEFT JOIN users AS USR ON USR.id = FAL.user_id "; 
	$query .= "LEFT JOIN projects AS PRO ON PRO.id = FAL.project_id ";
	$query .= "LEFT JOIN projects_issues AS TIK ON TIK.id = FAL.issue_id ";
	$query .= "WHERE FAL.project_id = ".$ProjectID." ";
	if ($Type == 'Issue') {
		$query .= "AND FAL.project = 0 AND issue_id = ".$IssueID." ";
		$query .= ($SkipUser) ? "AND FAL.user_id NOT IN (".$User.") " : "";
		$query .= "AND FAL.project = 0 ";
	} else if ($Type == 'Project') {
		$query .= "AND FAL.project = 1 ";
	}
	$followers = mysqli_query ($dataSrc, $query);

	if (Nombre($followers) > 0) {
		while ($follower = Fetche($followers)) { 
			$passage_ligne = (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $follower["email"])) ? "\r\n" : "\n";

			$message = str_replace('"', "``", $message); 
			$message = stripslashes($message);
			$message = str_replace("'", "`", $message); 
			$message = str_replace("xyz", (($Type == 'Issue') ? $follower["title"] : $follower["name"] ), $message);
		
			if ($optMail['transport'] == 'mail') {
				$boundary = md5(uniqid(microtime(), TRUE));
				$headers = 'From: "'.$optMail['from']['name'].'" <'.$optMail['from']['email'].'>'.$passage_ligne;
				$headers = 'Reply-To: "'.$optMail['replyTo']['name'].'" <'.$optMail['replyTo']['email'].'>'.$passage_ligne;
				$headers .= 'Mime-Version: 1.0'.$passage_ligne;
				$headers .= 'Content-Type: multipart/mixed; charset="'.$optMail['encoding'].'"; boundary="'.$boundary.'"';
				$headers .= $passage_ligne;
				
				$intro = str_replace('{first}', ucwords($follower["name"]), $optMail['intro']);
				$intro = str_replace('{last}', ucwords($follower["last"]), $intro);
				$intro = str_replace('{full}', ucwords($follower["user"]), $intro);
				$bye = str_replace('{first}', ucwords($follower["name"]), $optMail['bye']);
				$bye = str_replace('{last}', ucwords($follower["last"]), $bye);
				$bye = str_replace('{full}', ucwords($follower["user"]), $bye);
		
				$body = strip_tags( nl2br(str_replace("</p>", "<br /><br />", $message)));
				$body .= $passage_ligne; 	
				$body .= $passage_ligne; 	
				$body .= '--'.$boundary.''.$passage_ligne;
				$body .= 'Content-Type: text/html; charset="'.$optMail['encoding'].'"'.$passage_ligne;
				$body .= $passage_ligne; 	
				$body .= $passage_ligne;
				$body .= $passage_ligne;
				$body .= $message;
				$body .= $passage_ligne;
				$body .= $passage_ligne;
				$body .= $passage_ligne.'';
				mail($follower["email"], $subject, $intro.$body.$bye, $headers);
			} else {
				$mail = new PHPMailer();
				$mail->Mailer = $optMail['transport'];
				switch ($optMail['transport']) {
						//Please submit your code
						//On March 14th, 2017 I had no time to go further on these different types ( case 'PHP', 'sendmail', 'gmail', 'POP3' ) 
					case 'PHP':
						require_once  'application/libraries/PHPmailer/class.phpmailer.php';
						break;
					case 'sendmail':
						require_once '/application/libraries/PHPmailer/class.phpmaileroauth.php';
						break;
					case 'gmail':
						require_once '/application/libraries/PHPmailer/class.phpmaileroauthgoogle.php';
						break;
					case 'POP3':
						require_once '/application/libraries/PHPmailer/class.pop3.php';
						break;
					default:																		//smtp is the second default value after "mail" which has its own code up
						require_once '/application/libraries/PHPmailer/class.smtp.php';
						$mail->SMTPDebug = 1;												// 0 = no output, 1 = errors and messages, 2 = messages only.
						if ($optMail['smtp']['encryption'] == '') {
						} else {
							$mail->SMTPAuth = true;											// enable SMTP authentication
							$mail->SMTPSecure = $optMail['smtp']['encryption'];	// sets the prefix to the server
							$mail->Host = $optMail['smtp']['server'];
							$mail->Port = $optMail['smtp']['port'];
							$mail->Username = $optMail['smtp']['username'];
							$mail->Password = $optMail['smtp']['password'];
						}
						break;
				}
		
				$mail->CharSet = (isset($optMail['encoding'])) ? $optMail['encoding'] : 'windows-1250';
				$mail->SetFrom ($optMail['from']['email'], $optMail['from']['name']);
				$mail->Subject = $subject;
				$mail->ContentType = (isset($optMail['plainHTML'])) ? $optMail['plainHTML'] : 'text/plain';
				if ($mail->ContentType == 'html') {
					$mail->IsHTML(true);
					$mail->WordWrap = (isset($optMail['linelenght'])) ? $optMail['linelenght'] : 80;
					$mail->Body = $message;
					$mail->AltBody = strip_tags($message);
				} else {
					$mail->IsHTML(false);
					$mail->Body = strip_tags($message);
				}
				$mail->AddAddress ($to);
				$result = $mail->Send() ? "Successfully sent!" : "Mailer Error: " . $mail->ErrorInfo;
			}
		} 
	}
?>