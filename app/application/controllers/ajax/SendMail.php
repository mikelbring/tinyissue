<?php
	include_once "db.php";

	$prefixe = "";
	while (!file_exists($prefixe."config.app.php")) {
		$prefixe .= "../";
	}
	$config = require $prefixe."config.app.php";
	$dataSrc = mysqli_connect($config['database']['host'], $config['database']['username'], $config['database']['password'], $config['database']['database']);


	$Type = $Type ?? $_GET["Type"] ?? 'Issue';
	$UserID = $User ?? $_GET["User"] ?? Auth::user()->id ?? 1;
	if ($Type == 'User') {
		$resu = mysqli_query ($dataSrc, "SELECT * FROM users WHERE email = '".$UserID."'");
	} else {
		$resu = mysqli_query ($dataSrc, "SELECT * FROM users WHERE id = ".$UserID);
	}
	$QuelUser = Fetche($resu);
	$emailLng = require ($prefixe."app/application/language/en/tinyissue.php");
	if ( file_exists($prefixe."app/application/language/".$QuelUser["language"]."/tinyissue.php") && $QuelUser["language"] != 'en') {
		$Lng = require ($prefixe."app/application/language/".$QuelUser["language"]."/tinyissue.php");
		$Lng = array_merge($emailLng, $Lng);
	} else {
		$Lng = $emailLng;
	}
	$optMail = $config["mail"];
	$ProjectID = $ProjectID ?? 0;
	$IssueID = $IssueID ?? 0;
	$message = @$contenu;

		//Select email addresses
	if ($Type == 'User') {
		$query  = "SELECT DISTINCT 0 AS project, 1 AS attached, 1 AS tages, USR.email, USR.firstname AS first, USR.lastname as last, CONCAT(USR.firstname, ' ', USR.lastname) AS user, USR.language, 'Welcome on BUGS' AS name, 'Welcome' AS title ";
		$query .= "FROM users AS USR WHERE USR.id = ".$UserID; 
	} else if ($Type == 'TestonsSVP') {
		$query  = "SELECT DISTINCT 0 AS project, 1 AS attached, 1 AS tages, USR.email, USR.firstname AS first, USR.lastname as last, CONCAT(USR.firstname, ' ', USR.lastname) AS user, USR.language, 'Testing mail for any project' AS name, 'Test' AS title ";
		$query .= "FROM users AS USR WHERE USR.id = ".$UserID; 
		$message = $Lng["email_test"];
		$subject = $Lng["email_test_tit"];
		echo $Lng["email_test_tit"];
	} else {
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
			$message = $contenu." {issue}.";
		} else if ($Type == 'Project') {
			$query .= "AND FAL.project = 1 ";
			$message = $contenu." {project}.";
		}
	}
	$followers = mysqli_query ($dataSrc, $query);

	if (Nombre($followers) > 0) {
		while ($follower = Fetche($followers)) {
			$passage_ligne = (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $follower["email"])) ? "\r\n" : "\n";

			$message = str_replace('"', "``", $message);
			$message = stripslashes($message);
			$message = str_replace("'", "`", $message);
//			$message = str_replace("xyz", (($Type == 'Issue') ? $follower["title"] : $follower["name"] ), $message);

			if ($optMail['transport'] == 'mail') {
				$boundary = md5(uniqid(microtime(), TRUE));
				$headers = 'From: "'.$optMail['from']['name'].'" <'.$optMail['from']['email'].'>'.$passage_ligne;
				$headers = 'Reply-To: "'.$optMail['replyTo']['name'].'" <'.$optMail['replyTo']['email'].'>'.$passage_ligne;
				$headers .= 'Mime-Version: 1.0'.$passage_ligne;
				$headers .= 'Content-Type: multipart/mixed; charset="'.$optMail['encoding'].'"; boundary="'.$boundary.'"';
				$headers .= $passage_ligne;

				$body = strip_tags( nl2br(str_replace("</p>", "<br /><br />", $message)));
				$body .= $passage_ligne;
				$body .= $passage_ligne;
				$body .= '--'.$boundary.''.$passage_ligne;
				$body .= 'Content-Type: text/html; charset="'.$optMail['encoding'].'"'.$passage_ligne;
				$body .= $passage_ligne;
				$body .= '<p>'.$optMail['intro'].'</p>';
				$body .= $passage_ligne;
				$body .= '<p>'.$message.'</p>';
//				$body .= $passage_ligne;
				$body .= $passage_ligne;
				$body .= '<p>'.$optMail['bye'].'</p>';
//				$body .= $passage_ligne;
				$body .= $passage_ligne.'';
				$body = wildcards ($body, $follower,$ProjectID, $IssueID);
				mail($follower["email"], $subject, $body, $headers);
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

				$mail->CharSet = $optMail['encoding'] ?? 'windows-1250';
				$mail->SetFrom ($optMail['from']['email'], $optMail['from']['name']);
				$mail->Subject = $subject;
				$mail->ContentType = $optMail['plainHTML'] ?? 'text/plain';
				$body  = $optMail['intro'];
				$body .= '<br /><br />';
				$body .= $message;
				$body .= '<br /><br />';
				$body .= $optMail['bye'];
				$body = wildcards ($body, $follower,$ProjectID, $IssueID);
				if ($mail->ContentType == 'html') {
					$mail->IsHTML(true);
					$mail->WordWrap = (isset($optMail['linelenght'])) ? $optMail['linelenght'] : 80;
					$mail->Body = $body;
					$mail->AltBody = strip_tags($body);
				} else {
					$mail->IsHTML(false);
					$mail->Body = strip_tags($body);
				}
//				$mail->AddAddress ($to);
				$mail->AddAddress ($follower["email"]);
				$result = $mail->Send() ? "Successfully sent!" : "Mailer Error: " . $mail->ErrorInfo;
			}
		}
	}
	
function wildcards ($body, $follower,$ProjectID, $IssueID) {
	$d = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$d = str_replace("issue/new", "issues?tag_id=1", $d);
	$body = str_replace('{first}', ucwords($follower["name"]), $body);
	$body = str_replace('{last}', ucwords($follower["last"]), $body);
	$body = str_replace('{full}', ucwords($follower["user"]), $body);
	$body = str_replace('{project}', '<a href="'.$d.'">'.$follower["name"].'</a>', $body);
	$body = str_replace('{issue}', '<a href="'.$d.'">'.$follower["title"].'</a>', $body);
	return $body;
}
?>
