<?php

class File extends Laravel\File {

	/**
	 * Move an uploaded file to permanent storage.
	 *
	 * <code>
	 *		// Upload the $_FILES['photo'] file to a permanent location
	 *		File::upload('photo', 'path/to/new/home.jpg');
	 * </code>
	 *
	 * @param  string  $key
	 * @param  string  $path
	 * @return bool
	 */
	public static function upload($key, $path)
	{
		if ( ! isset($_FILES[$key])) return false;

		return move_uploaded_file($_FILES[$key]['tmp_name'], $path);
	}

}