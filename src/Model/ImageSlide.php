<?php

namespace Dynamic\FlexSlider\Model;

use Dynamic\FlexSlider\Interfaces\SlideInterface;
use Dynamic\ImageUpload\ImageUploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;

/**
 * Class ImageSlide
 * @package Dynamic\FlexSlider\Model
 */
class ImageSlide extends Slide
{
    /**
     * @var string
     */
    private static $singular_name = 'Image Slide';

    /**
     * @var string
     */
    private static $plural_name = 'Image Slides';

    /**
     * @var string
     */
    private static $table_name = 'ImageSlide';

    /**
     * @var array
     */
    private static $has_one = [
        'Image' => Image::class,
    ];

    /**
     * @var array
     */
    private static $owns = [
        'Image',
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->addFieldToTab(
                'Root.Main',
                ImageUploadField::create('Image')
                    ->setTitle('Image'),
                'Content'
            );
        });

        return parent::getCMSFields();
    }
}
