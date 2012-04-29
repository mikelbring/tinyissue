
<?php

class CsvExport{
	public static function headers($filename){
		return array(
			"Pragma" => "public",
			"Content-Type" => "application/force-download",
			"Content-Type" => "application/octet-stream",
			"Content-Type" => "application/download",
			"Content-Disposition" => "attachment; filename=" . $filename . ".csv",
			"Pragma" => "no-cache",
			"Expires" => "0",
		);
	}

	public static function write_row($row){
		foreach ($row as $key => $value) {
			$row[$key] = self::escape_csv_value($value);
		}
		return join(',', $row)."\n";
	}

	public static function escape_csv_value($value) {
		$value = str_replace('"', '""', $value); // First off escape all " and make them ""
		if(preg_match('/,/', $value) or preg_match("/\n/", $value) or preg_match('/"/', $value)) { // Check if I have any commas or new lines
			return '"'.$value.'"'; // If I have new lines or commas escape them
		} else {
			return $value; // If no new lines or commas just return the value
		}
	}
}