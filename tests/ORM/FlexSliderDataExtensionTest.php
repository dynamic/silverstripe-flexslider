<?php

namespace Dynamic\FlexSlider\Test\ORM;

use Dynamic\FlexSlider\Test\FlexSliderTest;
use Dynamic\FlexSlider\ORM\FlexSlider;
use SilverStripe\Core\Config\Config;
use Dynamic\FlexSlider\Test\TestOnly\TestOnlyPage;
use SilverStripe\ORM\DataList;
use SilverStripe\Core\Injector\Injector;

/**
 * Class FlexSliderDataExtensionTest
 * @package Dynamic\FlexSlider\Test\ORM
 */
class FlexSliderDataExtensionTest extends FlexSliderTest
{

    /**
     * @var array
     */
    protected static $extra_dataobjects = array(
        TestOnlyPage::class,
    );

    public function testTabNameConfig()
    {
        $page = TestOnlyPage::create();
        $page->write();
        $pageFields = $page->getCMSFields();
        //$extension->updateCMSFields($pageFields);
        $this->assertNotNull($pageFields->fieldByName('Slides'));

        Config::modify()
            ->set(TestOnlyPage::class, 'slide_tab_title', 'MyCustomSlideTitle');
        $page2 = TestOnlyPage::create();
        $page2->write();
        $page2Fields = $page2->getCMSFields();
        //$extension->updateCMSFields($page2Fields);
        $this->assertNull($page2Fields->fieldByName('Root.Slides'));
        $this->assertNotNull($page2Fields->fieldByName('Root.MyCustomSlideTitle'));
    }

    public function testUpdateCMSFields()
    {
        $object = TestOnlyPage::create();
        $object->write();
        $fields = $object->getCMSFields();
        $this->assertNotNull($fields->dataFieldbyName('Slides'));
    }

    public function testGetSlideShow()
    {
        $object = TestOnlyPage::create();
        $object->write();
        $slide1 = $this->objFromFixture(
            'Dynamic\\FlexSlider\\Model\\SlideImage',
            'slide1'
        );
        /*$image = $this->objFromFixture('Image', 'image1');
        $slide1->ImageID = $image->ID;*/
        $object->Slides()->add($slide1);
        $slides = $object->getSlideShow();
        $this->assertInstanceOf(DataList::class, $slides);
    }
}
