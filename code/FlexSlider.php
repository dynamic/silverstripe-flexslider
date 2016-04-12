<?php

class FlexSlider extends DataExtension
{
    public static $db = array(
        'Animation' => "Enum('slide, fade', 'slide')",
        'Loop' => 'Boolean',
        'Animate' => 'Boolean',
        'ThumbnailNav' => 'Boolean',
    );

    public static $has_many = array(
        'Slides' => 'SlideImage',
    );

    public static $defaults = array(
        'Loop' => '1',
        'Animate' => '1',
    );

    public function populateDefaults()
    {
        parent::populateDefaults();
        $this->Loop = 1;
        $this->Animate = 1;
    }

    public function updateCMSFields(FieldList $fields)
    {
        // Slides
        $config = GridFieldConfig_RecordEditor::create();
        if (class_exists('GridFieldSortableRows')) {
            $config->addComponent(new GridFieldSortableRows('SortOrder'));
        }
        $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
        $config->removeComponentsByType('GridFieldDeleteAction');
        $config->addComponent(new GridFieldDeleteAction(false));
        $SlidesField = GridField::create('Slides', 'Slides', $this->owner->Slides()->sort('SortOrder'), $config);

        $fields->addFieldsToTab('Root.Slides', array(
            HeaderField::create('SliderHD', 'Slides', 3),
            $SlidesField,
            ToggleCompositeField::create('ConfigHD', 'Slider Settings', array(
                CheckboxField::create('Animate', 'Animate automatically'),
                DropdownField::create('Animation', 'Animation option', $this->owner->dbObject('Animation')->enumValues()),
                CheckboxField::create('Loop', 'Loop the carousel'),
                //CheckboxField::create('ThumbnailNav', 'Thumbnail Navigation'),
            )),
        ));
    }

    public function SlideShow()
    {
        return $this->owner->Slides()->filter(array('ShowSlide' => 1))->sort('SortOrder');
    }
}
