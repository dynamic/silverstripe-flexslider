<?php

namespace Dynamic\FlexSlider\Test\Model;

use Dynamic\FlexSlider\Test\FlexSliderTest;
use Dynamic\FlexSlider\Model\SlideImage;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Security\Member;
use SilverStripe\Core\Config\Config;

/**
 * Class SlideImageTest
 * @package Dynamic\FlexSlider\Test\Model
 */
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
        $this->assertInstanceOf(FieldList::class, $fieldset);
        $this->assertNotNull($fieldset->dataFieldByName('Name'));
        $this->assertNotNull($fieldset->dataFieldByName('Image'));
    }

    public function testValidateName()
    {
        $object = $this->objFromFixture(
            'Dynamic\\FlexSlider\\Model\\SlideImage',
            'slide1'
        );
        $object->Name = '';
        $this->setExpectedException(ValidationException::class);
        $object->write();
    }

    public function testValidateImage()
    {
        $object = $this->objFromFixture(
            'Dynamic\\FlexSlider\\Model\\SlideImage',
            'slide1'
        );
        $object->ImageID = '';
        $this->setExpectedException(ValidationException::class);
        $object->write();
    }

    public function testCanView()
    {
        $object = $this->objFromFixture(
            'Dynamic\\FlexSlider\\Model\\SlideImage',
            'slide1'
        );
        /*$image = $this->objFromFixture('Image', 'image1');
        $object->ImageID = $image->ID;
        $object->write();*/
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
        $this->markTestSkipped('Need better understanding of new File system');
        /*$object = $this->objFromFixture(
            'Dynamic\\FlexSlider\\Model\\SlideImage',
            'slide1'
        );
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
        $this->logOut();*/
    }

    public function testCanDelete()
    {
        $object = $this->objFromFixture(
            'Dynamic\\FlexSlider\\Model\\SlideImage',
            'slide1'
        );
        /*$image = $this->objFromFixture('Image', 'image1');
        $object->ImageID = $image->ID;
        $object->write();*/
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canDelete());
        $checkObject = $object;
        $object->delete();
        $this->assertEquals($checkObject->ID, 0);
    }

    public function testCanCreate()
    {
        $object = singleton(SlideImage::class);
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
        $object = singleton(SlideImage::class);
        $expected = array(
            'Slide_EDIT' => 'Slide Edit',
            'Slide_DELETE' => 'Slide Delete',
            'Slide_CREATE' => 'Slide Create',
        );
        $this->assertEquals($expected, $object->providePermissions());
    }

    public function testImageSizeLimit()
    {

        $default = 512000;
        $this->assertEquals(
            Config::inst()->get(SlideImage::class, 'image_size_limit'),
            $default
        );

        $new = 1024000;
        Config::modify()->set(SlideImage::class, 'image_size_limit', $new);
        $this->assertEquals(Config::inst()
            ->get(SlideImage::class, 'image_size_limit'), $new);
    }

}

