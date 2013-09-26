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
 * @package    	Contacts
 * @copyright  	DevPoint | Wilfried Reiter 2013
 * @author     	DevPoint | Wilfried Reiter <wilfried.reiter@devpoint.at>
 * @license		LGPL
 */



/**
 * Add a palette to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'contacts_addFieldsFilter';
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'contacts_addNetworksFilter';
$GLOBALS['TL_DCA']['tl_content']['palettes']['contact'] = '{title_legend},type,headline;{contacts_legend},contacts_singleSRC,contacts_template;{contacts_fieldsFilter_legend:hide},contacts_addFieldsFilter,contacts_extendedSettings;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

/**
 * Add subpalettes to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['contacts_addFieldsFilter'] = 'contacts_fieldsFilter';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['contacts_addNetworksFilter'] = 'contacts_networksFilter';
 
/**
 * Add fields to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['contacts_singleSRC'] = array(
	
	'label'                 => &$GLOBALS['TL_LANG']['tl_content']['contacts_singleSRC'],
	'exclude'               => true,
	'inputType'             => 'radio',
	'options_callback'      => array('tl_content_contacts', 'getContacts'),
	'eval'                  => array('multiple'=>true, 'mandatory'=>true),
	'sql'                   => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['contacts_template'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_content']['contacts_template'],
	'exclude'			=> true,
	'inputType'			=> 'select',
	'options_callback'	=> array('tl_content_contacts', 'getContactTemplates'),
	'eval'				=> array('tl_class'=>'w50'),
	'sql'				=> "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['contacts_addFieldsFilter'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_content']['contacts_addFieldsFilter'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'eval'			=> array('submitOnChange'=>true),
	'sql'			=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['contacts_fieldsFilter'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_content']['contacts_fieldsFilter'],
	'inputType' 	=> 'checkbox',
	'options_callback'	=> array('tl_content_contacts', 'getFieldFilterOptions'),
	'reference'		=> &$GLOBALS['TL_LANG']['tl_content']['contacts_fieldsFilterOptions'],
	'eval'          => array('multiple'=>true, 'mandatory'=>false),
	'sql'           => "blob NULL",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['contacts_addNetworksFilter'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_content']['contacts_addNetworksFilter'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'eval'			=> array('submitOnChange'=>true),
	'sql'			=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['contacts_networksFilter'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_content']['contacts_networksFilter'],
	'inputType' 	=> 'checkbox',
	'options_callback'	=> array('tl_content_contacts', 'getNetworkFilterOptions'),
	'eval'          => array('multiple'=>true, 'mandatory'=>false),
	'sql'           => "blob NULL",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['contacts_extendedSettings'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_content']['contacts_extendedSettings'],
	'inputType' 	=> 'checkbox',
	'options'		=> array('short_labels','phone_nolink','email_nolabel','weblink_nolabel'),
	'reference'		=> &$GLOBALS['TL_LANG']['tl_content']['contacts_extendedSettingsOptions'],
	'eval'          => array('multiple'=>true, 'mandatory'=>false),
	'sql'           => "blob NULL",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['contacts_mapZoom'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_content']['contacts_mapZoom'],
	'exclude'       => true,
	'filter'        => true,
	'inputType'     => 'select',
	'options'       => array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20'),
	'default'       => '10',
	'eval'          => array('includeBlankOption'=>true, 'tl_class'=>'w50 clr'),
	'sql'           => "varchar(2) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['contacts_mapAspect'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_content']['contacts_mapAspect'],
	'exclude'       => true,
	'filter'        => true,
	'inputType'     => 'select',
	'options'       => array('2_1','16_9','16_10','4_3','5_4','1_1'),
	'reference'		=> &$GLOBALS['TL_LANG']['tl_content']['contacts_mapAspectOptions'],
	'default'       => '16_10',
	'eval'          => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
	'sql'           => "varchar(8) NOT NULL default ''"
);

/**
 * Class <tl_content_contacts>
 * for service functions
 *
 * @package    Contacts
 * @copyright  DevPoint | Wilfried Reiter 2013
 * @author     DevPoint | Wilfried Reiter <wilfried.reiter@devpoint.at>
 */
class tl_content_contacts extends Backend {

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
	 * Return all contacts templates as array
	 * @param $strTemplatePrefix string
	 * @param $templateFirst string
	 * @return array
	 */
	protected function getTemplateGroupResorted($strTemplatePrefix, $templateFirst)
	{
		$templatesResorted = array($templateFirst);
		$templates = $this->getTemplateGroup($strTemplatePrefix);
		foreach ($templates as $template)
		{
			if ($template !== $templateFirst)
			{
				$templatesResorted[] = $template;
			}
		}			
		return $templatesResorted;
	}

	/**
	 * Return all contacts templates as array
	 * @param $dc DataContainer
	 * @return array
	 */
	public function getContactTemplates(DataContainer $dc)
	{
		switch ($dc->activeRecord->type)
		{
			case 'contact_gmaps':
				return $this->getTemplateGroupResorted('contact_', 'contact_gmaps');
		}
		return $this->getTemplateGroup('contact_');
	}

	/**
	 * Get all contacts field names which 
	 * could be filtered by the user
	 * @return array
	 */
	public function getFieldFilterOptions()
	{
		$options = array();
		foreach($GLOBALS['TL_CONTACTS']['fieldOptions'] as $field)
		{
			$fieldName = $GLOBALS['TL_LANG']['MSC']['tl_contacts']['fieldOptions'][$field];
			if (null === $fieldName) $fieldName = $field;
			$options[$field] = $fieldName;
		}
		return $options;
	}

	/**
	 * Retrieve social channels
	 * @param $dc DataContainer
	 * @return array
	 */
	public function getNetworkFilterOptions(DataContainer $dc)
	{
		$options = array();
		foreach($GLOBALS['TL_CONTACTS']['networkOptions'] as $channel)
		{
			$channelName = $GLOBALS['TL_LANG']['MSC']['tl_contacts']['networkOptions'][$channel];
			if (null === $channelName) $channelName = $channel;
			$options[$channel] = $channelName;
		}
		return $options;
	}
}
