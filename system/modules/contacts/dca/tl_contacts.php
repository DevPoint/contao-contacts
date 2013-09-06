<?php

$GLOBALS['TL_DCA']['tl_contacts'] = array(
	
	// Configuration
	'config' => array(
		'dataContainer' => 'Table',
		'switchToEdit' => true
	),
	
	// Liste
	'list' => array(
		'sorting' => array(
			'mode'          => 1,
			'fields'        => array('roomType', 'name'), // Sortierung der Einträge nach Name
			'panelLayout'   => 'search,limit',
			'flag'          => 1
		),
		'label' => array(
			'fields'        => array('name'), // Elemente, die im Panel angezeigt werden
			'format'        => '%s',
            'label_callback'    => array('tl_contacts', 'onLabelCallBack'),
            'group_callback'    => array('tl_contacts', 'onGroupCallBack')
		),
        'global_operations' => array(
                'all' => array(
                    'label'     => &$GLOBALS['TL_LANG']['MSC']['all'],
                    'href'      => 'act=select',
                    'class'     => 'header_edit_all',
                    'attributes' => 'onclick="Backend.getScrollOffset();"'
                )
        ),            
		'operations' => array(
			'edit' => array(
				'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['edit'],
                'href'      => 'act=edit',
				'icon'      => 'edit.gif'
			),
			'delete' => array(
				'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['delete'],
				'href'      => 'act=delete',
				'icon'      => 'delete.gif',
				'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array(
				'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['show'],
				'href'      => 'act=show',
				'icon'      => 'show.gif'
			)	
		),
	),
	
	// Palettes
	'palettes' => array(
		'__selector__'	=> array('addImage'),
        'default'   	=> '{addressLegend},name,name2,nameShortname,address,address2,plz,town;{phoneLegend},phone,mobile,fax,email;{socialLinksLegend},addSocialLinks;'
	),

	// Subpalettes
	'subpalettes' => array(
		'addSocialLinks'	=> 'addSocialLinks',
		'addImage'			=> 'singleSRC,alt,size',
	),
	
	// Fields
	'fields' => array(
		'name' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['name'],
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'maxLength'=>255),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'name2' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['name2'],
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'maxLength'=>255),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'nameShort' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['nameShort'],
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'maxLength'=>255),
			'sql'       => "varchar(32) NOT NULL default ''"
		),
		'address' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['address'],
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'maxLength'=>255),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'address2' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['address2'],
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'maxLength'=>255),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'plz' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['plz'],
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'maxLength'=>8)
			'sql'       => "varchar(8) NOT NULL default ''"
		),
		'town' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['town'],
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'maxLength'=>255),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'countryCode' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['countryCode'],
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'minLength'=>2, 'maxLength'=>2),
			'sql'       => "varchar(2) NOT NULL default ''"
		),
		'phone' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['phone'],
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'maxLength'=>255),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'mobile' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['mobile'],
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'maxLength'=>255),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'fax' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['fax'],
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'maxLength'=>255),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'email' => array(
			'label'     => &$GLOBALS['TL_LANG']['tl_contacts']['email'],
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array('mandatory'=>true, 'maxLength'=>255),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'addSocialLinks' => array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_contacts']['addSocialLinks'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'addImage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_contacts']['addImage'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'singleSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'mandatory'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'alt' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['alt'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'size' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['size'],
			'exclude'                 => true,
			'inputType'               => 'imageSize',
			'options'                 => $GLOBALS['TL_CROP'],
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
	)
);

class tl_contacts extends Backend
{
    protected function getPersonsRangeStr($row)
    {
        $personsDefault = strval($row['personsDefault']);
        $personsMax = (!is_null($row['personsMax'])) ? strval($row['personsMax']) : $personsDefault;
        $personsRangeStr = sprintf($GLOBALS['TL_LANG']['wtc_apartments']['personsCount'], $personsDefault);
        if($personsDefault != $personsMax) 
        {
            $personsRangeStr = sprintf($GLOBALS['TL_LANG']['wtc_apartments']['personsRange'], $personsDefault, $personsMax);
        }
        return $personsRangeStr;
    }
    
    public function onLabelCallBack($row, $label)
    {
        $objCategory = $this->Database->prepare("SELECT c.name FROM tl_wtc_categories c WHERE c.id=?")
                                     ->limit(1)
                                     ->execute($row['category']);
        if($objCategory->numRows)
        {
            $personsRangeStr = $this->getPersonsRangeStr($row);
            $label = $row['name'].' ('.$objCategory->name.', '.$personsRangeStr.')';
        }
        return $label;
    }

    public function onGroupCallBack($group, $mode, $field, $row, $dc)
    {
        return $GLOBALS['TL_LANG']['tl_contacts']['roomTypes'][$row['roomType']];
    }

    public function onRoomTypeOptions(DataContainer $dc)
    {
        $arrSections = array();
        $roomType = $dc->activeRecord->roomType;
        $objCategories = $this->Database->prepare("SELECT c.id, c.name FROM tl_wtc_categories c WHERE c.roomType=?")->execute($roomType);
        while($objCategories->next())
        {
            $arrSections[$objCategories->id] = $objCategories->name;
        }
        return $arrSections;
    }

	public function onSavePersonsCount($value, DataContainer $dc)
    {
        if(!(is_string($value) && strlen($value))) $value = null;
        return $value;
    }
   
}

?>
