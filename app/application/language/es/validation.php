<?php 

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used
	| by the validator class. Some of the rules contain multiple versions,
	| such as the size (max, min, between) rules. These versions are used
	| for different input types such as strings and files.
	|
	| These language lines may be easily changed to provide custom error
	| messages in your application. Error messages for custom validation
	| rules may also be added to this file.
	|
	*/

	"accepted"       => "El :attribute debe ser aceptado.",
	"active_url"     => "El :attribute no es una URL válida.",
	"after"          => "El :attribute debe ser una fecha posterior a :date.",
	"alpha"          => "El :attribute sólo puede contener letras.",
	"alpha_dash"     => "El :attribute sólo puede contener letras, números y guiones.",
	"alpha_num"      => "El :attribute sólo puede contener letras y números.",
	"before"         => "El :attribute debe ser una fecha anterior a :date.",
	"between"        => array(
		"numeric" => "El :attribute debe estar entre :min y :max.",
		"file"    => "El :attribute debe estar entre :min y :max kilobytes.",
		"string"  => "El :attribute debe estar entre :min y :max caracteres.",
	),
	"confirmed"      => "La confirmación de :attribute no coincide.",
	"different"      => "El :attribute y :other deben ser diferentes.",
	"email"          => "El formato de :attribute es inválido.",
	"exists"         => "El :attribute seleccionado es inválido.",
	"image"          => "El :attribute debe ser una imagen.",
	"in"             => "El :attribute seleccionado es inválido.",
	"integer"        => "El :attribute debe ser un número entero.",
	"ip"             => "El :attribute debe ser una dirección IP válida.",
	"match"          => "El formato de :attribute es inválido.",
	"max"            => array(
		"numeric" => "El :attribute debe ser menor que :max.",
		"file"    => "El :attribute debe ser menor que :max kilobytes.",
		"string"  => "El :attribute debe ser menor que :max caracteres.",
	),
	"mimes"          => "El :attribute debe ser un archivo de tipo: :values.",
	"min"            => array(
		"numeric" => "El :attribute debe ser al menos :min.",
		"file"    => "El :attribute debe ser de al menos :min kilobytes.",
		"string"  => "El :attribute debe ser de al menos :min caracteres.",
	),
	"not_in"         => "El :attribute seleccionado es inválido.",
	"numeric"        => "El :attribute debe ser un número.",
	"required"       => "El campo :attribute es obligatorio.",
	"same"           => "El :attribute y :other deben coincidir.",
	"size"           => array(
		"numeric" => "El :attribute debe tener :size.",
		"file"    => "El :attribute debe tener :size kilobytes.",
		"string"  => "El :attribute debe tener :size caracteres.",
	),
	"unique"         => "El :attribute ya ha sido usado.",
	"url"            => "El formato de :attribute es inválido.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute_rule" to name the lines. This helps keep your
	| custom validation clean and tidy.
	|
	| So, say you want to use a custom validation message when validating that
	| the "email" attribute is unique. Just add "email_unique" to this array
	| with your custom message. The Validator will handle the rest!
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as "E-Mail Address" instead
	| of "email". Your users will thank you.
	|
	| The Validator class will automatically search this array of lines it
	| is attempting to replace the :attribute place-holder in messages.
	| It's pretty slick. We think you'll like it.
	|
	*/

	'attributes' => array(),

);