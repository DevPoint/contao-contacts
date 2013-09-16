<?php

/**
 * Register the classes
 */
ClassLoader::addNamespaces(array
(
));

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Contact' 			=>	'system/modules/contacts/classes/Contact.php',
	'ModuleContact' 		=>	'system/modules/contacts/modules/ModuleContact.php',
	'ModuleContactList'		=>	'system/modules/contacts/modules/ModuleContactList.php',
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_contact'		=> 'system/modules/contacts/templates',
	'contact_basic'		=> 'system/modules/contacts/templates',
	'contact_links'			=> 'system/modules/contacts/templates',
));
