<?php

$GLOBALS['TL_DCA']['tl_contacts'] = array(
	
	// Configuration
	'config' => array(
		'dataContainer' => 'Table',
		'switchToEdit' => true,
		'enableVersioning' => true,
		'sql' => array(
			'keys' => array(
				'id' => 'primary'
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
		'default'   	=> '{titleLegend},title;{contactLegend},name,name2,city,street,postal,countryCode;{phoneLegend},phone,email,mobile,fax;{networksLegend},networks;',
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
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>2, 'tl_class'=>'w50'),
			'sql'			=> "varchar(2) NOT NULL default ''"
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
			'eval'			=> array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
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
	 * Correct language labels
	 * @param string
	 * @param DataContainer
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
	 * @param DataContainer
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
	 * @param string
	 * @return string
	 */
	public function languageToLower($varValue)
	{
		return strtolower($varValue);
	}
}

?>
