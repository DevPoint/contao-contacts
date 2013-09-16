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

class ModuleContact extends \Module {

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_contact';

    /**
     * Contact Array
     * @var Array
     */
    protected $objContact;


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

	/**
     * Compile module
	 */
	public function generate()
	{
		// Wildcard for BE mode
		if (TL_MODE == 'BE')
		{
			return Contact::generateWildcard('### CONTACT ###');
		}

		// Return, if contact doesn't exist anymore
		$this->objContact = $this->Database->prepare("SELECT * FROM tl_contacts WHERE id=?")
									 ->limit(1)
									 ->execute($this->contacts_singleSRC);
		if ($this->objContact === null)
		{
			return Contact::generateEmpty();
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
    	$arrOptions = array();
		$contact = new Contact();
    	$arrOptions['addFieldsFilter'] = $this->contacts_addFieldsFilter;
    	$arrOptions['fieldsFilter'] = deserialize($this->contacts_fieldsFilter);
    	$arrOptions['addNetworksFilter'] = $this->contacts_addNetworksFilter;
    	$arrOptions['networksFilter'] = deserialize($this->contacts_networksFilter);
    	$arrOptions['extendedSettings'] = deserialize($this->contacts_extendedSettings);
		$objTemplate = new \FrontendTemplate($this->contacts_template);
		$objContact = $contact->getContactDetails($this->objContact, $arrOptions);
		//$objTemplate->setData($contact->getContactDetails($this->objContact, $arrOptions));
		$objTemplate->setData($objContact->row());
		$this->Template->contacts = $objTemplate->parse();
	}
}


