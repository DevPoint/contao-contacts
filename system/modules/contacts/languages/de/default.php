<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @package    	Contacts
 * @copyright  	DevPoint | Wilfried Reiter 2013
 * @author     	DevPoint | Wilfried Reiter <wilfried.reiter@devpoint.at>
 * @license		LGPL
 */


/**
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['CTE']['contact'] = array('Kontakt','Element zur Anzeige von Kontaktdaten.');


/**
 * Common module contact translations
 */
$GLOBALS['TL_LANG']['MSC']['tl_contacts'] = array(
	'networkChannels' => array(
		'Facebook'	=> 'Facebook',
		'Twitter'	=> 'Twitter'),
	'fieldLabels'	=> array(
		'phone'		=>	'Telefon: ',
		'mobile'	=>	'Mobil: ',
		'fax'		=>	'Fax: ',
		'email'		=>	'E-Mail: ',
		'weblink'	=>	'Webseite: '),
	'fieldLabels_short'	=> array(
		'phone'		=>	'Tel.: ',
		'weblink'	=>	'Web: '),
	'shortTemplates'	=> array(
		'email_link'	=>	'<a href="{href}" title="{title}">{value}</a>',
		'external_link'	=>	'<a href="{href}" title="{title}" target="_blank">{value}</a>',
		'geo_mindec'	=>  '{degrees}° {minutes} {direction}',
		'geo_dms'		=>  '{degrees}° {minutes}\' {seconds}\'\' {direction}')
);
