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
			'fields'	=> array('name','name2'), // Elemente, die im Panel angezeigt werden
			'format'	=> '%s - %s'
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
        'default'   	=> '{addressLegend},name,name2,longName,street,postal,city,state,countryCode;{lang01Legend},addLang01;{phoneLegend},phone,email,mobile,fax;{imageLegend},addImage;{socialLinksLegend},addSocialLinks;'
	),

	// Subpalettes
	'subpalettes' => array(
		//'addSocialLinks'	=> 'addSocialLinks',
		'addLang01'		=> 'lang01,name_lang01,name2_lang01,longName_lang01,street_lang01,city_lang01,state_lang01',
		'addImage'		=> 'singleSRC,alt,size'
	),
	
	// Fields
	'fields' => array(
		'id' => array(
			'sql'			=> "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array(
			'sql'			=> "int(10) unsigned NOT NULL default '0'"
		),
		// Address fields
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
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'long'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'street' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['street'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'postal' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['postal'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>8, 'tl_class'=>'w50'),
			'sql'			=> "varchar(8) NOT NULL default ''"
		),
		'city' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['city'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'state' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['state'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'countryCode' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['countryCode'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>2, 'tl_class'=>'w50'),
			'sql'			=> "varchar(2) NOT NULL default ''"
		),
		// Address fields - language #01
		'addLang01' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['addLang'],
			'exclude'		=> true,
			'inputType'		=> 'checkbox',
			'eval'			=> array('submitOnChange'=>true),
			'sql'			=> "char(1) NOT NULL default ''"
		),
		'lang01' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['language'],
			'exclude'		=> true,
			'inputType'		=> 'text',
			'search'		=> true,
			'eval'			=> array('mandatory'=>true, 'rgxp'=>'alpha', 'maxlength'=>2, 'nospace'=>true),
			//'save_callback' => array(
			//	array('tl_page', 'languageToLower')
			//),
			'sql'			=> "varchar(2) NOT NULL default ''"
		),
		'name_lang01' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['name'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'name2_lang01' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['name2'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'longName_lang01' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['longName'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'long'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'street_lang01' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['street'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'city_lang01' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['city'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'state_lang01' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['state'],
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('mandatory'=>false, 'maxLength'=>255, 'tl_class'=>'w50'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		// Phone fields
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
		'addSocialLinks' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['addSocialLinks'],
			'exclude'		=> true,
			'inputType'		=> 'checkbox',
			'eval'			=> array('submitOnChange'=>true),
			'sql'			=> "char(1) NOT NULL default ''"
		),
		// Image fields
		'addImage' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['addImage'],
			'exclude'		=> true,
			'inputType'		=> 'checkbox',
			'eval'			=> array('submitOnChange'=>true),
			'sql'			=> "char(1) NOT NULL default ''"
		),
		'singleSRC' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['singleSRC'],
			'exclude'		=> true,
			'inputType'		=> 'fileTree',
			'eval'			=> array('fieldType'=>'radio', 'filesOnly'=>true, 'mandatory'=>true),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'alt' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['alt'],
			'exclude'		=> true,
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array('maxlength'=>255, 'tl_class'=>'long'),
			'sql'			=> "varchar(255) NOT NULL default ''"
		),
		'size' => array
		(
			'label'			=> &$GLOBALS['TL_LANG']['tl_contacts']['size'],
			'exclude'		=> true,
			'inputType'		=> 'imageSize',
			'options'		=> $GLOBALS['TL_CROP'],
			'reference'		=> &$GLOBALS['TL_LANG']['MSC'],
			'eval'			=> array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
			'sql'			=> "varchar(64) NOT NULL default ''"
		),
	)
);

class tl_contacts extends Backend
{
   
}

?>
