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
	 * check if a protected archive is visible
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


	static public function generateWildcard($wildcardStr)
	{
		$objTemplate = new \BackendTemplate('be_wildcard');
		$objTemplate->wildcard = $wildcardStr;
		$objTemplate->title = $this->headline;
		$objTemplate->id = $this->id;
		$objTemplate->link = $this->name;
		$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
		return $objTemplate->parse();
	}

	static public function generateEmpty()
	{
		global $objPage;
		$objPage->noSearch = 1;
		$objPage->cache = 0;
		return '';
	}
	
	public function parseContact($arrContact, $template, $arrOptions=array())
	{
		global $objPage;

		// create boolean array for filterable fields
		$arrFieldsFilter = array();
		if ($arrOptions['addFieldsFilter'])
		{
			foreach ($arrOptions['fieldsFilter'] as $field)
			{
				$arrFieldsFilter[$field] = true;
			}
			foreach ($GLOBALS['TL_CONTACTS']['fieldOptions'] as $field)
			{
				if (!isset($arrFieldsFilter[$field]))
				{
					$arrFieldsFilter[$field] = false;
				}
			}
		}
		else
		{
			foreach ($GLOBALS['TL_CONTACTS']['fieldOptions'] as $field)
			{
				$arrFieldsFilter[$field] = true;
			}
		}

		// apply fields filter to <arrContact>
		foreach ($arrFieldsFilter as $field => $enabled)
		{
			if (!$enabled)
			{
				unset($arrContact[$field]);
			}
		}
		
		// setup social networks
		$arrNetworks = array();
		if (isset($arrContact['networks']))
		{
			$arrNetworksWork = deserialize($arrContact['networks']);
			if (is_array($arrNetworksWork) && !empty($arrNetworksWork))
			{
				// create boolean array for networks
				$arrNetworksFilter = array();
				if ($arrOptions['addNetworksFilter'])
				{
					foreach ($arrOptions['networksFilter'] as $network)
					{
						$arrNetworksFilter[$network] = true;
					}
					foreach ($GLOBALS['TL_CONTACTS']['networkOptions'] as $network)
					{
						if (!isset($arrNetworksFilter[$network]))
						{
							$arrNetworksFilter[$network] = false;
						}
					}
				}
				else
				{
					foreach ($GLOBALS['TL_CONTACTS']['networkOptions'] as $network)
					{
						$arrNetworksFilter[$network] = true;
					}
				}

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
					 		'href' => $networklUrl,
					 		'name' => $networkName,
					 		'userID' => $userID
					 	);
					 }
				}
			}
		}
		$arrContact['networks'] = $arrNetworks;

		// parse data with template
		$objTemplate = new \FrontendTemplate($template);
		$objTemplate->setData($arrContact);
		return $objTemplate->parse();
	}
}


