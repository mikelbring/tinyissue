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

	"accepted"       => ":attribute должен быть принят.",
	"active_url"     => ":attribute не валидный.",
	"after"          => ":attribute должен быть датой после :date.",
	"alpha"          => ":attribute может содержать только буквы.",
	"alpha_dash"     => ":attribute может содержать только буквы, числа, и тире.",
	"alpha_num"      => ":attribute может содержать только буквы и числа.",
	"before"         => ":attribute должен быть датой до :date.",
	"between"        => array(
		"numeric" => ":attribute должен быть между :min - :max.",
		"file"    => ":attribute должен быть между :min - :max Кб.",
		"string"  => ":attribute должен быть между :min - :max символов.",
	),
	"confirmed"      => "Подтверждение :attribute не совпадают.",
	"different"      => ":attribute и :other должны быть разными.",
	"email"          => "Формат :attribute неверный.",
	"exists"         => "Выбранный :attribute недействительный.",
	"image"          => ":attribute должен быть изображением.",
	"in"             => "Выбранный :attribute недействительный.",
	"integer"        => ":attribute должен быть целым числом.",
	"ip"             => ":attribute должен быть валидным IP-адресом.",
	"match"          => "Формат :attribute неверный.",
	"max"            => array(
		"numeric" => ":attribute должен быть меньше, чем :max.",
		"file"    => ":attribute должен быть меньше, чем :max kilobytes.",
		"string"  => ":attribute должен быть меньше, чем :max characters.",
	),
	"mimes"          => ":attribute должен быть файлом типа: :values.",
	"min"            => array(
		"numeric" => ":attribute должен быть не менее :min.",
		"file"    => ":attribute должен быть не менее :min kilobytes.",
		"string"  => ":attribute должен быть не менее :min characters.",
	),
	"not_in"         => "Выбранный :attribute неверный.",
	"numeric"        => ":attribute должен быть числом.",
	"required"       => ":attribute обязателен.",
	"same"           => ":attribute и :other должны быть равными.",
	"size"           => array(
		"numeric" => ":attribute должен быть равен :size.",
		"file"    => ":attribute должен быть равен :size Кб.",
		"string"  => ":attribute должен быть равен :size символов.",
	),
	"unique"         => ":attribute уже принят.",
	"url"            => "Формат :attribute неверный.",

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