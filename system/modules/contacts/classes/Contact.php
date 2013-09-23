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
	public static function checkProtectedArchiveVisible($archiveGroups, $user)
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
	protected static function createPhoneLink($phone)
	{
		$phone = html_entity_decode($phone);
		$phone = preg_replace('/\((.*?)\)|\[(.*?)\]/', '', $phone);
		$phone = str_replace(array("/", "\\", ".", " "), "", $phone);
		return 'tel:' . $phone;
	}
	
	/**
	 * Convert geo-coordinate from 
	 * DegDec to DMS format
	 * @param $degreeValue float
	 * @return array[3]
	 */
	protected static function convertGeoCoordToDMS($degreeValue)
	{
		$degrees = floor($degreeValue);
		$minutesSec = ($degreeValue - $degrees) * 60.0;
		$minutes = floor($minutesSec);
		$seconds = ($minutesSec - $minutes) * 60.0;
		return array($degrees, $minutes, $seconds);
	}
	
	/**
	 * Convert geo-coordinate from 
	 * DegDec to MinDec format
	 * @param $degreeValue float
	 * @return array[2]
	 */
	protected static function convertGeoCoordToMinDec($degreeValue)
	{
		$degrees = floor($degreeValue);
		$minutes = ($degreeValue - $degrees) * 60.0;
		return array($degrees, $minutes);
	}

	/**
	 * Parameter array for shortTemplate <geo_dms>
	 */
	protected static $arrDMSParams = array('{direction}', '{degrees}', '{minutes}', '{seconds}');

	/**
	 * Parse geo-coordinate in DMS format
	 * @param $degreeValue float
	 * @param $directions array[2]
	 * @return string
	 */
	public static function parseGeoCoordDMS($degreeValue, $directions)
	{
		$directionStr = '';
		if (0 < $degreeValue) $directionStr = $directions[0];
		elseif (0 > $degreeValue) $directionStr = $directions[1];

		$arrDMS = self::convertGeoCoordToDMS($degreeValue);
		return str_replace(
					self::$arrDMSParams,
					array($directionStr, abs($arrDMS[0]), $arrDMS[1], number_format($arrDMS[2], 3, '.', '')), 
					$GLOBALS['TL_LANG']['MSC']['tl_contacts']['shortTemplates']['geo_dms']);
	}
	
	/**
	 * Parameter array for shortTemplate <geo_mindec>
	 */
	protected static $arrMinDecParams = array('{direction}', '{degrees}', '{minutes}');

	/**
	 * Parse geo-coordinate in MinDec format
	 * @param $degreeValue float
	 * @param $directions array[2]
	 * @return string
	 */
	public static function parseGeoCoordMinDec($degreeValue, $directions)
	{
		$directionStr = '';
		if (0 < $degreeValue) $directionStr = $directions[0];
		elseif (0 > $degreeValue) $directionStr = $directions[1];

		$arrMinDec = self::convertGeoCoordToMinDec($degreeValue);
		return str_replace(
					self::$arrMinDecParams,
					array($directionStr, abs($arrMinDec[0]), number_format($arrMinDec[1], 5, '.', '')), 
					$GLOBALS['TL_LANG']['MSC']['tl_contacts']['shortTemplates']['geo_mindec']);
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
	public static function createOptionsFilterTable($options, $hasFilter, $filters, $excludes=null)
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
		if ($hasFilter)
		{
			if (is_array($filters))
			{
				foreach ($filters as $key)
				{
					$arrFilter[$key] = true;
				}
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
	 * Parse Gmaps
	 * @param $objContact mixed
	 * @param $strTemplate string
	 * @param $arrMapOptions array
	 * @return string
	 */
	public static function parseContactMap($objContact, $strTemplate, $arrMapOptions=null)
	{
		$result = '';
		if (!empty($objContact->geoCoords))
		{
			$geoCoords = explode(',', $objContact->geoCoords);
			$arrGlobalOptions = &$GLOBALS['TL_CONTACTS']['mapOptions'];
			$gmapsTemplate = new \FrontendTemplate($strTemplate);
			$gmapsTemplate->id = $objContact->id . $arrMapOptions['viewId'];
			$gmapsTemplate->lat = $geoCoords[0];
			$gmapsTemplate->lng = $geoCoords[1];
			$gmapsTemplate->zoom = ($arrMapOptions['mapZoom']) ? $arrMapOptions['mapZoom'] : $arrGlobalOptions['defaultZoom'];
			$gmapsTemplate->useAutoHeight = ($arrMapOptions['mapAspect']) ? 'true' : 'false';
			$mapAspectRatio = ($arrMapOptions['mapAspect']) ? $arrMapOptions['mapAspect'] : '16_10';
			$arrAspectRatioParams = &$arrGlobalOptions['autoHeight'][$mapAspectRatio];
			$gmapsTemplate->autoHeightAspect = ($arrAspectRatioParams['aspect']) ? $arrAspectRatioParams['aspect'] : 0;
			$gmapsTemplate->minAutoHeight = ($arrAspectRatioParams['min']) ? $arrAspectRatioParams['min'] : 0;
			$gmapsTemplate->maxAutoHeightAspect = ($arrGlobalOptions['maxAspect']) ? $arrGlobalOptions['maxAspect'] : 0;
			$gmapsTemplate->maxAutoHeightScreenAspect = ($arrGlobalOptions['maxScreenAspect']) ? $arrGlobalOptions['maxScreenAspect'] : 0;
			$result = $gmapsTemplate->parse();
		}
		return $result;
	}

	/**
	 * Enrich DataRecord by additional 
	 * properties
	 * @param $objContact mixed
	 * @param $hasOptions boolean
	 * @param $arrOptions array
	 * @return data record
	 */
	public static function getContactDetails($objContact, $arrOptions=null)
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

		// create labels
		$arrExtendedSettings = $arrOptions['extendedSettings'];
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


