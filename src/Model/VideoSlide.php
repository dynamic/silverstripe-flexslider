<?php

namespace Dynamic\FlexSlider\Model;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Forms\FieldList;

/**
 * Class VideoSlide
 * @package Dynamic\FlexSlider\Model
 */
class VideoSlide extends Slide
{
    /**
     * @var string
     */
    private static $singular_name = 'Video Slide';

    /**
     * @var string
     */
    private static $plural_name = 'Video Slides';

    /**
     * @var string
     */
    private static $table_name = 'VideoSlide';

    /**
     * @var array
     */
    private static $has_one = [
        'Video' => File::class,
    ];

    /**
     * @var array
     */
    private static $owns = [
        'Video',
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->addFieldToTab(
                'Root.Main',
                UploadField::create('Video')
                    ->setTitle('Video')
                    ->setDescription('mp4 format')
                    ->setAllowedExtensions(['mp4']),
                'Content'
            );
        });

        return parent::getCMSFields();
    }
}
