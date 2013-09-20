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
	protected $objContact;

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
		$this->objContact = $this->Database->prepare("SELECT * FROM tl_contacts WHERE id=?")
									 ->limit(1)
									 ->execute($this->contacts_singleSRC);
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
		$arrOptions['extendedSettings'] = array_fill_keys(deserialize($this->contacts_extendedSettings), true);
		$objContact = Contact::getContactDetails($this->objContact, $arrOptions);

		// parse contact gmap
		$arrMapOptions = array();
		$arrMapOptions['mapZoom'] = $this->contacts_mapZoom;
		$arrMapOptions['useAutoHeight'] = (true !== $arrOptions['extendedSettings']['gmap_noautoheight']);
		$objContact->gmaps = Contact::parseContactMap($this->objContact, 'gmaps_simple', $arrMapOptions);
		if (!empty($objContact->gmaps))
		{
			$GLOBALS['TL_JAVASCRIPT'][] = 'http'.($this->Environment->ssl ? 's' : '').'://maps.google.com/maps/api/js?v=3.exp&sensor=false';
		}

		// parse contact
		$objTemplate = new \FrontendTemplate($this->contacts_template);
		$objTemplate->setData($objContact->row());
		$this->Template->contacts = $objTemplate->parse();

	}
}


