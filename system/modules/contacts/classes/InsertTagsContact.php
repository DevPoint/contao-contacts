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

class InsertTagsContact extends \Frontend {

	protected function getContact($aliasId)
	{
		$objContact = null;
		if (null !== $aliasId)
		{
			$whereKey = (is_numeric($aliasId)) ? 'id' : 'alias';
			$objContact = $this->Database->prepare("SELECT * FROM tl_contacts WHERE {$whereKey}=?")
									->limit(1)
									->execute($aliasId);
		}
		else
		{
			$objContact = $this->Database->prepare("SELECT * FROM tl_contacts")
									->limit(1)
									->execute();
		}
		return $objContact;

	}

	public function replaceInsertTags($strTag)
	{
		$result = false;
		$arrSplit = explode('::', $strTag);
		if ($arrSplit[0] == 'contact' && 2 <= count($arrSplit))
		{
			switch($arrSplit[1])
			{
				case 'email_link':
				{
					break;
				}
				default:
				{
					$aliasId = (3 <= count($arrSplit)) ? $arrSplit[2] : null;
					$objContact = $this->getContact($aliasId);
					if (null != $objContact)
					{
						$contact = new Contact();
						$arrContact = $contact->getContactDetails($objContact);
						$result = $arrContact[$arrSplit[1]];
					}
					break;
				}
			}
		}
		return $result;
	}

}


