<?php

namespace Dynamic\flexslider\tasks;

use Dynamic\FlexSlider\ORM\FlexSlider;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

/**
 * Class SlideThumbnailNavMigrationTask
 * @package Dynamic\FlexSlider\Tasks
 */
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
     * @param $class
     * @return \Generator
     */
    protected function getObjectSet($class)
    {
        foreach ($class::get() as $object) {
            yield $object;
        }
    }

    /**
     *
     */
    public function defaultSliderSettings()
    {
        $ct = 0;

        $objects = ClassInfo::subclassesFor(DataObject::class);

        if ($objects) {
            unset($objects[DataObject::class]);
            foreach ($objects as $object) {
                if ($object::singleton()->hasExtension(FlexSlider::class)) {
                    foreach ($this->getObjectSet($object) as $result) {
                        $result->Loop = 1;
                        $result->Animate = 1;
                        $result->SliderControlNav = 1;
                        $result->SliderDirectionNav = 1;
                        $result->CarouselControlNav = 0;
                        $result->CarouselDirectionNav = 1;
                        $result->CarouselThumbnailCt = 6;
                        if ($result instanceof SiteTree || $object::singleton()->hasExtension(Versioned::class)) {
                            $result->writeToStage('Stage');
                            if ($result->isPublished()) {
                                $result->publishRecursive();
                            }
                        } else {
                            $result->write();
                        }
                        $ct++;
                    }
                }
            }
        }
        echo '<p>'.$ct.' Sliders updated.</p>';
    }
}
