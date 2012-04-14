<?php

class XlsExport{

	public static function headers($filename){
		return array(
			"Pragma" => "public",
			"Expires" => "0",
			"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
			"Content-Type" => "application/force-download",
			"Content-Type" => "application/octet-stream",
			"Content-Type" => "application/download",
			"Content-Disposition" => "attachment;filename=" . $filename . ".xls",
			"Content-Transfer-Encoding" => "binary",
		);
	}

	public static function open() {
		$response = pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);  
		return $response;
	}

	public static function close() {
		$response = pack("ss", 0x0A, 0x00);
		return $response;
	}

	public static function write_number($Row, $Col, $Value) {
		$response = pack("sssss", 0x203, 14, $Row, $Col, 0x0);
		$response .= pack("d", $Value);
		return $response;
	}

	public static function write_text($Row, $Col, $Value ) {
		$lenght = strlen($Value);
		$response = pack("ssssss", 0x204, 8 + $lenght, $Row, $Col, 0x0, $lenght);
		$response .= $Value;
		return $response;
	} 
}