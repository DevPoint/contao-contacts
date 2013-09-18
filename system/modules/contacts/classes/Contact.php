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
 * @package    Contacts
 * @copyright  DevPoint | Wilfried Reiter 2013
 * @author     DevPoint | Wilfried Reiter <wilfried.reiter@devpoint.at>
 */

class Contact extends \Frontend {

	/**
	 * Check if a protected archive is visible
	 * @param $archiveGroups (serialized)
	 * @param $user FrontendUser
	 * @return array
	 *
	 * Remark: This function is the essence of the
	 * <Contao\Events::sortOutProtected> and
	 * <Contao\ModuleNews::sortOutProtected> functions
	 */
	static public function checkProtectedArchiveVisible($archiveGroups, $user)
	{
		if (BE_USER_LOGGED_IN)
		{
			return true;
		}

		if (!FE_USER_LOGGED_IN)
		{
			return false;
		}

		$groups = deserialize($archiveGroups);

		if (!is_array($groups) || empty($groups) || !count(array_intersect($groups, $user->groups)))
		{
			return false;
		}
		
		return true;
	}

	/**
	 * Remove parenthesis, slashes, dots and spaces
	 * Add 'tel:' to trimmed phone number
	 * @param $phone string
	 * @return string
	 */
	static protected function createPhoneLink($phone)
	{
		$phone = html_entity_decode($phone);
		$phone = preg_replace('/\((.*?)\)|\[(.*?)\]/', '', $phone);
		$phone = str_replace(array("/", "\\", ".", " "), "", $phone);
		return 'tel:' . $phone;
	}
	
	/**
	 * Convert geocoordinate from 
	 * DegDec to DMS format
	 * @param $coord string
	 * @return array[3]
	 */
	static protected function convertGeoCoordToDMS($coord)
	{
		$degrees = floor($coord);
		$minutesSec = ($coord - $degrees) * 60.0;
		$minutes = floor($minutesSec);
		$seconds = ($minutesSec - $minutes) * 60.0;
		return array($degrees, $minutes, $seconds);
	}
	
	/**
	 * Convert geocoordinate from 
	 * DegDec to MinDec format
	 * @param $coord string
	 * @return array[2]
	 */
	static protected function convertGeoCoordToMinDec($coord)
	{
		$degrees = floor($coord);
		$minutes = ($coord - $degrees) * 60.0;
		return array($degrees, $minutes);
	}
	
	/**
	 * Create Filter for fields or networks
	 * as table with index key 
	 * @param $options array
	 * @param $hasFilter boolean
	 * @param $filters array
	 * @param $excludes array
	 * @return string
	 */
	static protected function createOptionsFilterTable(&$options, $hasFilter, &$filters, &$excludes=null)
	{
		$arrFilter = array();
		$filterDefault = true;
		if (is_array($excludes))
		{
			foreach ($excludes as $key)
			{
				$arrFilter[$key] = false;
			}
		}
		if ($hasFilter && is_array($filters))
		{
			foreach ($filters as $key)
			{
				$arrFilter[$key] = true;
			}
			$filterDefault = false;
		}
		foreach ($options as $key)
		{
			if (!isset($arrFilter[$key]))
			{
				$arrFilter[$key] = $filterDefault;
			}
		}
		return $arrFilter;
	}


	/**
	 * Enrich DataRecord by additional 
	 * properties
	 * @param $objContact mixed
	 * @param $arrOptions array
	 * @return data record
	 */
	static public function getContactDetails($objContact, $arrOptions=null)
	{
		// retrieve contact id
		$contactId = (is_object($objContact)) ? $objContact->id : $objContact;
		if (empty($contactId) || (is_numeric($contactId) && $contactId < 1))
		{
			return null;
		}

		// try to locate contact in Cache
		$hasOptions = (is_array($arrOptions) && !empty($arrOptions));
		$strCacheKey = (!$hasOptions) ? (__METHOD__ . '-' . $contactId) : false;
		if (false !== $strCacheKey && \Cache::has($strCacheKey))
		{
			//\System::log("Contact from Cache", "", TL_GENERAL);
			return \Cache::get($strCacheKey);
		}

		// load contact if necessary
		if (!is_object($objContact))
		{
			$db = \Database::getInstance();
			if ('@default' === $contactId)
			{
				$objContact = $db->prepare("SELECT * FROM tl_contacts")
									->limit(1)
									->execute();
			}
			else
			{
				$whereKey = (is_numeric($contactId)) ? 'id' : 'alias';
				$objContact = $db->prepare("SELECT * FROM tl_contacts WHERE {$whereKey}=?")
									->limit(1)
									->execute($contactId);
			}
			if (null === $objContact)
			{
				return null;
			}
		}

		// create boolean array for filterable fields
		$fieldExcludes = ($hasOptions) ? $GLOBALS['TL_CONTACTS']['fieldExcludes'] : null;
		$arrFieldsFilter = self::createOptionsFilterTable(
										$GLOBALS['TL_CONTACTS']['fieldOptions'],
										$arrOptions['addFieldsFilter'], $arrOptions['fieldsFilter'],
										$fieldExcludes);
		
		// apply fields filter to <objContact>
		foreach ($arrFieldsFilter as $field => $enabled)
		{
			if (!$enabled)
			{
				$objContact->{$field} = null;
			}
		}

		// create boolean array for extended settings
		$arrExtendedSettings = array();
		if (is_array($arrOptions['extendedSettings']))
		{
			foreach($arrOptions['extendedSettings'] as $settingKey)
			{
				$arrExtendedSettings[$settingKey] = true;
			}
		}

		// create labels
		$useShortLabels = (true === $arrExtendedSettings['short_labels']);
		$fieldLabelsShort = &$GLOBALS['TL_LANG']['MSC']['tl_contacts']['fieldLabels_short'];
		foreach($GLOBALS['TL_LANG']['MSC']['tl_contacts']['fieldLabels'] as $field => $label)
		{
			if (true !== $arrExtendedSettings[$field.'_nolabel'])
			{
				if ($useShortLabels && isset($fieldLabelsShort[$field]))
				{
					$label = $fieldLabelsShort[$field];	
				} 
				$objContact->{$field.'_label'} = $label;
			}
		}

		// create links addresses
		if (true !== $arrExtendedSettings['phone_nolink'])
		{
			if (!empty($objContact->phone))
			{
				$objContact->phone_href = self::createPhoneLink($objContact->phone);
			}
			if (!empty($objContact->mobile))
			{
				$objContact->mobile_href = self::createPhoneLink($objContact->mobile);
			}
		}
		if (!empty($objContact->email))
		{
			$objContact->email_href = 'mailto:' . $objContact->email;
		}

		// create geocoordinates in MinDec and DMS format
		if (!empty($objContact->geoCoords))
		{
			$geoCoords = explode(',', $objContact->geoCoords);
			if (is_array($geoCoords) && 2 <= count($geoCoords))
			{
				// latidute
				$northSouth = '';
				$lat = trim($geoCoords[0]);
				if (0 < $lat) $northSouth = 'N';
				elseif (0 > $lat) $northSouth = 'S';
				
				// longidute
				$eastWest = '';
				$lng = trim($geoCoords[1]);
				if (0 < $lng) $eastWest = 'E';
				elseif (0 > $lng) $eastWest = 'W';

				// output MinDec
				if (true !== $arrExtendedSettings['geo_no_mindec'])
				{
					$arrMinDecParams = array('{direction}', '{degrees}', '{minutes}');

					$latMinDec = self::convertGeoCoordToMinDec($lat);
					$objContact->geo_mindec_lat = str_replace(
									$arrMinDecParams,
									array($northSouth, abs($latMinDec[0]), number_format($latMinDec[1], 5, '.', '')), 
									$GLOBALS['TL_LANG']['MSC']['tl_contacts']['shortTemplates']['geo_mindec']);

					$lngMinDec = self::convertGeoCoordToMinDec($lng);
					$objContact->geo_mindec_lng = str_replace(
									$arrMinDecParams,
									array($eastWest, abs($lngMinDec[0]), number_format($lngMinDec[1], 5, '.', '')), 
									$GLOBALS['TL_LANG']['MSC']['tl_contacts']['shortTemplates']['geo_mindec']);
				}

				// output DMS
				if (true !== $arrExtendedSettings['geo_no_dms'])
				{
					$arrDMSParams = array('{direction}', '{degrees}', '{minutes}', '{seconds}');

					$latDMS = self::convertGeoCoordToDMS($lat);
					$objContact->geo_dms_lat = str_replace(
									$arrDMSParams,
									array($northSouth, abs($latDMS[0]), $latDMS[1], number_format($latDMS[2], 3, '.', '')), 
									$GLOBALS['TL_LANG']['MSC']['tl_contacts']['shortTemplates']['geo_dms']);

					$lngDMS = self::convertGeoCoordToDMS($lng);
					$objContact->geo_dms_lng = str_replace(
									$arrDMSParams,
									array($eastWest, abs($lngDMS[0]), $lngDMS[1], number_format($lngDMS[2], 3, '.', '')), 
									$GLOBALS['TL_LANG']['MSC']['tl_contacts']['shortTemplates']['geo_dms']);
				}
			}
		}

		// setup social networks
		$arrNetworks = array();
		if (isset($objContact->networks))
		{
			$arrNetworksWork = deserialize($objContact->networks);
			if (is_array($arrNetworksWork) && !empty($arrNetworksWork))
			{
				// create boolean array for networks
				$arrNetworksFilter = self::createOptionsFilterTable(
												$GLOBALS['TL_CONTACTS']['networkOptions'],
												$arrOptions['addNetworksFilter'], $arrOptions['networksFilter']);

				// create network data
				foreach ($arrNetworksWork as &$arrData)
				{
					$network = $arrData['channel'];
					if (!empty($network) && (!isset($arrNetworksFilter[$network]) || $arrNetworksFilter[$network]))
					{
						$userID = $arrData['userID'];
						$networkUrlStr = $GLOBALS['TL_CONTACTS']['networkUrls'][$network];
						if (null === $networkUrlStr) $networkUrlStr = $GLOBALS['TL_CONTACTS']['networkUrls']['_default'];
						$networklUrl = sprintf($networkUrlStr, $userID);
						$networkName = $GLOBALS['TL_LANG']['MSC']['tl_contacts']['networkChannels'][$network];
						if (null === $networkName) $networkName = $network;
						$arrNetworks[$network] = array(
							'link' => $networklUrl,
							'name' => $networkName,
							'userID' => $userID
						);
					 }
				}
			}
		}
		$objContact->networks = $arrNetworks;

		// store contact to cache
		if (false !== $strCacheKey)
		{
			\Cache::set($strCacheKey, $objContact);
		}
		return $objContact;
	}
}


