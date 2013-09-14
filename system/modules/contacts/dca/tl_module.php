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
 * @license MIT
 */

/**
 * Add a palette to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'contacts_addFieldsFilter';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'contacts_addNetworksFilter';
$GLOBALS['TL_DCA']['tl_module']['palettes']['contact'] = '{title_legend},name,headline,type;{contacts_legend},contacts_singleSRC,contacts_template;{contacts_fieldsFilter_legend:hide},contacts_addFieldsFilter;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

/**
 * Add subpalettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['contacts_addFieldsFilter'] = 'contacts_fieldsFilter,contacts_addNetworksFilter';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['contacts_addNetworksFilter'] = 'contacts_networksFilter';

 
/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['contacts_singleSRC'] = array(
	
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['contacts_singleSRC'],
	'exclude'               => true,
	'inputType'             => 'radio',
	'options_callback'      => array('tl_module_contacts', 'getContacts'),
	'eval'                  => array('multiple'=>true, 'mandatory'=>true),
	'sql'                   => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['contacts_multiSRC'] = array(

	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['contacts_multiSRC'],
	'exclude'               => true,
	'inputType'             => 'checkbox',
	'options_callback'      => array('tl_module_contacts', 'getContacts'),
	'eval'                  => array('multiple'=>true, 'mandatory'=>true),
	'sql'                   => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['contacts_template'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['contacts_template'],
	'default'			=> 'contacts_basic',
	'exclude'			=> true,
	'inputType'			=> 'select',
	'options_callback'	=> array('tl_module_contacts', 'getContactTemplates'),
	'eval'				=> array('tl_class'=>'w50'),
	'sql'				=> "varchar(32) NOT NULL default ''"
);


$GLOBALS['TL_DCA']['tl_module']['fields']['contacts_addFieldsFilter'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['contacts_addFieldsFilter'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'eval'			=> array('submitOnChange'=>true),
	'sql'			=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['contacts_fieldsFilter'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['contacts_fieldsFilter'],
	'inputType' 	=> 'checkbox',
	'default'		=> array('name','name2','street','postal','city','phone','mobile','fax','email','networks'),
	'options'      	=> array('name','name2','street','postal','city','phone','mobile','fax','email','networks'),
	'reference'		=> &$GLOBALS['TL_LANG']['tl_module']['contacts_fieldsFilterOptions'],
	'eval'          => array('multiple'=>true, 'mandatory'=>false),
	'sql'           => "blob NULL",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['contacts_addNetworksFilter'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['contacts_addNetworksFilter'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'eval'			=> array('submitOnChange'=>true),
	'sql'			=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['contacts_networksFilter'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['contacts_networksFilter'],
	'inputType' 	=> 'checkbox',
	'options_callback'	=> array('tl_module_contacts', 'getNetworkChannels'),
	'eval'          => array('multiple'=>true, 'mandatory'=>false),
	'sql'           => "blob NULL",
);

/**
 * Class <tl_module_contacts>
 * for service functions
 *
 * @package    Contacts
 * @copyright  DevPoint | Wilfried Reiter 2013
 * @author     DevPoint | Wilfried Reiter <wilfried.reiter@devpoint.at>
 */
class tl_module_contacts extends Backend {

	/**
	 * Get all contacts and return them as array
	 * @return array
	 */
	public function getContacts()
	{
		if (!$this->User->isAdmin && !is_array($this->User->contacts))
		{
		//	return array();
		}

		$arrArchives = array();
		$objArchives = $this->Database->execute("SELECT id, title FROM tl_contacts ORDER BY title");

		while ($objArchives->next())
		{
		//	if ($this->User->isAdmin || $this->User->hasAccess($objArchives->id, 'contacts'))
			{
				$arrArchives[$objArchives->id] = $objArchives->title;
			}
		}

		return $arrArchives;
	}

	/**
	 * Get all contacts field names which 
	 * could be filtered by the user
	 * @return array
	 */
	public function getContactFieldsFilter()
	{
		return array(
			'name' => 'Name',
			'name2' => 'Name2',
			'street' => 'Straße'
		);
	}

	/**
	 * Return all contacts templates as array
	 * @return array
	 */
	public function getContactTemplates()
	{
		return $this->getTemplateGroup('contact_');
	}

	/**
	 * Retrieve social channels
	 * @param DataContainer
	 * @return array
	 */
	public function getNetworkChannels(DataContainer $dc)
	{
		$options = array();
		foreach($GLOBALS['TL_CONTACTS']['networkChannels'] as $channel)
		{
			$channelName = $GLOBALS['TL_LANG']['MSC']['tl_contacts']['networkChannels'][$channel];
			if (null === $channelName) $channelName = $channel;
			$options[$channel] = $channelName;
		}
		return $options;
	}




}
