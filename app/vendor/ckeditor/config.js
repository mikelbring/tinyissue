/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.extraPlugins = 'horizontalrule,language,linkayt',
	config.removeButtons = 'Underline,Subscript,Superscript';
	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';
	config.filebrowserImageBrowseUrl = '<?php echo require path('public'); ?>app/vendor/ckeditor/ckeditor_ChoisirImage.php', 
	config.filebrowserImageUploadUrl = '<?php echo require path('public'); ?>app/vendor/ckeditor/ckeditor_RecevoirImage.php',
	config.language_list =[ 'fr-ca:French:Canada', 'en:English', 'es:Spanish' ],
	config.protectedSource.push( /<\?[\s\S]*?\?>/g ),
	config.scayt_autoStartup = true,
	config.scayt_ignoreDomainNames = true,
	config.scayt_multiLanguageMode = true,
	config.scayt_multiLanguageStyles = {'fr': 'color: yellow', 'en': 'color: red', 'es': 'color: purple'},
	config.scayt_sLang = 'fr_CA',
	config.shiftEnterMode = CKEDITOR.ENTER_P,
	config.wsc_lang = 'fr_CA',

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	config.entities = false;
	config.entities_latin = false;
	config.htmlEncodeOutput = false;
};
