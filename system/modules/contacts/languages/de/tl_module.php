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

$GLOBALS['TL_LANG']['tl_module']['contacts_multiSRC'] = array('Kontakteinträge', 'Bitte wählen Sie einen oder mehere Kontakteinträge.');
$GLOBALS['TL_LANG']['tl_module']['contacts_singleSRC'] = array('Kontakteintrag','Bitte wählen Sie einen Kontakteintrag.');
$GLOBALS['TL_LANG']['tl_module']['contacts_template'] = array('Kontakttemplate','Hier können Sie das Kontakttemplate auswählen.');
$GLOBALS['TL_LANG']['tl_module']['contacts_addFieldsFilter'] = array('Nur ausgewählte Felder','Erlaubt festzulegen, welche Felder angezeigt werden.');
$GLOBALS['TL_LANG']['tl_module']['contacts_fieldsFilter'] = array('Felder auswählen','Wählen Sie aus, welche Felder Sie angezeigt haben wollen.');
$GLOBALS['TL_LANG']['tl_module']['contacts_networksFilter'] = array('Soziale Netzwerke auswählen','Wählen Sie aus, welche Soziale Netzwerke Sie angezeigt haben wollen.');
$GLOBALS['TL_LANG']['tl_module']['contacts_addNetworksFilter'] = array('Nur ausgewählte Soziale Netzwerke','Erlaubt festzulegen, welche Soziale Netzwerke angezeigt werden.');
$GLOBALS['TL_LANG']['tl_module']['contacts_extendedSettings'] = array('Erweiterte Darstellungseinstellungen','Die Schalter ermöglichen Ihnen optionale Einstellungen zur Ausgabesteuerung.');
$GLOBALS['TL_LANG']['tl_module']['contacts_addMap'] = array('Karte anzeigen','Aktivieren Sie die Einblendung einer Karte.');
$GLOBALS['TL_LANG']['tl_module']['contacts_mapZoom'] = array('Zoom-Faktor für Karte','Bitte wählen Sie einen Zoom-Faktor für die Karteneinblendung.');
$GLOBALS['TL_LANG']['tl_module']['contacts_mapAspect'] = array('Seitenverhältnis für Karte','Bestimmen Sie das Breiten-Höhenverhältnis für die Karteneinblendung.');
$GLOBALS['TL_LANG']['tl_module']['contacts_fieldsFilterOptions'] = array(
	'title'		=> 'Title',
	'name' 		=> 'Name',
	'name2'		=> 'Namenszusatz',
	'longName'	=> 'Vollständiger Name',
	'street'	=> 'Straße',
	'postal'	=> 'Postleitzahl',
	'city'		=> 'Ort',
	'state'		=> 'Bundesland',
	'countryCode'	=> 'Land',
	'singleSRC'	=> 'Bild',
	'phone'		=> 'Telefonnummer',
	'mobile'	=> 'Handynummer',
	'fax'		=> 'Faxnummer',
	'email'		=> 'E-Mail-Adresse',
	'networks'	=> 'Soziale Netzwerke');
$GLOBALS['TL_LANG']['tl_module']['contacts_extendedSettingsOptions'] = array(
	'short_labels'	=> 'Kurzform für Bezeichner verwenden',
	'phone_nolink'	=> 'Keine Links für Telefonnummern erzeugen',
	'email_nolabel'	=> 'Feld \'E-Mail\' ohne Bezeichner darstellen',
	'weblink_nolabel'	=> 'Feld \'Webseite\' ohne Bezeichner darstellen',
	'gmap_enable'	=> 'Karte einblenden');
$GLOBALS['TL_LANG']['tl_module']['contacts_mapAspectOptions'] = array(
	'2_1'		=> '2:1',
	'16_9'		=> '16:9',
	'16_10'		=> '16:10',
	'4_3'		=> '4:3',
	'5_4'		=> '5:4',
	'1_1'		=> '1:1');
$GLOBALS['TL_LANG']['tl_module']['contacts_legend'] = 'Kontakt Einstellungen';
$GLOBALS['TL_LANG']['tl_module']['contacts_fieldsFilter_legend'] = 'Detaileinstellungen für die Anzeige von Kontakten';
$GLOBALS['TL_LANG']['tl_module']['contacts_maps_legend'] = 'Karteneinstellungen';
