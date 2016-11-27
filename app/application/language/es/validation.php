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

	"accepted"       => "El valor :attribute debe ser aceptado.",
	"active_url"     => "La URL :attribute no es una dirección válida.",
	"after"          => "La fecha :attribute debe ser posterior a :date.",
	"alpha"          => "El valor :attribute sólo puede contener letras.",
	"alpha_dash"     => "El valor :attribute sólo puede contener letras, números y guiones.",
	"alpha_num"      => "El valor :attribute sólo puede contener letras y números.",
	"before"         => "La fecha :attribute debe ser anterior a :date.",
	"between"        => array(
		"numeric" => "El valor :attribute debe estar en el rango :min - :max.",
		"file"    => "El fichero :attribute debe tener un tamaño entre :min - :max kilobytes.",
		"string"  => "La cadena :attribute debe tener una longitud entre :min - :max caracteres.",
	),
	"confirmed"      => "El valor :attribute no coincide.",
	"different"      => "Los valores :attribute y :other deben ser distintos.",
	"email"          => "El formato de :attribute no es válido.",
	"exists"         => "El valor seleccionado :attribute no es válido.",
	"image"          => "Este fichero :attribute debe ser una imagen.",
	"in"             => "El valor seleccionado :attribute no es válido.",
	"integer"        => "El valor :attribute debe ser un entero.",
	"ip"             => "La IP :attribute debe ser una IP válida.",
	"match"          => "El formato del valor :attribute no es válido.",
	"max"            => array(
		"numeric" => "El valor :attribute debe ser inferior a :max.",
		"file"    => "El fichero :attribute debe tener menos de :max kilobytes.",
		"string"  => "La cadena :attribute debe tener longitud inferior a :max caracteres.",
	),
	"mimes"          => "El fichero :attribute debe ser de tipo: :values.",
	"min"            => array(
		"numeric" => "El número :attribute debe ser como mínimo :min.",
		"file"    => "El fichero :attribute debe pesar al menos :min kilobytes.",
		"string"  => "La cadena :attribute debe tener al menos :min caracteres.",
	),
	"not_in"         => "El atributo seleccionado :attribute no es válido.",
	"numeric"        => "El valor :attribute debe ser numérico.",
	"required"       => "El campo :attribute es obligatorio.",
	"same"           => "El valor :attribute y :other deben ser idénticos.",
	"size"           => array(
		"numeric" => "El valor :attribute debe ser de tamaño :size.",
		"file"    => "El fichero :attribute debe pesar :size kilobyte.",
		"string"  => "La cadena :attribute debe tener longitud de :size caracteres.",
	),
	"unique"         => "El valor :attribute ya existe previamente.",
	"url"            => "El formato de la URL :attribute no es válido.",

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