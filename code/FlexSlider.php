<?php

class FlexSlider extends DataExtension
{
    /**
     * @var array
     */
    public static $db = array(
        'Animation' => "Enum('slide, fade', 'slide')",
        'Loop' => 'Boolean',
        'Animate' => 'Boolean',
        'ThumbnailNav' => 'Boolean',
    );

    /**
     * @var array
     */
    public static $has_many = array(
        'Slides' => 'SlideImage',
    );

    /**
     * @var array
     */
    public static $defaults = array(
        'Loop' => '1',
        'Animate' => '1',
    );

    /**
     *
     */
    public function populateDefaults()
    {
        parent::populateDefaults();
        $this->Loop = 1;
        $this->Animate = 1;
    }

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(array(
            'Animation',
            'Loop',
            'Animate',
            'ThumbnailNav',
        ));

        // Slides
        if ($this->owner->ID) {
            $config = GridFieldConfig_RecordEditor::create();
            if (class_exists('GridFieldSortableRows')) {
                $config->addComponent(new GridFieldSortableRows('SortOrder'));
            }
            if (class_exists('GridFieldBulkUpload')) {
                $config->addComponent(new GridFieldBulkUpload());
                $config->addComponent(new GridFieldBulkManager());
            }
            $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
            $config->removeComponentsByType('GridFieldDeleteAction');
            $config->addComponent(new GridFieldDeleteAction(false));
            $SlidesField = GridField::create('Slides', 'Slides', $this->owner->Slides()->sort('SortOrder'), $config);

            $slideTitle = $this->owner->stat('slide_tab_title') ? $this->owner->stat('slide_tab_title') : 'Slides';

            $fields->addFieldsToTab("Root.{$slideTitle}", array(
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
    }

    /**
     * @return DataList
     */
    public function SlideShow()
    {
        return $this->owner->Slides()->filter(array('ShowSlide' => 1))->sort('SortOrder');
    }

    /**
     * add requirements to Page_Controller init()
     */
    public function contentcontrollerInit()
    {
        // Flexslider options
        $animate = ($this->owner->Animate) ? 'true' : 'false';
        $loop = ($this->owner->Loop) ? 'true' : 'false';
        $sync = ($this->owner->ThumbnailNav == true) ? '"#carousel"' : false;
        $before = (method_exists($this->owner->ClassName, 'flexSliderBeforeAction'))
            ? $this->owner->flexSliderBeforeAction()
            : 'function(){}';
        $after = (method_exists($this->owner->ClassName, 'flexSliderAfterAction'))
            ? $this->owner->flexSliderAfterAction()
            : 'function(){}';
        $speed = (method_exists($this->owner->ClassName, 'setFlexSliderSpeed'))
            ? $this->owner->setFlexSliderSpeed()
            : 7000;

        $vars = [
            'animate' => $animate,
            'animationType' => $this->owner->Animation,
            'loop' => $loop,
            'sync' => $sync,
            'before' => $before,
            'after' => $after,
            'speed' => $speed,
        ];

        // only call custom script if page has Slides and DataExtension
        if (Object::has_extension($this->owner->ClassName, 'FlexSlider')) {
            if ($this->owner->Slides()->exists()) {
                Requirements::javascriptTemplate('flexslider/javascript/flexslider.init.js', $vars);
            }
        }
    }
}
