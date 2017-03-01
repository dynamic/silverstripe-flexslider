<?php

class SlideThumbnailNavMigrationTask extends BuildTask
{
    /**
     * @var string
     */
    protected $title = 'FlexSlider Default Values';
    /**
     * @var string
     */
    protected $description = 'Set default values for slider after the thumbnail nav update';
    /**
     * @var bool
     */
    protected $enabled = true;
    /**
     * @param $request
     */
    public function run($request)
    {
        $this->defaultSliderSettings();
    }
    /**
     *
     */
    public function defaultSliderSettings()
    {
        $ct = 0;

        $objects = ClassInfo::subclassesFor('DataObject');
        if ($objects) {
            unset($objects['DataObject']);
            foreach ($objects as $object) {
                if (singleton($object)->hasExtension('FlexSlider')) {
                    foreach ($object::get() as $result) {
                        $result->Loop = 1;
                        $result->Animate = 1;
                        $result->SliderControlNav = 1;
                        $result->SliderDirectionNav = 1;
                        $result->CarouselControlNav = 0;
                        $result->CarouselDirectionNav = 1;
                        $result->CarouselItemWidth = 196;
                        $result->CarouselItemMargin = 10;
                        $result->CarouselThumbnailCt = 4;
                        $result->write();
                        $ct++;
                    }
                }
            }
        }
        echo '<p>'.$ct.' Sliders updated.</p>';
    }
}