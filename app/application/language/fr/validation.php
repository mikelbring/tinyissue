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

	"accepted"       => "L`attribut doit être accepté.",
	"active_url"     => "L`attribut n'est pas une URL valide.",
	"after"          => "L`attribut doit être une date après :date.",
	"alpha"          => "L`attribut peut seulement contenir des lettres.",
	"alpha_dash"     => "L`attribut peut seulement contenir des lettres, des nombres et des tirets.",
	"alpha_num"      => "L`attribut peut seulement contenir des lettres et des nombres.",
	"before"         => "L`attribut doit être une date avant :date.",
	"between"        => array(
		"numeric" => "L`attribut doit être entre :min - :max.",
		"file"    => "L`attribut doit être entre :min - :max kilobytes.",
		"string"  => "L`attribut doit être entre :min - :max caractères.",
	),
	"confirmed"      => "L`attribut de confirmation ne correspond pas.",
	"different"      => "L`attribut et :other doivent être différents.",
	"email"          => "Le format de :attribute est invalide.",
	"exists"         => "L`attribut sélectionné est invalide.",
	"image"          => "L`attribut doit être une image.",
	"in"             => "L`attribut sélectionné est invalide.",
	"integer"        => "L`attribut doit être un entier.",
	"ip"             => "L`attribut doit être une adresse IP valide.",
	"match"          => "Le format de :attribute est invalide.",
	"max"            => array(
		"numeric" => "L`attribut doit être inférieur à :max.",
		"file"    => "L`attribut doit être inférieur à :max kilobytes.",
		"string"  => "L`attribut doit être inférieur à :max caractères.",
	),
	"mimes"          => "L`attribut doit être un fichie de type : :values.",
	"min"            => array(
		"numeric" => "L`attribut doit être supérieur à :min.",
		"file"    => "L`attribut doit être supérieur à :min kilobytes.",
		"string"  => "L`attribut doit être supérieur à :min caractères.",
	),
	"not_in"         => "L`attribut sélectionné est invalide.",
	"numeric"        => "L`attribut doit être un nombre.",
	"required"       => "L`attribut est un champ requis.",
	"same"           => "L`attribut et :other doivent être identique.",
	"size"           => array(
		"numeric" => "L`attribut doit être :size.",
		"file"    => "L`attribut doit être :size kilobyte.",
		"string"  => "L`attribut doit être de :size caractères.",
	),
	"unique"         => "L`attribut a déjà été pris.",
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
