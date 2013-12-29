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

	"accepted"       => "Le :attribute doit être accepté.",
	"active_url"     => "Le :attribute n'est pas une URL valide.",
	"after"          => "Le :attribute doit être une date après :date.",
	"alpha"          => "Le :attribute peut seulement contenir des lettres.",
	"alpha_dash"     => "Le :attribute peut seulement contenir des lettres, des nombres et des tirets.",
	"alpha_num"      => "Le :attribute peut seulement contenir des lettres et des nombres.",
	"before"         => "Le :attribute doit être une date avant :date.",
	"between"        => array(
		"numeric" => "Le :attribute doit être entre :min - :max.",
		"file"    => "Le :attribute doit être entre :min - :max kilobytes.",
		"string"  => "Le :attribute doit être entre :min - :max caractères.",
	),
	"confirmed"      => "Le :attribute de confirmation ne correspond pas.",
	"different"      => "Le :attribute et :other doivent être différents.",
	"email"          => "Le format de :attribute est invalide.",
	"exists"         => "Le :attribute sélectionné est invalide.",
	"image"          => "Le :attribute doit être une image.",
	"in"             => "Le :attribute sélectionné est invalide.",
	"integer"        => "Le :attribute doit être un entier.",
	"ip"             => "Le :attribute doit être une adresse IP valide.",
	"match"          => "Le format de :attribute est invalide.",
	"max"            => array(
		"numeric" => "Le :attribute doit être inférieur à :max.",
		"file"    => "Le :attribute doit être inférieur à :max kilobytes.",
		"string"  => "Le :attribute doit être inférieur à :max caractères.",
	),
	"mimes"          => "Le :attribute doit être un fichie de type : :values.",
	"min"            => array(
		"numeric" => "Le :attribute doit être supérieur à :min.",
		"file"    => "Le :attribute doit être supérieur à :min kilobytes.",
		"string"  => "Le :attribute doit être supérieur à :min caractères.",
	),
	"not_in"         => "Le :attribute sélectionné est invalide.",
	"numeric"        => "Le :attribute doit être un nombre.",
	"required"       => "Le :attribute est un champ requis.",
	"same"           => "Le :attribute et :other doivent être identique.",
	"size"           => array(
		"numeric" => "Le :attribute doit être :size.",
		"file"    => "Le :attribute doit être :size kilobyte.",
		"string"  => "Le :attribute doit être de :size caractères.",
	),
	"unique"         => "Le :attribute a déjà été pris.",
	"url"            => "Le format de :attribute est invalide.",

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
