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
	 * @param $objContact DataRecord
	 * @param $arrOptions array
	 * @return data record
	 */
	static public function getContactDetails($objContact, $arrOptions=array())
	{
		// retrieve contact id
		$contactId = (is_object($objContact)) ? $objContact->id : $objContact;
		if (!strlen($contactId) || $contactId < 1)
		{
			return null;
		}

		// try to locate contact in Cache
		$strCacheKey = (!is_array($arrOptions) || empty($arrOptions)) ? (__METHOD__ . '-' . $contactId) : false;
		if (false !== $strCacheKey && \Cache::has($strCacheKey))
		{
			return \Cache::get($strCacheKey);
		}
		
		// load contact if necessary
		if (!is_object($objContact))
		{
			$objDatabase = \Database::getInstance();
			if ('@default' == $contactId)
			{
				$objContact = $objDatabase->prepare("SELECT * FROM tl_contacts")
									->limit(1)
									->execute();
			}
			else
			{
				$whereKey = (is_numeric($contactId)) ? 'id' : 'alias';
				$objContact = $objDatabase->prepare("SELECT * FROM tl_contacts WHERE {$whereKey}=?")
									->limit(1)
									->execute($contactId);
			}
			if (null === $objContact)
			{
				return null;
			}
		}

		// create boolean array for filterable fields
		$arrFieldsFilter = self::createOptionsFilterTable(
										$GLOBALS['TL_CONTACTS']['fieldOptions'],
										$arrOptions['addFieldsFilter'], $arrOptions['fieldsFilter'],
										$GLOBALS['TL_CONTACTS']['fieldExcludes']);
		
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
			if (isset($objContact->phone))
			{
				$objContact->phone_href = self::createPhoneLink($objContact->phone);
			}
			if (isset($objContact->mobile))
			{
				$objContact->mobile_href = self::createPhoneLink($objContact->mobile);
			}
		}
		if (isset($objContact->email))
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
					if (!isset($arrNetworksFilter[$network]) || $arrNetworksFilter[$network])
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


