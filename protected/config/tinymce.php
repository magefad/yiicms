<?php
return array(
	'language'           => 'ru',
	'fileManager' => array(
		'class'          => 'ext.elFinder.TinyMceElFinder', 'connectorRoute' => 'elfinder/connector',
	),
	'compressorRoute' => 'tinyMce/compressor',
	#'spellcheckerRoute' => 'tinyMce/spellchecker',
	'settings'           => array(
		'doctype'                          => '<!DOCTYPE html>',
		'extended_valid_elements'          => 'iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]',
		'body_class'                       => 'container',
		'width'                            => '100%',
		'plugins'                          => 'autolink,lists,pagebreak,layer,table,save,advhr,advimage,advlink,inlinepopups,insertdatetime,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist',
		'theme_advanced_buttons1'          => "save,|,|,undo,redo,|,|,pastetext,pasteword,|,|,attribs,styleprops,charmap,|,|,removeformat,visualaid,|,|,|,hr,advhr,|,|,fullscreen,code,|",
		'theme_advanced_buttons2'          => "styleselect,formatselect,fontselect,fontsizeselect,|,tablecontrols,|",
		'theme_advanced_buttons3'          => "bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup,|,media,|,forecolor,backcolor,|,insertdate,inserttime,|,preview,|,spellchecker",
		#'theme_advanced_buttons4'         => "insertlayer,moveforward,movebackward,absolute,|,cite,abbr,acronym,del,ins|,visualchars,nonbreaking,template,pagebreak",
		'theme_advanced_toolbar_location'  => "top",
		'theme_advanced_toolbar_align'     => "left",
		'external_link_list_url'           => '/page/MceListUrl',
		'relative_urls'                    => true,
	),
)
?>