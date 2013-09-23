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


$GLOBALS['TL_DCA']['tl_contacts'] = array(
	
	// Configuration
	'config' => array(
		'dataContainer' => 'Table',
		'switchToEdit' => true,
		'enableVersioning' => true,
		'sql' => array(
			'keys' => array(
				'id' => 'primary',
				'alias' => 'index'
			)
		)
	),
	
	// Liste
	'list' => array(
		'sorting' => array(
			'mode'		=> 1,
			'fields'	=> array('name'), // Sortierung der Einträge nach Name
			'flag'		=> 1,
			'panelLayout'   => 'search,limit'
		),
		'label' => array(
			'fields'	=> array('title'), // Elemente, die im Panel angezeigt werden
			'format'	=> '%s'
		),
		'global_operations' => array(
			'all' => array(
				'label'		=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'		=> 'act=select',
				'class'     => 'header_edit_all',
				'attributes'	=> 'onclick="Backend.getScrollOffset();"'
			)
		),            
		'operations' => array(
			'edit' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_contacts']['edit'],
				'href'		=> 'act=edit',
				'icon'		=> 'edit.gif'
			),
			'delete' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_contacts']['delete'],
				'href'		=> 'act=delete',
				'icon'		=> 'delete.gif',
				'attributes'	=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_contacts']['show'],
				'href'		=> 'act=show',
				'icon'		=> 'show.gif'
			)	
		),
	),
	
	// Palettes
	'palettes' => array(
		'__selector__'	=> array('addImage'),
		'default'   	=> '{titleLegend},title,alias;{contactLegend},name,name2,city,street,postal,countryCode,geoCoords;{phoneLegend},phone,email,mobile,fax;{networksLegend},networks;',
	),

	// Subpalettes
	'subpalettes' => array(
		'addImage'			=> 'singleSRC,alt,size',
	),
	
	// Fields
	'fields' => array(
		'id' => array(
			'sql'			=> "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array(
			'sql'			=> "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['title'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>true, 'maxLength'=>255),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'alias' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['alias'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('rgxp'=>'alias', 'unique'=>true, 'maxLength'=>255, 'tl_class'=>'w50'),
			'save_callback' => array(
				array('tl_contacts', 'generateAlias')
			),
			'sql'			=> "varbinary(128) NOT NULL default ''"
		),
		// address fields
		'name' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['name'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>true, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'name2' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['name2'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'longName' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['longName'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'long clr'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'city' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['city'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50 clr'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'street' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['street'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'postal' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['postal'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>8, 'tl_class'=>'w50 clr'),
			'sql'			=> "varchar(8) NOT NULL default ''"
		),
		'state' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['state'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50 clr'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'countryCode' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['countryCode'],
			'exclude'		=> true,
			'filter'        => true,
			'sorting'       => true,
			'inputType'     => 'select',
			'options'       => $this->getCountries(),
			'eval'          => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
			'sql'           => "varchar(2) NOT NULL default ''"
		),
		'geoCoords' => array(
			'label'         => &$GLOBALS['TL_LANG']['tl_contacts']['geoCoords'],
			'exclude'       => true,
			'search'        => true,
			'inputType'     => 'text',
			'eval'          => array('maxlength'=>64, 'tl_class'=>'clr'),
			'save_callback' => array(
				array('tl_contacts', 'generateCoords')
			 ),
			'sql'			=> "varchar(64) NOT NULL default ''"
		),
		'addImage' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['addImage'],
			'exclude'		=> true,
			'inputType'		=> 'checkbox',
			'eval'			=> array('submitOnChange'=>true),
			'sql'			=> "char(1) NOT NULL default ''"
		),
		'singleSRC' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['singleSRC'],
			'exclude'		=> true,
			'inputType'		=> 'fileTree',
			'eval'			=> array('fieldType'=>'radio', 'filesOnly'=>true, 'mandatory'=>true),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'alt' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['alt'],
			'exclude'		=> true,
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxlength'=>255, 'tl_class'=>'long'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'size' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['size'],
			'exclude'		=> true,
			'inputType'		=> 'imageSize',
			'options'		=> $GLOBALS['TL_CROP'],
			'reference'		=> &$GLOBALS['TL_LANG']['MSC'],
			'eval'			=> array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50'),
			'sql'			=> "varchar(64) NOT NULL default ''"
		),
		// phone fields
		'phone' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['phone'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'mobile' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['mobile'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'fax' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['fax'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'email' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['email'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		// Networks fields
		'networks' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['networks'],
			'exclude'		=> true,
			'inputType'		=> 'multiColumnWizard',
			'eval'			=> array(
				'columnFields'	=> array(
					'channel'	=> array(
						'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['networkOptions'],
						'inputType'		=> 'select',
						'options_callback'	=> array('tl_contacts', 'getNetworkOptions'),
						'eval'			=> array('style'=>'width:160px;margin:0 5px 5px 0','includeBlankOption' => true)),
					'userID'	=> array(
						'label'         => &$GLOBALS['TL_LANG']['tl_contacts']['networkUserID'],
						'inputType'     => 'text',
						'eval'          => array('style'=>'width:320px'))),
				'tl_class' => 'clr'
			),
			'sql'			=> "blob NULL"
		),
	)
);

class tl_contacts extends Backend
{
	/**
	 * Auto-generate the news alias if it has not been set yet
	 * @param $varValue mixed
	 * @param $dc DataContainer
	 * @return string
	 * @throws \Exception
	 */
	public function generateAlias($varValue, DataContainer $dc)
	{
		$autoAlias = false;

		// Generate alias if there is none
		if ($varValue == '')
		{
			$autoAlias = true;
			$varValue = standardize(String::restoreBasicEntities($dc->activeRecord->title));
		}

		$objAlias = $this->Database->prepare("SELECT id FROM tl_contacts WHERE alias=?")
								   ->execute($varValue);

		// Check whether the news alias exists
		if ($objAlias->numRows > 1 && !$autoAlias)
		{
			throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		// Add ID to alias
		if ($objAlias->numRows && $autoAlias)
		{
			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}


	/**
	 * Get geo coodinates from address
	 * @param $varValue string
	 * @param $dc DataContainer
	 * @return string
	 */
	public function generateCoords($varValue, DataContainer $dc) 
	{
		if (!$varValue)
		{
			// calculate google API address string
			$addPlus = '';
			$geoAddress = '';
			$varStreet = trim(String::restoreBasicEntities($dc->activeRecord->street));
			$varCity = trim(String::restoreBasicEntities($dc->activeRecord->postal) . ' ' . String::restoreBasicEntities($dc->activeRecord->city));
			$varCountryCode = trim(String::restoreBasicEntities($dc->activeRecord->countryCode));
			if (!empty($varStreet))
			{
				$geoAddress .= $addPlus . $varStreet;
				$addPlus = ',+';
			}
			if (!empty($varCity))
			{
				$geoAddress .= $addPlus . $varCity;
				$addPlus = ',+';
			}
			if (!empty($varCountryCode))
			{
				$geoAddress .= $addPlus . $varCountryCode;
				$addPlus = ',+';
			}
			// try to retrieve geoCoords through curl API
			$arrGeoCode = array('status' => 'INIT');
			$geoUrl = sprintf('http://maps.google.com/maps/api/geocode/json?address=%s&sensor=false', urlencode($geoAddress));
			if (function_exists("curl_init"))
			{
				$curl = curl_init();
				if ($curl && curl_setopt($curl, CURLOPT_URL, $geoUrl) && curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1) && curl_setopt($curl, CURLOPT_HEADER, 0))
				{
					$curlVal = curl_exec($curl);
					$arrGeoCode = json_decode($curlVal, true);
					curl_close($curl);
				}
			}
			// try to retrieve geoCoords through <file_get_contents(..)>
			if ($arrGeoCode['status'] != 'OK')
			{
				$arrGeoCode = json_decode(file_get_contents($geoUrl), true);
			}
			// if one of the methods worked, store result
			if ($arrGeoCode['status'] == 'OK')
			{
				$lat = $arrGeoCode['results'][0]['geometry']['location']['lat'];
				$lng = $arrGeoCode['results'][0]['geometry']['location']['lng'];
				$varValue = $lat . ', ' . $lng;
			}
			if (!$varValue)
			{
				$varValue = $GLOBALS['TL_LANG']['tl_contacts']['references']['noCoords'];
			}
		}
		return $varValue;
	}

	/**
	 * Correct language labels
	 * @param $value string
	 * @param $dc DataContainer
	 * @return string
	 */
	public function tweakLanguageLabelCallBack($value, DataContainer $dc)
	{
		if (0 < strlen($value) && 7 == (strlen($dc->field) + 1))
		{
			$langIndexStr = $dc->field . '_';
			foreach($GLOBALS['TL_DCA']['tl_contacts']['fields'] as $fieldName => &$dcaField)
			{
				if (0 === strncmp($langIndexStr, $fieldName, 7))
				{
					$baseFieldName = substr($fieldName, 7);
					if (isset($GLOBALS['TL_DCA']['tl_contacts']['fields'][$baseFieldName]))
					{
						$newLabel = $GLOBALS['TL_DCA']['tl_contacts']['fields'][$baseFieldName]['label'][0] . ' (' . $value . ')';
						$dcaField['label'] = array($newLabel, $dcaField['label'][1]);
					}
				}
			}
		}
		return $value;
	}


	/**
	 * Retrieve social channels
	 * @param $dc DataContainer
	 * @return array
	 */
	public function getNetworkOptions(DataContainer $dc)
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


	/**
	 * Convert language tags to lowercase letters
	 * @param $varValue string
	 * @return string
	 */
	public function languageToLower($varValue)
	{
		return strtolower($varValue);
	}
}

?>
