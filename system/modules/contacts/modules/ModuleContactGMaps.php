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

class ModuleContactGMaps extends \ModuleBaseContact {

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_contact';

	/**
	 * Contact DataRecord
	 * @var array
	 */
	protected $objContacts;

	/**
	 * Compile module
	 */
	public function generate()
	{
		// Wildcard for BE mode
		if (TL_MODE == 'BE')
		{
			return $this->generateWildcard('### CONTACT GMAPS ###');
		}

		// Return, if contact doesn't exist anymore
		$multiSRC = deserialize($this->contacts_multiSRC);
		$arrIds = array_map('intval', $multiSRC);
		$this->objContacts = \ContactsModel::findMultipleByIds($arrIds);
		if ($this->objContacts === null || count($this->objContacts) < 1)
		{
			return $this->generateEmpty();
		}

		// Check if contact viewing is protected
		// if ($objContact->protected)
		// {
		// 	$this->import('FrontendUser', 'User');
		// 	if (!Contact::checkProtectedArchiveVisible($objContact->groups, $this->User))
		// 	{
		//		return Contact::generateEmpty();
		// 	}
		// }
		
		// Call parent class
		return parent::generate();
	}

	/**
	 * Generate module
	 */
	protected function compile() 
	{
		// get contact details
		$arrOptions = array();
		$arrOptions['addFieldsFilter'] = false;
		$arrOptions['addNetworksFilter'] = false;
		$arrOptions['extendedSettings'] = array();

		// prepare contact Template
		$objTemplate = new \FrontendTemplate($this->contacts_template);

		// generate contact map
		$objTemplate->gmaps = $this->generateContactMap($this->objContacts, 'gmaps_simple', $arrOptions);
		if ($objTemplate->gmaps)
		{
			$this->enqueueGoogleMapsScript();
		}

		// parse contact Template
		$this->Template->contacts = $objTemplate->parse();
	}
}
