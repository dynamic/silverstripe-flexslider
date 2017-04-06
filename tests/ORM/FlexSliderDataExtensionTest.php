<?php

namespace Dynamic\FlexSlider\Test\ORM;

use Dynamic\FlexSlider\Test\FlexSliderTest;
use Dynamic\FlexSlider\ORM\FlexSlider;
use SilverStripe\Core\Config\Config;
use Dynamic\FlexSlider\Test\TestOnly\TestOnlyPage;
use SilverStripe\ORM\DataList;

/**
 * Class FlexSliderDataExtensionTest
 * @package Dynamic\FlexSlider\Test\ORM
 */
class FlexSliderDataExtensionTest extends FlexSliderTest
{

    protected static $extra_dataobjects = array(
        TestOnlyPage::class,
    );

    public function testTabNameConfig()
    {
        $page = new TestOnlyPage();
        $page->write();
        $extension = new FlexSlider();
        $pageFields = $page->getCMSFields();
        $extension->updateCMSFields($pageFields);
        $this->assertNotNull($pageFields->fieldByName('Slides'));

        Config::modify()
            ->set(TestOnlyPage::class, 'slide_tab_title', 'MyCustomSlideTitle');
        $page2 = TestOnlyPage::create();
        $page2->write();
        $page2Fields = $page2->getCMSFields();
        $extension->updateCMSFields($page2Fields);
        $this->assertNull($page2Fields->fieldByName('Root.Slides'));
        $this->assertNotNull($page2Fields->fieldByName('Root.MyCustomSlideTitle'));
    }

    public function testUpdateCMSFields()
    {
        $extension = new FlexSlider();
        $object = TestOnlyPage::create();
        $fields = $object->getCMSFields();
        $extension->updateCMSFields($fields);
        $this->assertNull($fields->dataFieldByName('Slides'));

        $object->write();
        $fields = $object->getCMSFields();
        $extension->updateCMSFields($fields);
        $this->assertNotNull($fields->dataFieldbyName('Slides'));
    }

    public function testGetSlideShow()
    {
        $object = singleton(TestOnlyPage::class);
        $object->write();
        $slide1 = $this->objFromFixture(
            'Dynamic\\FlexSlider\\Model\\SlideImage',
            'slide1'
        );
        /*$image = $this->objFromFixture('Image', 'image1');
        $slide1->ImageID = $image->ID;*/
        $object->Slides()->add($slide1);
        $slides = $object->SlideShow();
        $this->assertInstanceOf(DataList::class, $slides);
    }
}
