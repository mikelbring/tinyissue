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
	"integer"        => "L'attributo :attribute deve essere un intero.",
	"ip"             => "L'attributo :attribute deve essere un indirizzo IP valido.",
	"match"          => "Il formato dell'attributo :attribute non è valido.",
	"max"            => array(
		"numeric" => "L'attributo :attribute deve essere meno di :max.",
		"file"    => "L'attributo :attribute deve essere meno di :max kilobytes.",
		"string"  => "L'attributo :attribute deve essere meno di :max caratteri.",
	),
	"mimes"          => "L'attributo :attribute deve essere un file di tipo: :values.",
	"min"            => array(
		"numeric" => "L'attributo :attribute deve essere almeno :min.",
		"file"    => "L'attributo :attribute deve essere almeno :min kilobytes.",
		"string"  => "L'attributo :attribute deve essere almeno :min caratteri.",
	),
	"not_in"         => "L'attributo selezionato :attribute non è valido.",
	"numeric"        => "L'attributo :attribute deve essere un numero.",
	"required"       => "Il campo dell'attributo :attribute è richiesto.",
	"same"           => "L'attributo :attribute e :other devono corrispondere.",
	"size"           => array(
		"numeric" => "L'attributo :attribute deve essere :size.",
		"file"    => "L'attributo :attribute deve essere :size kilobyte.",
		"string"  => "L'attributo :attribute deve essere :size caratteri.",
	),
	"unique"         => "L'attributo :attribute è già stato usato.",
	"url"            => "Il formato dell'attributo :attribute non è valido.",

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
