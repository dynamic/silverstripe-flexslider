<?php

namespace Dynamic\flexslider\Task;

use Dynamic\FlexSlider\ORM\FlexSlider;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Director;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DataObject;
use SilverStripe\PolyExecution\PolyOutput;
use SilverStripe\Versioned\Versioned;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class SlideThumbnailNavMigrationTask
 * @package Dynamic\FlexSlider\Tasks
 */
class SlideThumbnailNavMigrationTask extends BuildTask
{
    /**
     * @var string
     */
    protected string $title = 'FlexSlider - Default Values';

    /**
     * @var string
     */
    protected string $description = 'Set default values for slider after the thumbnail nav update';

    /**
     * @var string
     */
    private static $segment = 'slide-thumbnail-nav-migration-task';

    /**
     * @var bool
     */
    protected $enabled = true;

    /**
     * @param InputInterface $input
     * @param PolyOutput $output
     */
    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $this->defaultSliderSettings();
        return 0;
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
                        $result->SliderControlNav = 0;
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
        static::write_message($ct . " Sliders updated");
    }

    /**
     * @param $message
     */
    protected static function write_message($message)
    {
        if (Director::is_cli()) {
            echo "{$message}\n";
        } else {
            echo "{$message}<br><br>";
        }
    }
}
