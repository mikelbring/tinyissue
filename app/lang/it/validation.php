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

	"accepted"       => ":attribute deve essere accettato.",
	"active_url"     => ":attribute non è un URL valido.",
	"after"          => ":attribute deve essere una data successiva a :date.",
	"alpha"          => ":attribute può contenere solo lettere.",
	"alpha_dash"     => ":attribute può contenere solo lettere, numeri e tratti (-).",
	"alpha_num"      => ":attribute può contenere numeri e lettere.",
	"before"         => ":attribute deve essere una data precedente a :date.",
	"between"        => array(
		"numeric" => ":attribute deve essere compreso tra :min - :max.",
		"file"    => ":attribute deve avere dimensione compresa tra :min - :max kilobytes.",
		"string"  => ":attribute deve contenere un numero di caratteri compreso tra :min - :max.",
	),
	"confirmed"      => ":attribute la conferma non corrisponde.",
	"different"      => ":attribute e :other devono essere differenti.",
	"email"          => ":attribute il formato non è valido.",
	"exists"         => "l'attributo :attribute selezionato non è valido.",
	"image"          => ":attribute deve essere un'immagine.",
	"in"             => "l'attributo :attribute non è valido.",
	"integer"        => "The :attribute must be an integer.",
	"ip"             => "The :attribute must be a valid IP address.",
	"match"          => "The :attribute format is invalid.",
	"max"            => array(
		"numeric" => "The :attribute must be less than :max.",
		"file"    => "The :attribute must be less than :max kilobytes.",
		"string"  => "The :attribute must be less than :max characters.",
	),
	"mimes"          => "The :attribute must be a file of type: :values.",
	"min"            => array(
		"numeric" => "The :attribute must be at least :min.",
		"file"    => "The :attribute must be at least :min kilobytes.",
		"string"  => "The :attribute must be at least :min characters.",
	),
	"not_in"         => "The selected :attribute is invalid.",
	"numeric"        => "The :attribute must be a number.",
	"required"       => "The :attribute field is required.",
	"same"           => "The :attribute and :other must match.",
	"size"           => array(
		"numeric" => "The :attribute must be :size.",
		"file"    => "The :attribute must be :size kilobyte.",
		"string"  => "The :attribute must be :size characters.",
	),
	"unique"         => "The :attribute has already been taken.",
	"url"            => "The :attribute format is invalid.",

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
