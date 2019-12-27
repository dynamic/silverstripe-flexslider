<?php

namespace Dynamic\FlexSlider\Model;

use Sheadawson\Linkable\Forms\EmbeddedObjectField;
use Sheadawson\Linkable\Models\EmbeddedObject;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Forms\FieldList;

/**
 * Class VideoEmbedSlide
 * @package Dynamic\FlexSlider\Model
 */
class VideoEmbedSlide extends Slide
{
    /**
     * @var string
     */
    private static $singular_name = 'Video Embed Slide';

    /**
     * @var string
     */
    private static $plural_name = 'Video Embed Slides';

    /**
     * @var string
     */
    private static $table_name = 'VideoEmbedSlide';

    /**
     * @var array
     */
    private static $has_one = [
        'Video' => EmbeddedObject::class,
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName(['VideoID']);
            $fields->addFieldToTab(
                'Root.Main',
                EmbeddedObjectField::create('Video', 'Video', $this->Video()),
                'Content'
            );
        });

        return parent::getCMSFields();
    }
}
