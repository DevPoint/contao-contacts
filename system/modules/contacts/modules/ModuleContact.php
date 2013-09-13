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

class ModuleContact extends \Module {

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_contact';

    /**
     * contact
     * @var Contact
     */
    //protected $Contact;

    /**
     * arrContact
     * @var Array
     */
    protected $arrContact;

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
		$objContact = ContactModel::findByPk($this->contacts_singleSRC);
		if ($objContact === null)
		{
			global $objPage;
			$objPage->noSearch = 1;
			$objPage->cache = 0;
			return '';
		}


		// Check if contact viewing is protected
		// if ($objContact->protected)
		// {
		// 	$this->import('FrontendUser', 'User');
		// 	if (!Contact::checkProtectedArchiveVisible($objContact->groups, $this->User))
		// 	{
		// 		global $objPage;
		// 		$objPage->noSearch = 1;
		// 		$objPage->cache = 0;
		// 		return '';
		// 	}
		// }

		// Call parent class
		$this->arrContact = $objContact->row();
		return parent::generate();
	}


    /**
     * Generate module
     */
    protected function compile() 
    {
		$contact = new Contact();
		$this->Template->contacts = $contact->parseContact($this->arrContact, $this->contacts_template);
	}
}


