<?php namespace Project\Issue;

class Attachment extends \Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects_issues_attachments';

    /**
     * @var array
     */
    protected $fillable = array('uploaded_by', 'filename', 'fileextension', 'filesize', 'upload_token');

    /**
     * Upload the attachment
     *
     * @param \User $user
     * @param array $input
     *
     * @return bool
     */
    public static function upload(\User $user, array $input)
    {
        $path = \Config::get('app.upload_path');

        if ( ! \File::exists($path = $path . '/' . $input['project_id']))
        {
            \File::makeDirectory($path);
        }

        if ( ! \File::exists($path = $path . '/' . $input['upload_token']))
        {
            \File::makeDirectory($path);
        }

        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile */
        $uploadedFile = \Request::file('Filedata');
        $target = $uploadedFile->move($path, $uploadedFile->getClientOriginalName());

        \Log::info(sprintf('Upload %s', $target));

        $fill = array(
            'uploaded_by'   => $user->id,
            'filename'      => $uploadedFile->getClientOriginalName(),
            'fileextension' => \File::extension($target),
            'filesize'      => $uploadedFile->getClientSize(),
            'upload_token'  => $input['upload_token']
        );

        $attachment = new static;
        $attachment->fill($fill);
        $attachment->save();

        return true;
    }

    /**
     * Remove a attachment that is pending from a issue/comment
     *
     * @param  array $input
     * @return void
     */
    public static function removeAttachment(array $input)
    {
        static::where('uploaded_by', '=', \Auth::user()->id)
            ->where('upload_token', '=', $input['upload_token'])
            ->where('filename', '=', $input['filename'])
            ->delete();

        $path = \Config::get('app.upload_path') . '/' . $input['project_id'] . '/' . $input['upload_token'];

        static::deleteFile($path, $input['filename']);
    }

    /**
     * Delete the physical file of an attachment
     *
     * @param  string $path
     * @param  string $filename
     * @return void
     */
    public static function deleteFile($path, $filename)
    {
        \File::delete($path . '/' . $filename);
        \File::deleteDirectory($path);
    }
}
