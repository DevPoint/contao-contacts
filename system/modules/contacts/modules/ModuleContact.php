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


/**
 * Run in a custom namespace, so the class can be replaced
 */

abstract class ModuleContact extends \Module {

	/**
	 * Sort out protected archives
	 * @param array
	 * @return array
	 */
	protected function sortOutProtected($arrContacts)
	{
		if (BE_USER_LOGGED_IN || !is_array($arrContacts) || empty($arrContacts))
		{
			return $arrContacts;
		}

		$this->import('FrontendUser', 'User');
		$objContact = \ContactModel::findMultipleByIds($arrContacts);
		$arrContacts = array();

		if ($objContact !== null)
		{
			while ($objContact->next())
			{
				// if ($objContact->protected)
				// {
				// 	if (!FE_USER_LOGGED_IN)
				// 	{
				// 		continue;
				// 	}

				// 	$groups = deserialize($objContact->groups);

				// 	if (!is_array($groups) || empty($groups) || !count(array_intersect($groups, $this->User->groups)))
				// 	{
				// 		continue;
				// 	}
				// }

				$arrContacts[] = $objContact->id;
			}
		}

		return $arrContacts;
	}


	public function generateWildcard($wildcardStr)
	{
		$objTemplate = new \BackendTemplate('be_wildcard');
		$objTemplate->wildcard = $wildcardStr;
		$objTemplate->title = $this->headline;
		$objTemplate->id = $this->id;
		$objTemplate->link = $this->name;
		$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
		return $objTemplate->parse();
	}

	/**
	 * Get all contacts and return them as array
	 * @return array
	 */
	public function parseContact($objContact, $arrOptions=array())
	{
		global $objPage;
		$objTemplate = new \FrontendTemplate($this->contacts_template);
		$objTemplate->setData($objContact->row());
		return $objTemplate->parse();
	}
}


