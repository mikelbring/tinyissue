<?php namespace Laravel; defined('DS') or die('No direct script access.');

class Crypter {


	/**
	 * Encrypt a string using Mcrypt.
	 *
	 * The string will be encrypted using the AES-256 scheme and will be base64 encoded.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function encrypt($value) {
		$key = static::key();
		$value = openssl_encrypt($value, 'AES256', $key);
		return base64_encode($value);
	}

	/**
	 * Decrypt a string using Mcrypt.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function decrypt($value) {
		$key = static::key();
		return openssl_decrypt($value, 'AES256', $key);
	}

	/**
	 * Get the most secure random number generator for the system.
	 *
	 * @return int
	 */
	public static function randomizer()
	{
		// There are various sources from which we can get random numbers
		// but some are more random than others. We'll choose the most
		// random source we can for this server environment.
		if (defined('MCRYPT_DEV_URANDOM'))
		{
			return MCRYPT_DEV_URANDOM;
		}
		elseif (defined('MCRYPT_DEV_RANDOM'))
		{
			return MCRYPT_DEV_RANDOM;
		}
		// When using the default random number generator, we'll seed
		// the generator on each call to ensure the results are as
		// random as we can possibly get them.
		else
		{
			mt_srand();

			return MCRYPT_RAND;
		}
	}

	/**
	 * Get the input vector size for the cipher and mode.
	 *
	 * @return int
	 */
	protected static function iv_size()
	{
		return mcrypt_get_iv_size(static::$cipher, static::$mode);
	}

	/**
	 * Add PKCS7 compatible padding on the given value.
	 *
	 * @param  string  $value
	 * @return string
	 */
	protected static function pad($value)
	{
		$pad = static::$block - (Str::length($value) % static::$block);

		return $value .= str_repeat(chr($pad), $pad);
	}

	/**
	 * Remove the PKCS7 compatible padding from the given value.
	 *
	 * @param  string  $value
	 * @return string
	 */
	protected static function unpad($value)
	{
		$pad = ord($value[($length = Str::length($value)) - 1]);

		if ($pad and $pad < static::$block)
		{
			// If the correct padding is present on the string, we will remove
			// it and return the value. Otherwise, we'll throw an exception
			// as the padding appears to have been changed.
			if (preg_match('/'.chr($pad).'{'.$pad.'}$/', $value))
			{
				return substr($value, 0, $length - $pad);
			}

			// If the padding characters do not match the expected padding
			// for the value we'll bomb out with an exception since the
			// encrypted value seems to have been changed.
			else
			{
				throw new \Exception("Decryption error. Padding is invalid.");
			}
		}

		return $value;
	}

	/**
	 * Get the encryption key from the application configuration.
	 *
	 * @return string
	 */
	protected static function key()	{
		return Config::get('application.key');
	}

}