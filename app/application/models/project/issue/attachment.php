<?php namespace Project\Issue;

class Attachment extends \Eloquent {

	public static $table = 'projects_issues_attachments';
	public static $timestamps = true;

	/**
	* Upload the attachment
	*
	* @param  array  $input
	* @return bool
	*/
	public static function upload($input) {
		$path = \Config::get('application.upload_path');

		if(!file_exists($path = $path . $input['project_id'])) {
			mkdir($path);
		}

		if(!file_exists($path = $path . '/' . $input['upload_token'])) {
			mkdir($path);
		}

		$file = \Input::file('Filedata');

		\File::upload('Filedata', $file_path = $path . '/' .  $file['name']);

		$fill = array(
			'uploaded_by' => \Auth::user()->id,
			'filename' => $file['name'],
			'fileextension' => \File::extension($file_path),
			'filesize' => $file['size'],
			'upload_token' => $input['upload_token']
		);

		$attachment = new static;
		$attachment->fill($fill);
		$attachment->save();

		return true;
	}

	/**
	* Remove a attachment that is pending from a issue/comment
	*
	* @param  array  $input
	* @return void
	*/
	public static function remove_attachment($input)
	{
		static::where('uploaded_by', '=', \Auth::user()->id)
			->where('upload_token', '=', $input['upload_token'])
			->where('filename', '=', $input['filename'])
			->delete();

		$path = \Config::get('application.upload_path') . $input['project_id'] . '/' . $input['upload_token'];

		static::delete_file($path, $input['filename']);
	}

	/**
	* Delete the physical file of an attachment
	*
	* @param  string  $path
	* @param  string  $filename
	* @return void
	*/
	public static function delete_file($path, $filename)
	{
		@unlink($path . '/' . $filename);
		@rmdir($path);
	}
}