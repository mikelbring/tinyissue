<?php namespace Laravel; defined('DS') or die('No direct script access.');

class Crypter {
	/**
	 * The encryption cipher.
	 *
	 * @var string
	 */
	public static $cipher = 'aes128';

	/**
	 * The encryption mode.
	 *
	 * @var string
	 */
	public static $mode = 'AES-128-CBC';

	/**
	 * The block size of the cipher.
	 *
	 * @var int
	 */
	public static $block = 32;

	/**
	 * Encrypt a string using OpenSSL.
	 *
	 * The string will be encrypted using the AES-256 scheme and will be base64 encoded.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function encrypt($value) {
		$iv = random_bytes(static::iv_size());
		$value = static::pad($value);
		$value = openssl_encrypt($value, static::$cipher, static::key(), OPENSSL_RAW_DATA, $iv);

		return base64_encode($iv.$value);
	}

	/**
	 * Decrypt a string using OpenSSL.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function decrypt($value) {
		$value = base64_decode($value);

		// To decrypt the value, we first need to extract the input vector and
		// the encrypted value. The input vector size varies across different
		// encryption ciphers and modes, so we'll get the correct size.
		$iv = substr($value, 0, static::iv_size());
		$value = substr($value, static::iv_size());

		// Once we have the input vector and the value, we can give them both
		// to OpenSSL for decryption. The value is sometimes padded with \0,
		// so we will trim all of the padding characters.
		$value = openssl_decrypt($value, static::$mode, static::key(), OPENSSL_RAW_DATA, $iv);

		return static::unpad($value);
	}


	protected static function iv_size() {
		return openssl_cipher_iv_length(static::$mode);
	}

	/**
	 * Add PKCS7 compatible padding on the given value.
	 *
	 * @param  string  $value
	 * @return string
	 */
	protected static function pad($value) {

		$pad = static::$block - (Str::length($value) % static::$block);
		return $value .= str_repeat(chr($pad), $pad);
	}

	/**
	 * Remove the PKCS7 compatible padding from the given value.
	 *
	 * @param  string  $value
	 * @return string
	 */
	protected static function unpad($value) {
		$pad = ord($value[($length = Str::length($value)) - 1]);

		if ($pad and $pad < static::$block) {

			// If the correct padding is present on the string, we will remove
			// it and return the value. Otherwise, we'll throw an exception
			// as the padding appears to have been changed.
			if (strpos($value, '|')) {
				return substr($value, 0, strpos($value, '|'));
			} else {
				// If the padding characters do not match the expected padding
				// for the value we'll bomb out with an exception since the
				// encrypted value seems to have been changed.
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
	protected static function key() {
		return Config::get('application.key');
	}

}