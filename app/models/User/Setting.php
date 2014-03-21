<?php namespace User;

class Setting extends \Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * @var array
     */
    protected $fillable = array('email', 'firstname', 'lastname', 'language', 'password');

    /**
     * Get available languages from translations folder.
     *
     * @param string $locale
     *
     * @return array
     */
    public static function getLanguages($locale)
    {
        $languages = array();
        foreach (new \DirectoryIterator(app_path('lang')) as $fileInfo)
        {
            /** @var \DirectoryIterator $fileInfo */
            if ($fileInfo->isDot() || ! $fileInfo->isDir())
            {
                continue;
            }

            $selected = '';

            if ($fileInfo->getFilename() == $locale)
            {
                $selected = "selected";
            }

            $languages[] = array('name' => $fileInfo->getFilename(), 'selected' => $selected);
        }

        return $languages;
    }

    /**
     * Updates the users settings, validates the fields
     *
     * @param \User $user
     * @param array $info
     *
     * @return array
     */
    public static function updateUserSettings(array $info, \User $user)
    {
        $rules = array(
            'firstname' => array('required', 'max:50'),
            'lastname'  => array('required', 'max:50'),
            'language'  => array('required'),
            'email'     => array('required', 'email'),
        );

        // Validate the password
        if ($info['password'])
        {
            $rules['password'] = 'confirmed';
        }

        $validator = \Validator::make($info, $rules);

        if ($validator->fails())
        {
            return array(
                'success' => false,
                'errors'  => $validator->errors
            );
        }

        /* Settings are valid */
        $update = array(
            'email'     => $info['email'],
            'firstname' => $info['firstname'],
            'lastname'  => $info['lastname'],
            'language'  => $info['language']
        );

        /* Update the password */
        if ($info['password'])
        {
            $update['password'] = \Hash::make($info['password']);
        }

        \User::find($user->id)->fill($update)->save();

        return array(
            'success' => true
        );
    }
}
