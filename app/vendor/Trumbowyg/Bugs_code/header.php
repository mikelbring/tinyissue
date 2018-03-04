<?php 
	$wysiwyg = Config::get('application.editor');
	 if (trim($wysiwyg['BasePage']) != '') { 
	 	if (substr($wysiwyg['BasePage'], -2) == 'js') { 
	 		echo '
	 			<link href="'.URL::base()."/".$wysiwyg['directory'].'/dist/ui/trumbowyg.min.css" media="all" type="text/css" rel="stylesheet"/>
 				<link href="'.URL::base()."/".$wysiwyg['directory'].'/plugins/colors/ui/trumbowyg.colors.css" media="all" type="text/css" rel="stylesheet"/>	
 				<script src="'.URL::base()."/".$wysiwyg['directory'].'/plugins/colors/trumbowyg.colors.min.js"></script>
 			';
		} 
	} 
?>