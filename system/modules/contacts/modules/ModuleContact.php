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

class ModuleContact extends ModuleBaseContact {

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_contact';

	/**
     * Compile module
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
		//	return $this->generateWildcard('### CONTACT SINGLE ###');
		}

		// Do not index or cache the page if there are no archives
		// $arrContacts = $this->sortOutProtected(array($this->contacts_singleSRC));
		// if (!is_array($this->news_archives) || empty($this->news_archives))
		// {
		// 	global $objPage;
		// 	$objPage->noSearch = 1;
		// 	$objPage->cache = 0;
		// 	return '';
		// }
		// $this->contacts_singleSRC = $arrContacts[0];

		return parent::generate();
	}


    /**
     * Generate module
     */
    protected function compile() 
    {
  		$this->Template->contacts = '';	
        $objContact = ContactModel::findByPk($this->contacts_singleSRC);
		if ($objContact !== null)
		{
    		$this->Template->contacts = $this->parseContact($objContact);
	    }
	}
}


