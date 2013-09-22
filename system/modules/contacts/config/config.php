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
    'contact_gmaps'	=> 'ModuleContactGMaps',
    'contact_list'	=> 'ModuleContactList',
);


/**
 * Contact module settings
 */
$GLOBALS['TL_CONTACTS'] = array
(
	'fieldOptions' 		=> array(
		'title','name','name2','street','postal','city',
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
	'mapOptions'		=> array(
		'defaultZoom'		=> 6,
		'maxScreenAspect'	=> 0.9,
		'maxAspect'			=> 1.333,
		'autoHeight'		=> array(
			'2_1' 				=> array('aspect'=>0.5, 'min'=>256),
			'16_9' 				=> array('aspect'=>0.5625, 'min'=>288),
			'16_10' 			=> array('aspect'=>0.625, 'min'=>288),
			'4_3' 				=> array('aspect'=>0.75, 'min'=>304),
			'5_4' 				=> array('aspect'=>0.8, 'min'=>304),
			'1_1' 				=> array('aspect'=>1.0, 'min'=>304))),
);

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('ContactInsertTags','replaceInsertTags'); 

 
