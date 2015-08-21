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

abstract class ModuleBaseContact extends \Module {

	/**
	 * Enqueue Google Maps API to loaded scripts
	 * @return void
	 */
	protected function enqueueGoogleMapsScript()
	{
		$googleMapsUrl = 'http'.($this->Environment->ssl ? 's' : '').'://maps.google.com/maps/api/js?v=3.exp&amp;sensor=false';
		$GLOBALS['TL_JAVASCRIPT'][] = $googleMapsUrl;
	//	$matches = array_filter($GLOBALS['TL_JAVASCRIPT'], function($var) use ($searchword) 
	//	{ 
	//		return preg_match("/\bmaps.google.com/maps/api/js?v=3.exp\b/i", $var); 
	//	});
	//	if (empty($matches))
	//	{
	//	}
	}

	protected function generateWildcard($wildcardStr)
	{
		$objTemplate = new \BackendTemplate('be_wildcard');
		$objTemplate->wildcard = $wildcardStr;
		$objTemplate->title = $this->headline;
		$objTemplate->id = $this->id;
		$objTemplate->link = $this->name;
		$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
		return $objTemplate->parse();
	}

	protected function generateEmpty()
	{
		global $objPage;
		$objPage->noSearch = 1;
		$objPage->cache = 0;
		return '';
	}

	/**
	 * Generate map
	 * @param $objContact mixed
	 * @param $strTemplate string
	 * @param $arrOptions array
	 * @return string
	 */
	public function generateContactMap($objContacts, $strTemplate, array $arrOptions = array()) 
	{
		// create markers and map center
		$contactCount = 0;
		$centerLat = 0;
		$centerLng = 0;
		$mapMarkers = array();
		while ($objContacts->next())
		{
			$objContact = \Contact::getContactDetails($objContacts, $arrOptions);
			$mapMarkers[] = \Contact::buildContactMapMarker($objContact);
			if (!empty($objContact->geoCoords))
			{
				$arrCoords = explode(',', $objContact->geoCoords);
				$centerLat += trim($arrCoords[0]);
				$centerLng += trim($arrCoords[1]);
				$contactCount += 1;
			}
		}
		$objContacts->reset();

		// parse map template
		$mapTemplate = new \FrontendTemplate($strTemplate);
		$mapTemplate->id = 'm' . $this->objModel->id;
		$mapTemplate->markers = $mapMarkers;
		$mapTemplate->zoom = $this->contacts_mapZoom;
		$mapTemplate->mapAspect = $this->contacts_mapAspect;
		$mapTemplate->addInfoWindow = true;
		$mapTemplate->lat = $centerLat / $contactCount;
		$mapTemplate->lng = $centerLng / $contactCount;
		$mapTemplate = \Contact::getContactMapDetails($mapTemplate);
		return $mapTemplate->parse();
	}
}
