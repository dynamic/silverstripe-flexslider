<?php

namespace Dynamic\FlexSlider\ORM;

use Dynamic\FlexSlider\Model\SlideImage;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\Requirements;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class FlexSlider
 * @package Dynamic\FlexSlider\ORM
 * @property string $Animation
 * @property bool $Loop
 * @property bool $Animate
 * @property bool $ThumbnailNav
 * @property bool $SliderControlNav
 * @property bool $CarouselControlNav
 * @property bool $CarouselDirectionNav
 * @property int $CarouselThumbnailCt
 */
class FlexSlider extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'Animation' => "Enum('slide, fade', 'slide')",
        'Loop' => 'Boolean',
        'Animate' => 'Boolean',
        'ThumbnailNav' => 'Boolean',
        'SliderControlNav' => 'Boolean',
        'SliderDirectionNav' => 'Boolean',
        'CarouselControlNav' => 'Boolean',
        'CarouselDirectionNav' => 'Boolean',
        'CarouselThumbnailCt' => 'Int',
    );

    /**
     * @var array
     */
    private static $has_many = array(
        'Slides' => SlideImage::class,
    );

    /**
     *
     */
    public function populateDefaults()
    {
        parent::populateDefaults();
        $this->owner->Loop = 1;
        $this->owner->Animate = 1;
        $this->owner->SliderControlNav = 0;
        $this->owner->SliderDirectionNav = 1;
        $this->owner->CarouselControlNav = 0;
        $this->owner->CarouselDirectionNav = 1;
        $this->owner->CarouselThumbnailCt = 6;
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
            'SliderControlNav',
            'SliderDirectionNav',
            'CarouselControlNav',
            'CarouselDirectionNav',
            'CarouselThumbnailCt',
            'Slides'
        ));

        // Slides
        if ($this->owner->ID) {
            $config = GridFieldConfig_RecordEditor::create();
            $config->addComponent(new GridFieldOrderableRows('SortOrder'));
            $config->removeComponentsByType([
                GridFieldAddExistingAutocompleter::class,
                GridFieldDeleteAction::class,
            ]);
            $SlidesField = GridField::create(
                'Slides',
                _t(__CLASS__ . '.SLIDES', 'Slides'),
                $this->owner->Slides()->sort('SortOrder'),
                $config
            );

            $slideTitle = $this->owner->stat('slide_tab_title') ?: _t(__CLASS__ . '.SLIDES', 'Slides');

            $animations = array();
            $animationOptions = $this->owner->dbObject('Animation')->getEnum();
            foreach ($animationOptions as $value) {
                $animations[$value] = _t(__CLASS__ . ".$value", $value);
            }

            $fields->addFieldsToTab("Root.{$slideTitle}", array(
                $SlidesField,
                ToggleCompositeField::create('ConfigHD', _t(__CLASS__.'.SettingsLabel', 'Slider Settings'), array(
                    DropdownField::create(
                        'Animation',
                        _t(__CLASS__ . '.ANIMATION_OPTION', 'Animation option'),
                        $animations
                    ),
                    CheckboxField::create(
                        'Animate',
                        _t(__CLASS__ . '.ANIMATE', 'Animate automatically')
                    ),
                    CheckboxField::create(
                        'Loop',
                        _t(__CLASS__ . '.LOOP', 'Loop the carousel')
                    ),
                    CheckboxField::create(
                        'SliderControlNav',
                        _t(__CLASS__ . '.CONTROL_NAV', 'Show ControlNav')
                    ),
                    CheckboxField::create(
                        'SliderDirectionNav',
                        _t(__CLASS__ . '.DIRECTION_NAV', 'Show DirectionNav')
                    ),
                    CheckboxField::create(
                        'ThumbnailNav',
                        _t(__CLASS__ . '.THUMBNAIL_NAV', 'Thumbnail Navigation')
                    ),
                    //DisplayLogicWrapper::create(
                    CheckboxField::create(
                        'CarouselControlNav',
                        _t(__CLASS__ . '.CAROUSEL_CONTROL_NAV', 'Show Carousel ControlNav')
                    ),
                    CheckboxField::create(
                        'CarouselDirectionNav',
                        _t(__CLASS__ . '.CAROUSEL_DIRECTION_NAV', 'Show Carousel DirectionNav')
                    ),
                    NumericField::create(
                        'CarouselThumbnailCt',
                        _t(__CLASS__ . '.CAROUSEL_THUMBNAIL_COUNT', 'Number of thumbnails')
                    )
                    //)->displayIf('ThumbnailNav')->isChecked()->end()
                )),
            ));
        }
    }

    /**
     * @return mixed
     */
    public function getSlideShow()
    {
        $owner = $this->owner;

        if (!($owner instanceof SiteTree)) {
            $this->getCustomScript();
        }

        return $this->owner->Slides()->sort('SortOrder');
    }

    /**
     * add requirements to PageController init()
     */
    public function contentcontrollerInit()
    {
        // only call custom script if page has Slides and DataExtension
        if (DataObject::has_extension($this->owner->Classname, FlexSlider::class)) {
            if ($this->owner->getSlideShow()->exists()) {
                $this->getCustomScript();
            }
        }
    }

    /**
     *
     */
    public function getCustomScript()
    {
        // Flexslider options
        $sync = ($this->owner->ThumbnailNav == true) ? "sync: '.carousel:eq('+index+')'," : '';

        $before = $this->owner->hasMethod('flexSliderBeforeAction')
            ? $this->owner->flexSliderBeforeAction()
            : 'function(){}';

        $after = $this->owner->hasMethod('flexSliderAfterAction')
            ? $this->owner->flexSliderAfterAction()
            : 'function(){}';

        $speed = $this->getSlideshowSpeed();

        Requirements::customScript(
            "(function($) {
                $(document).ready(function(){
                    jQuery('.flexslider').each(function(index){
					 
                         if(jQuery('.carousel').eq(index).length) {
                             jQuery('.carousel').eq(index).flexslider({
                                slideshow: " . $this->owner->obj('Animate')->NiceAsBoolean() . ",
                                animation: 'slide',
                                animationLoop: " . $this->owner->obj('Loop')->NiceAsBoolean() . ",
                                controlNav: " . $this->owner->obj('CarouselControlNav')->NiceAsBoolean() . ", 
                                directionNav: " . $this->owner->obj('CarouselDirectionNav')->NiceAsBoolean() . ",
                                prevText: '',
                                nextText: '',
                                pausePlay: false,
                                asNavFor: '.flexslider:eq('+index+')',
                                minItems: " . $this->owner->obj('CarouselThumbnailCt') . ",
                                maxItems: " . $this->owner->obj('CarouselThumbnailCt') . ",
                                move: " . $this->owner->obj('CarouselThumbnailCt') . ",
                                itemWidth: 100,
                                itemMargin: 10
                              });
                         }
 
                        if(jQuery('.flexslider').eq(index).length){
                            jQuery('.flexslider').eq(index).flexslider({
                                slideshow: " . $this->owner->obj('Animate')->NiceAsBoolean() . ",
                                animation: '" . $this->owner->Animation . "',
                                animationLoop: " . $this->owner->obj('Loop')->NiceAsBoolean() . ",
                                controlNav: " . $this->owner->obj('SliderControlNav')->NiceAsBoolean() . ",
                                directionNav: " . $this->owner->obj('SliderDirectionNav')->NiceAsBoolean() . ",
                                prevText: '',
                                nextText: '',
                                pauseOnAction: true,
                                pauseOnHover: true,
                                " . $sync . "
                                start: function(slider){
                                  $('body').removeClass('loading');
                                },
                                before: " . $before . ',
                                after: ' . $after . ',
                                slideshowSpeed: ' . $speed . ' 
                            });
                        }
                    })
                });
            }(jQuery));'
        );
    }

    /**
     * @return int
     */
    public function getSlideshowSpeed()
    {
        if ($this->owner->hasMethod('setFlexSliderSpeed') && $this->owner->setFlexSliderSpeed()) {
            return $this->owner->setFlexSliderSpeed();
        }

        // check the config for an integer
        $configSpeed = $this->owner->config()->get('FlexSliderSpeed');
        if ($configSpeed && (int) $configSpeed == $configSpeed) {
            return (int) $this->owner->config()->get('FlexSliderSpeed');
        }

        return Config::inst()->get(self::class, 'FlexSliderSpeed');
    }

    /**
     *
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if (!$this->owner->CarouselThumbnailCt) {
            $this->owner->CarouselThumbnailCt = 6;
        }
    }
}
