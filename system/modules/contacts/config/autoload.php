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
	'Contact' 				=>	'system/modules/contacts/classes/Contact.php',
	'ContactTags'			=>	'system/modules/contacts/classes/ContactTags.php',
	'ContactsModel' 		=>	'system/modules/contacts/models/ContactsModel.php',
	'ModuleBaseContact' 	=>	'system/modules/contacts/modules/ModuleBaseContact.php',
	'ModuleContact' 		=>	'system/modules/contacts/modules/ModuleContact.php',
	'ModuleContactGMaps'	=>	'system/modules/contacts/modules/ModuleContactGMaps.php',
	'ModuleContactList'		=>	'system/modules/contacts/modules/ModuleContactList.php',
	'ContentContact' 		=>	'system/modules/contacts/elements/ContentContact.php',
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_contact'		=> 'system/modules/contacts/templates',
	'ce_contact'		=> 'system/modules/contacts/templates',
	'contact_basic'		=> 'system/modules/contacts/templates',
	'contact_networks'	=> 'system/modules/contacts/templates',
	'contact_gmaps'		=> 'system/modules/contacts/templates',
	'gmaps_simple'		=> 'system/modules/contacts/templates',
));
