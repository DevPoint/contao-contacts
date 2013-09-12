<?php

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'ContactModel' 		=>	'system/modules/contacts/models/ContactModel.php',
	'ModuleContact' 	=>	'system/modules/contacts/modules/ModuleContact.php',
	'ModuleContactSingle' 	=>	'system/modules/contacts/modules/ModuleContactSingle.php',
	'ModuleContactList' 	=>	'system/modules/contacts/modules/ModuleContactList.php',
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_contact_single'	=> 'system/modules/contacts/templates',
	'contact_basic'			=> 'system/modules/contacts/templates',
));
