<?php

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Contact' 			=>	'system/modules/contacts/classes/Contact.php',
	'ContactModel' 		=>	'system/modules/contacts/models/ContactModel.php',
	'ModuleBaseContact'		=>	'system/modules/contacts/modules/ModuleBaseContact.php',
	'ModuleContact' 		=>	'system/modules/contacts/modules/ModuleContact.php',
	'ModuleContactList'		=>	'system/modules/contacts/modules/ModuleContactList.php',
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_contact'			=> 'system/modules/contacts/templates',
	'contact_basic'			=> 'system/modules/contacts/templates',
));
