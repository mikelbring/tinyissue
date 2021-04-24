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
		mail($to, $subject, $message);
		include_once "../app/application/controllers/ajax/SendMail.php";
	}
}
