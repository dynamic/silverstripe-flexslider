<?php

class SlideImageTest extends FlexSliderTest
{
    protected static $use_draft_site = true;

    public function setUp()
    {
        parent::setUp();
    }

    public function testGetCMSFields()
    {
        $object = new SlideImage();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
        $this->assertNotNull($fieldset->dataFieldByName('Name'));
        $this->assertNotNull($fieldset->dataFieldByName('Image'));
    }

    public function testValidateName()
    {
        $object = $this->objFromFixture('SlideImage', 'slide1');
        $object->Name = '';
        $this->setExpectedException('ValidationException');
        $object->write();
    }

    public function testValidateImage()
    {
        $object = $this->objFromFixture('SlideImage', 'slide1');
        $object->ImageID = '';
        $this->setExpectedException('ValidationException');
        $object->write();
    }

    public function testCanView()
    {
        $object = $this->objFromFixture('SlideImage', 'slide1');
        $image = $this->objFromFixture('Image', 'image1');
        $object->ImageID = $image->ID;
        $object->write();
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canView());
        $this->logOut();
        $nullMember = Member::create();
        $nullMember->write();
        $this->assertTrue($object->canView($nullMember));
        $nullMember->delete();
    }

    public function testCanEdit()
    {
        $object = $this->objFromFixture('SlideImage', 'slide1');
        $image = $this->objFromFixture('Image', 'image1');
        $object->ImageID = $image->ID;
        $object->write();
        $objectID = $object->ID;
        $this->logInWithPermission('ADMIN');
        $originalName = $object->Name;
        $this->assertEquals($originalName, 'Hello World');
        $this->assertTrue($object->canEdit());
        $object->Name = 'Changed Name';
        $object->write();
        $testEdit = SlideImage::get()->byID($objectID);
        $this->assertEquals($testEdit->Name, 'Changed Name');
        $this->logOut();
    }

    public function testCanDelete()
    {
        $object = $this->objFromFixture('SlideImage', 'slide1');
        $image = $this->objFromFixture('Image', 'image1');
        $object->ImageID = $image->ID;
        $object->write();
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canDelete());
        $checkObject = $object;
        $object->delete();
        $this->assertEquals($checkObject->ID, 0);
    }

    public function testCanCreate()
    {
        $object = singleton('SlideImage');
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canCreate());
        $this->logOut();
        $nullMember = Member::create();
        $nullMember->write();
        $this->assertFalse($object->canCreate($nullMember));
        $nullMember->delete();
    }

    public function testProvidePermissions()
    {
        $object = singleton('SlideImage');
        $expected = array(
            'Slide_EDIT' => 'Slide Edit',
            'Slide_DELETE' => 'Slide Delete',
            'Slide_CREATE' => 'Slide Create',
        );
        $this->assertEquals($expected, $object->providePermissions());
    }

    public function testImageFileSizeLimit()
    {

        $this->assertEquals(Config::inst()->get('SlideImage', 'flexslider_max_image_size'), 512000);

        Config::inst()->update('SlideImage', 'flexslider_max_image_size', 1024000);

        $this->assertEquals(Config::inst()->get('SlideImage', 'flexslider_max_image_size'), 1024000);

    }
}
