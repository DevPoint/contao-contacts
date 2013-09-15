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
 */
$GLOBALS['FE_MOD']['contacts'] = array
(
    'contact' 		=> 'ModuleContact',
    'contact_list'	=> 'ModuleContactList',
);


/**
 * Contact module settings
 */
$GLOBALS['TL_CONTACTS'] = array
(
	'fieldOptions' 		=> array(
		'title',
		'name','name2','street','postal','city',
		'phone','mobile','fax','email','networks'),
	'fieldExcludes' 	=> array('title'),
	'networkOptions' 	=> array(
		'Facebook','Twitter','Pinterest','Xing','LinkedIn','GitHub'),
	'networkUrls' 		=> array(
		'_default'			=> 'http://www.%s.com/%s', 
		'Facebook'			=> 'https://www.facebook.com/%s',
		'Twitter'			=> 'https://twitter.com/%s',
		'Pinterest'			=> 'https://pinterest.com/%s',
		'Xing'				=> 'http://www.xing.com/profile/%s',
		'GitHub'			=> 'https://github.com/%s',
		'FotoCommunity'		=> 'http://www.fotocommunity.de/fotograf/%s'),
);


/**
 * Hooks
 */

 
