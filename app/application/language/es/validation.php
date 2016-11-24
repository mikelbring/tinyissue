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
	"alpha"          => "El :attribute solo debe contener letras.",
	"alpha_dash"     => "El :attribute solo debe contener letras, numeros y guiones.",
	"alpha_num"      => "El :attribute solo debe contener letras y numeros.",
	"before"         => "El :attribute debe ser previa a la fecha :date.",
	"between"        => array(
		"numeric" => "El :attribute debe estar entre :min - :max.",
		"file"    => "El :attribute debe pesar entre :min - :max kilobytes.",
		"string"  => "El :attribute debe tener entre :min - :max caracteres.",
	),
	"confirmed"      => "La :attribute confirmacion no coincide.",
	"different"      => ":attribute y :other deben ser diferentes.",
	"email"          => "El formato de :attribute no es valido.",
	"exists"         => "El :attribute seleccionado es invalido.",
	"image"          => ":attribute debe ser una imagen.",
	"in"             => "El :attribute seleccionado es invalido.",
	"integer"        => ":attribute debe ser un entero.",
	"ip"             => ":attribute debe ser una direccion IP.",
	"match"          => "El formato de :attribute no es valido.",
	"max"            => array(
		"numeric" => ":attribute debe ser menor a :max.",
		"file"    => ":attribute debe ser menor a :max kilobytes.",
		"string"  => ":attribute debe ser menor a :max caracteres.",
	),
	"mimes"          => ":attribute debe ser un archivo type: :values.",
	"min"            => array(
		"numeric" => ":attribute debe ser al menos :min.",
		"file"    => ":attribute debe ser al menos de :min kilobytes.",
		"string"  => ":attribute debe tener al menos :min caracteres.",
	),
	"not_in"         => "El :attribute seleccionado es invalido.",
	"numeric"        => ":attribute debe ser un numero.",
	"required"       => "El campo :attribute es requerido.",
	"same"           => ":attribute y :other deben coincidir.",
	"size"           => array(
		"numeric" => ":attribute debe ser :size.",
		"file"    => ":attribute debe ser :size kilobyte.",
		"string"  => ":attribute debe ser de :size caracteres.",
	),
	"unique"         => ":attribute ya ha sido elegido.",
	"url"            => "El formato de :attribute es invalido.",

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
