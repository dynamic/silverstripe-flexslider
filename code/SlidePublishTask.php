<?php

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
                if (!$slide->Name) {
                    $slide->Name = ($slide->Headline) ? $slide->Headline : 'New Slide';
                }
                $slide->writeToStage('Stage');
                $slide->publish('Stage', 'Live');
                echo '<p>' . $slide->Name . '</p>';
                ++$ct;
            }
        }
        echo '<h3>'.$ct.' slides updated.</h3>';
    }
}