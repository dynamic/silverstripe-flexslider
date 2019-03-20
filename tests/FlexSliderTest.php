<?php

namespace Dynamic\FlexSlider\Test;

use Dynamic\FlexSlider\Model\SlideImage;
use Dynamic\FlexSlider\ORM\FlexSlider;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataList;

class FlexSliderTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $extra_dataobjects = array(
        TestPage::class,
    );

    /**
     * @var string
     */
    protected static $fixture_file = 'fixtures.yml';

    /**
     *
     */
    public function testTabNameConfig()
    {
        $page = TestPage::create();
        $page->write();
        $pageFields = $page->getCMSFields();
        $this->assertNotNull($pageFields->dataFieldByName('Slides'));

        Config::modify()
            ->update(TestPage::class, 'slide_tab_title', 'MyCustomSlideTitle');
        $page2 = TestPage::create();
        $page2->write();
        $page2Fields = $page2->getCMSFields();
        $this->assertNull($page2Fields->fieldByName('Root.Slides'));
        $this->assertNotNull($page2Fields->fieldByName('Root.MyCustomSlideTitle'));
    }

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = TestPage::create();
        $fields = $object->getCMSFields();
        $this->assertNull($fields->dataFieldByName('Slides'));

        $object->write();
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNotNull($fields->dataFieldbyName('Slides'));
    }

    /**
     *
     */
    public function testGetSlideshow()
    {
        $object = TestPage::create();
        $object->write();
        $slide1 = $this->objFromFixture(SlideImage::class, 'slide1');
        $image = $this->objFromFixture(Image::class, 'image1');
        $slide1->ImageID = $image->ID;
        $object->Slides()->add($slide1);
        $slides = $object->getSlideShow();
        $this->assertInstanceOf(DataList::class, $slides);
    }

    /**
     *
     */
    public function testGetSlideshowSpeed()
    {
        /** @var \Dynamic\FlexSlider\ORM\FlexSlider|\Page $object */
        $object = TestPage::create();
        $this->assertEquals(7000, $object->getSlideshowSpeed());

        Config::modify()->set(FlexSlider::class, 'FlexSliderSpeed', 5000);
        $this->assertEquals(5000, $object->getSlideshowSpeed());

        $object->config()->set('FlexSliderSpeed', 3000);
        $this->assertEquals(3000, $object->getSlideshowSpeed());

        $object->config()->set('setFlexSliderSpeed', true);
        $this->assertEquals(1000, $object->getSlideshowSpeed());
    }
}
