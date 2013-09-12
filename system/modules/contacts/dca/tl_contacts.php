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
		'__selector__'	=> array('addImage','addLang01'),
		'default'   	=> '{titleLegend},title;{contactLegend},name,name2,city,street,postal,countryCode;{lang01Legend},addLang01_Full;{phoneLegend},phone,email,mobile,fax;{socialLinksLegend},socialLinks;',
	//	'default'   	=> '{titleLegend},title;{contactLegend},name,name2,longName,city,street,postal,state,countryCode;{imageLegend},addImage;{lang01Legend},addLang01;{lang02Legend:hide},addLang02;{lang03Legend:hide},addLang03;{phoneLegend},phone,email,mobile,fax;{socialLinksLegend},socialLinks;'
	),

	// Subpalettes
	'subpalettes' => array(
		'addLang01'			=> 'lang01,lang01_name,lang01_name2,lang01_city,lang01_street',
	//	'addLang01'	=> 'lang01,lang01_name,lang01_name2,lang01_longName,lang01_city,lang01_street,lang01_state,lang01_alt',
		'addLang02'			=> 'lang02,lang02_name,lang02_name2,lang02_city,lang02_street',
		'addLang03'			=> 'lang03,lang03_name,lang03_name2,lang03_city,lang03_street',
		'addImage'			=> 'singleSRC,alt,size'
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
		// translations fields
		'addLang01' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['addLang'],
			'exclude'		=> true,
			'inputType'		=> 'checkbox',
			'eval'			=> array('submitOnChange'=>true),
			'sql'			=> "char(1) NOT NULL default ''"
		),
		'lang01' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang01'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'search'		=> true,
			'eval'			=> array('mandatory'=>true, 'rgxp'=>'alpha', 'maxlength'=>2, 'nospace'=>true),
			'load_callback' => array(
				array('tl_contacts', 'tweakLanguageLabelCallBack')
			),
			'save_callback' => array(
				array('tl_contacts', 'languageToLower')
			),
			'sql'			=> "varchar(2) NOT NULL default ''"
		),
		'lang01_name' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang01_name'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang01_name2' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang01_name2'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang01_longName' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang01_longName'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxLength'=>255, 'tl_class'=>'long clr'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang01_street' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang01_street'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang01_city' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang01_city'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang01_state' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang01_state'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang01_alt' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang01_alt'],
			'exclude'		=> true,
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxlength'=>255, 'tl_class'=>'long clr'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'addLang02' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['addLang'],
			'exclude'		=> true,
			'inputType'		=> 'checkbox',
			'eval'			=> array('submitOnChange'=>true),
			'sql'			=> "char(1) NOT NULL default ''"
		),
		'lang02' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang02'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'search'		=> true,
			'eval'			=> array('mandatory'=>true, 'rgxp'=>'alpha', 'maxlength'=>2, 'nospace'=>true),
			'load_callback' => array(
				array('tl_contacts', 'tweakLanguageLabelCallBack')
			),
			'save_callback' => array(
				array('tl_contacts', 'languageToLower')
			),
			'sql'			=> "varchar(2) NOT NULL default ''"
		),
		'lang02_name' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang02_name'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang02_name2' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang02_name2'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang02_longName' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang02_longName'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxLength'=>255, 'tl_class'=>'long clr'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang02_street' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang02_street'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang02_city' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang02_city'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang02_state' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang02_state'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang02_alt' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang02_alt'],
			'exclude'		=> true,
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxlength'=>255, 'tl_class'=>'long clr'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'addLang03' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['addLang'],
			'exclude'		=> true,
			'inputType'		=> 'checkbox',
			'eval'			=> array('submitOnChange'=>true),
			'sql'			=> "char(1) NOT NULL default ''"
		),
		'lang03' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang03'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'search'		=> true,
			'eval'			=> array('mandatory'=>true, 'rgxp'=>'alpha', 'maxlength'=>2, 'nospace'=>true),
			'load_callback' => array(
				array('tl_contacts', 'tweakLanguageLabelCallBack')
			),
			'save_callback' => array(
				array('tl_contacts', 'languageToLower')
			),
			'sql'			=> "varchar(2) NOT NULL default ''"
		),
		'lang03_name' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang03_name'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang03_name2' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang03_name2'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang03_longName' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang03_longName'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxLength'=>255, 'tl_class'=>'long clr'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang03_street' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang03_street'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang03_city' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang03_city'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang03_state' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang03_state'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'lang03_alt' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['lang03_alt'],
			'exclude'		=> true,
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxlength'=>255, 'tl_class'=>'long clr'),
			'sql'			=> "varchar(255) NOT NULL default ''"
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
		// SocialLinks fields
		'socialLinks' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['socialLinks'],
			'exclude'		=> true,
			'inputType'		=> 'multiColumnWizard',
			'eval'			=> array(
				'columnFields'	=> array(
					'channel' 		=> array(
						'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['socialChannel'],
						'inputType'		=> 'select',
						'options_callback'	=> array('tl_contacts', 'getSocialCannels'),
						'eval'			=> array('style'=>'width:160px;margin:0 5px 5px 0','includeBlankOption' => true)),
					'channelLink'	=> array(
						'label'         => &$GLOBALS['TL_LANG']['tl_contacts']['socialChannelLink'],
						'inputType'     => 'text',
						'eval'          => array('style'=>'width:320px','mandatory'=>true))),
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
	public function getSocialCannels(DataContainer $dc)
	{
		$options = array();
		foreach(array('facebook', 'twitter', 'pinterest') as $channel)
		{
			$channelName = $GLOBALS['TL_LANG']['MSC']['tl_contacts']['socialChannels'][$channel];
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
