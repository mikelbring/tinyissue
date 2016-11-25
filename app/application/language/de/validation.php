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

	"accepted"       => ":attribute muss akzeptiert werden.",
	"active_url"     => ":attribute ist keine gültige URL.",
	"after"          => ":attribute muss ein Datum nach dem :date sein.",
	"alpha"          => ":attribute darf nur Buchstaben beinhalten.",
	"alpha_dash"     => ":attribute darf nur Buchstaben, Ziffern und Bindestriche beinhalten.",
	"alpha_num"      => ":attribute darf nur Buchstaben und Ziffern beinhalten.",
	"before"         => ":attribute muss ein Datum vor dem :date sein.",
	"between"        => array(
		"numeric" => ":attribute muss zwischen :min und :max liegen.",
		"file"    => ":attribute muss zwischen :min und :max kB groß sein.",
		"string"  => ":attribute muss zwischen :min und :max Zeichen umfassen.",
	),
	"confirmed"      => "Die Bestätigung von :attribute stimmt nicht überein.",
	"different"      => ":attribute und :other müssen unterschiedlich sein.",
	"email"          => "Das Format von :attribute ist ungültig.",
	"exists"         => "Die Auswahl von :attribute ist ungültig.",
	"image"          => ":attribute muss ein Bild sein.",
	"in"             => "Die Auswahl von :attribute ist ungültig.",
	"integer"        => ":attribute muss eine Zahl sein.",
	"ip"             => ":attribute muss eine gültige IP-Adresse sein.",
	"match"          => "Das Format von :attribute ist ungültig.",
	"max"            => array(
		"numeric" => ":attribute muss kleiner als :max sein.",
		"file"    => ":attribute muss kleiner als :max kilobytes sein.",
		"string"  => ":attribute muss weniger als :max Zeichen umfassen.",
	),
	"mimes"          => ":attribute muss vom Typ :values sein.",
	"min"            => array(
		"numeric" => ":attribute muss größer als :min sein.",
		"file"    => ":attribute muss größer als :min kilobytes sein.",
		"string"  => ":attribute muss größer als :min Zeichen sein.",
	),
	"not_in"         => "Die Auswahl von :attribute ist ungültig.",
	"numeric"        => ":attribute muss eine Zahl sein.",
	"required"       => ":attribute ist ein Pflichtfeld und muss ausgefüllt werden.",
	"same"           => ":attribute und :other müssen übereinstimmen.",
	"size"           => array(
		"numeric" => ":attribute muss :size sein.",
		"file"    => ":attribute muss :size kilobyte haben.",
		"string"  => ":attribute muss :size Zeichen lang sein.",
	),
	"unique"         => ":attribute ist bereits in Verwendung.",
	"url"            => "Das Format von :attribute ist ungültig.",

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