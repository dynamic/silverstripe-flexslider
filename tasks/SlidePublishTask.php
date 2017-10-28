<?php

namespace Dynamic\flexslider\tasks;

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
    protected $description = 'Migration task - pre versioning on SlideImage';

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
                $title = $slide->Title;
                $slide->writeToStage('Stage');
                $slide->publish('Stage', 'Live');
                echo $title.'<br><br>';
                ++$ct;
            }
        }
        echo '<p>'.$ct.' slides updated.</p>';
    }
}
