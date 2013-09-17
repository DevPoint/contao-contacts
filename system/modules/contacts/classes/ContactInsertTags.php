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

	public function replaceInsertTags($strTag, $blnCache)
	{
		$result = false;
		$arrSplit = explode('::', $strTag);
		if ($arrSplit[0] == 'contact' && 2 <= count($arrSplit))
		{
			$arrParams = explode(':', $arrSplit[1]);
			switch($arrParams[0])
			{
				case 'email_link':
				{
					$aliasId = (2 <= count($arrParams)) ? $arrParams[1] : '@default';
					$objContact = Contact::getContactDetails($aliasId);
					if (null != $objContact && isset($objContact->email_href))
					{
						$result = sprintf($GLOBALS['TL_CONTACTS']['shortTemplates']['email_link'], $objContact->email_href, $objContact->name, $objContact->email);
						break;
					}
				}
				default:
				{
					$aliasId = (2 <= count($arrParams)) ? $arrParams[1] : '@default';
					$objContact = Contact::getContactDetails($aliasId);
					if (null !== $objContact && isset($objContact->{$arrParams[0]}))
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
