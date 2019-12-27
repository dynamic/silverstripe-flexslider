<?php

namespace Dynamic\FlexSlider\Test\Model;

use Dynamic\FlexSlider\Model\SlideImage;
use Sheadawson\Linkable\Forms\EmbeddedObjectField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;

/**
 * Class SlideImageTest
 * @package Dynamic\FlexSlider\Test
 */
class SlideImageTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = SlideImage::singleton();
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertInstanceOf(TextField::class, $fields->dataFieldByName('Name'));
        $this->assertInstanceOf(UploadField::class, $fields->dataFieldByName('Image'));
        $this->assertInstanceOf(EmbeddedObjectField::class, $fields->dataFieldByName('Video'));
        $this->assertInstanceOf(TextareaField::class, $fields->dataFieldByName('Description'));
    }
}
