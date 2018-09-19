<?php

namespace Dynamic\Flexslider\Tasks;

use Dynamic\FlexSlider\Model\SlideImage;
use SilverStripe\Control\Director;
use SilverStripe\Dev\BuildTask;

/**
 * Class SlidePublishTask
 * @package Dynamic\FlexSlider\Tasks
 */
class SlidePublishTask extends BuildTask
{
    /**
     * @var string
     */
    protected $title = 'Publish all SlideImages';

    /**
     * @var string
     */
    protected $description = 'Migration task - pre versioning on SlideImage (3.x)';

    /**
     * @var bool
     */
    protected $enabled = true;

    /**
     * @param $request
     */
    public function run($request)
    {
        $this->publishSlides();
    }

    /**
     * mark all ProductDetail records as ShowInMenus = 0.
     */
    public function publishSlides()
    {
        $slides = SlideImage::get();
        $ct = 0;
        foreach ($slides as $slide) {
            if ($slide->ShowSlide == 1) {
                if (!$slide->Name) {
                    $slide->Name = "No Name";
                }
                $title = $slide->Name;
                $slide->writeToStage('Stage');
                $slide->publish('Stage', 'Live');
                static::write_message($slide->Name . " updated");
                ++$ct;
            }
        }
        static::write_message($ct . " SlideImages updated");
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
