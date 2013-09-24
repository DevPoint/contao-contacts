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

class ContactInsertTags extends \Frontend {

	protected function replaceInsertTags($strBuffer, $blnCache=true)
	{
		$result = false;
		$arrSplit = explode('::', $strBuffer);
		if ($arrSplit[0] == 'contact' && 2 <= count($arrSplit))
		{
			$arrParams = explode(':', $arrSplit[1]);
			switch ($arrParams[0])
			{
				case 'email_link':
				{
					$aliasId = (2 <= count($arrParams)) ? $arrParams[1] : '@default';
					$objContact = Contact::getContactDetails($aliasId);
					if (null != $objContact && !empty($objContact->email_href))
					{
						$result = str_replace(array('{href}','{title}','{value}'),
											array($objContact->email_href, $objContact->name, $objContact->email),
											$GLOBALS['TL_LANG']['MSC']['tl_contacts']['shortTemplates']['email_link']);
					}
					break;
				}
				case 'geo_dec_lat':
				case 'geo_dec_lng':
				case 'geo_dms_lat':
				case 'geo_dms_lng':
				case 'geo_mindec_lat':
				case 'geo_mindec_lng':
				{
					$aliasId = (2 <= count($arrParams)) ? $arrParams[1] : '@default';
					$objContact = Contact::getContactDetails($aliasId);
					if (null != $objContact && !empty($objContact->geoCoords))
					{
						$geoCoords = explode(',', $objContact->geoCoords);
						if (is_array($geoCoords) && 2 <= count($geoCoords))
						{
							$lat = trim($geoCoords[0]);
							$lng = trim($geoCoords[1]);
							switch ($arrParams[0])
							{
								case 'geo_dec_lat':
									$result = $lat;
									break;
								case 'geo_dec_lng':
									$result = $lng;
									break;
								case 'geo_dms_lat':
									$result = Contact::parseGeoCoordDMS($lat, array('N','S'));
									break;
								case 'geo_dms_lng':
									$result = Contact::parseGeoCoordDMS($lng, array('E','W'));
									break;
								case 'geo_mindec_lat':
									$result = Contact::parseGeoCoordMinDec($lat, array('N','S'));
									break;
								case 'geo_mindec_lng':
									$result = Contact::parseGeoCoordMinDec($lng, array('E','W'));
									break;
							}
						}
					}
					break;
				}
				default:
				{
					$aliasId = (2 <= count($arrParams)) ? $arrParams[1] : '@default';
					$objContact = Contact::getContactDetails($aliasId);
					if (null !== $objContact && !empty($objContact->{$arrParams[0]}))
					{
						$result = $objContact->{$arrParams[0]};
					}
					break;
				}
			}
		}
		return $result;
	}
}
