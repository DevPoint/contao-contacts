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

class ModuleContact extends \ModuleBaseContact {

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_contact';

	/**
	 * Contact DataRecord
	 * @var Array
	 */
	protected $objContact;

	/**
	 * Compile module
	 */
	public function generate()
	{
		// Wildcard for BE mode
		if (TL_MODE == 'BE')
		{
			return $this->generateWildcard('### CONTACT ###');
		}

		// Return, if contact doesn't exist anymore
		$this->objContact = \ContactsModel::findById($this->contacts_singleSRC);
		if ($this->objContact === null)
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
		$arrOptions['addFieldsFilter'] = $this->contacts_addFieldsFilter;
		$arrOptions['fieldsFilter'] = deserialize($this->contacts_fieldsFilter);
		$arrOptions['addNetworksFilter'] = $this->contacts_addNetworksFilter;
		$arrOptions['networksFilter'] = deserialize($this->contacts_networksFilter);
		$arrOptions['extendedSettings'] = array_fill_keys(deserialize($this->contacts_extendedSettings, true), true);

		// prepare Template
		$objContact = \Contact::getContactDetails($this->objContact, $arrOptions);
		$objTemplate = new \FrontendTemplate($this->contacts_template);
		$objTemplate->setData($objContact->row());

		// generate contact gmap
		if (true === $arrOptions['extendedSettings']['gmap_enable'] && !empty($objContact->geoCoords))
		{
			$arrMapOptions = array();
			$arrMapOptions['addFieldsFilter'] = false;
			$arrMapOptions['addNetworksFilter'] = false;
			$arrMapOptions['extendedSettings'] = array();
			$objTemplate->gmaps = $this->generateContactMap($this->objContacts, 'gmaps_simple', $arrMapOptions);
			if ($objTemplate->gmaps)
			{
				$GLOBALS['TL_JAVASCRIPT'][] = 'http'.($this->Environment->ssl ? 's' : '').'://maps.google.com/maps/api/js?v=3.exp&amp;sensor=false';
			}
		}
		else
		{
			$objTemplate->gmaps = false;
		}

		// parse contact template
		$this->Template->contacts = $objTemplate->parse();
	}
}


