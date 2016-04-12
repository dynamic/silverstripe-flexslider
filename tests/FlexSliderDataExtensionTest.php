<?php

class FlexSliderDataExtensionTest extends FlexSliderTest
{
    public function testUpdateCMSFields()
    {
        $extension = new FlexSlider();
        $object = Page::create();
        $fields = $object->getCMSFields();
        $extension->updateCMSFields($fields);
        $this->assertNull($fields->dataFieldByName('Slides'));

        $object->write();
        $fields = $object->getCMSFields();
        $extension->updateCMSFields($fields);
        $this->assertNotNull($fields->dataFieldbyName('Slides'));
    }

    public function testGetSlideshow()
    {
        $object = singleton('Page');
        $object->write();
        $slide1 = $this->objFromFixture('SlideImage', 'slide1');
        $image = $this->objFromFixture('Image', 'image1');
        $slide1->ImageID = $image->ID;
        $object->Slides()->add($slide1);
        $slides = $object->SlideShow();
        $this->assertInstanceOf('DataList', $slides);
    }
}


Page::add_extension('FlexSlider');