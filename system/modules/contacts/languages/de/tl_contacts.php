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
 * @package     Contacts
 * @copyright   DevPoint | Wilfried Reiter 2013
 * @author      DevPoint | Wilfried Reiter <wilfried.reiter@devpoint.at>
 * @license		LGPL
 */

$GLOBALS['TL_LANG']['tl_contacts'] = array(
	//---Labels-------------------------------------//
	'title'		=>	array('Titel', 'Bitte geben Sie den Titel für diesen Eintrag ein.'),
	'alias'		=>	array('Kontaktalias', 'Der Nachrichtenalias ist eine eindeutige Referenz, die anstelle der numerischen Kontakt-ID aufgerufen werden kann.'),
	'name'		=>	array('Name', 'Bitte geben Sie einen Namen ein.'),
	'name2'		=>	array('Namenszusatz', 'Hier können Sie den Namen um einen Zusatz erweitern.'),
	'longName'	=>	array('Vollständiger Name', 'Bitte geben Sie den vollständigen Namen ein.'),
	'street'	=>	array('Straße', 'Bitte geben Sie den Straßennamen und die Hausnummer ein.'),
	'postal'	=>	array('Postleitzahl', 'Bitte geben Sie die Postleitzahl ein.'),
	'city'		=>	array('Ort', 'Bitte geben Sie den Namen des Ortes ein.'),
	'state'		=>	array('Bundesland', 'Bitte geben Sie den Namen des Bundesland ein.'),
	'countryCode'	=>	array('Land', 'Bitte wählen Sie ein Land.'),
	'geoCoords'	=> 	array('Geo-Koordinaten', 'Geben Sie hier die Geo-Koordinaten dieser Adresse ein (z.B. 47.377256,13.668912). Falls Sie das Feld leer lassen, wird versucht die Koordinaten aus den Adressdaten zu ermitteln.'),
	'addImage'	=>	array('Ein Bild hinzufügen', 'Dem Kontakt ein Bild hinzufügen.'),
	'singleSRC'	=>	array('Quelldatei', 'Bitte wählen Sie eine Datei oder einen Ordner aus der Dateiübersicht.'),
	'alt'		=>	array('Alternativer Bildtext', 'Hier können Sie einen alternativen Text für das Bild eingeben (<em>alt</em>-Attribut).'),
	'size'		=>	array('Bildbreite und Bildhöhe', 'Hier können Sie die Abmessungen des Bildes und den Skalierungsmodus festlegen.'),
	'phone'		=>	array('Telefonnummer', 'Bitte geben Sie die Telefonnummer ein.'),
	'mobile'	=>	array('Handynummer', 'Bitte geben Sie die Handynummer ein.'),
	'fax'		=>	array('Faxnummer', 'Bitte geben Sie die Faxnummer ein.'),
	'email'		=>	array('E-Mail-Adresse', 'Bitte geben Sie eine gültige E-Mail-Adresse ein.'),
	'networks'	=>	array('Soziale Netzwerke', 'Links auf Soziale Netzwerke hinzufügen oder bearbeiten'),
	'new'		=>	array('Neuen Kontakt', 'Einen neuen Kontakt anlegen'),
	'show'		=>	array('Kontaktdetails', 'Details des Kontaktes ID %s anzeigen'),
	'edit'		=>	array('Kontakt bearbeiten', 'Kontakt ID %s bearbeiten'),
	'copy'		=>	array('Kontakt duplizieren', 'Kontakt ID %s duplizieren'),
	'delete'	=>	array('Kontakt löschen', 'Kontakt ID %s löschen'),
	'toggle'	=>	array('Kontakt aktivieren/deaktivieren', 'Kontakt ID %s aktivieren/deaktivieren'),
	//---Networks-Selection-Labels------------------//
	'networkOptions'	=>	'Netzwerk-Name',
	'networkUserID'		=>	'Benutzer-Id für Netzwerk',
	//---Legends------------------------------------//
	'titleLegend'	=> 'Titel',
	'contactLegend'	=> 'Kontakt-Addresse verwalten',
	'imageLegend' 	=> 'Bild-Einstellungen',
	'phoneLegend' 	=> 'Telefonnummern und Emailadresse',
	'networksLegend'	=>	'Links auf soziale Netzwerke verwalten',
	//---Meldungen----------------------------------//
	'references'	=> array(
		'noCurl'		=>	'Koordinaten nicht ermittelbar - kein CURL vorhanden',
		'noCoords'		=>	'Koordinaten nicht ermittelbar'),
	//----------------------------------------------//
);

