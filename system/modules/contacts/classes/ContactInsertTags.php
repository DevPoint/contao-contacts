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

class ContactInsertTags extends \Frontend {

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
					$aliasId = (3 <= count($arrSplit)) ? $arrSplit[2] : '@default';
					$objContact = Contact::getContactDetails($aliasId);
					if (null != $objContact)
					{
						break;
					}
				}
				default:
				{
					$aliasId = (3 <= count($arrSplit)) ? $arrSplit[2] : '@default';
					$objContact = Contact::getContactDetails($aliasId);
					if (null != $objContact)
					{
						$result = $objContact->{$arrSplit[1]};
					}
					else
					{
						return $aliasId;
					}
					break;
				}
			}
		}
		return $result;
	}

}


