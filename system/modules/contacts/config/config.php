<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package    Contacts
 * @copyright  DevPoint | Wilfried Reiter 2013
 * @author     DevPoint | Wilfried Reiter <wilfried.reiter@devpoint.at>
 * @link       http://contao.org
 * @license    MIT
 */


/**
 * Back end modules
 */
array_insert($GLOBALS['BE_MOD']['content'], 1, array
(
	'contacts' => array(
		'tables'	=> array('tl_contacts'),
		'icon'		=> '/system/modules/contacts/assets/icon.gif'
	)
));


/**
 * Front end modules
 *
$GLOBALS['FE_MOD']['contacts'] = array
(
    'contacts' => 'ModuleContacts',
    'contacts_essential' => 'ModuleContactsEssential',
    'contacts_sociallinks' => 'ModuleContactsSocialLinks'
);*/


/**
 * Hooks
 */

 
