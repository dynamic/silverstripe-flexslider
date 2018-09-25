<?php

namespace Dynamic\FlexSlider\Test;

use Dynamic\FlexSlider\Model\SlideImage;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Security\Member;

class SlideImageTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = new SlideImage();
        $fieldset = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fieldset);
        $this->assertNotNull($fieldset->dataFieldByName('Name'));
        $this->assertNotNull($fieldset->dataFieldByName('Image'));
    }

    /**
     *
     */
    public function testValidateName()
    {
        $object = $this->objFromFixture(SlideImage::class, 'slide1');
        $object->Name = '';
        $this->setExpectedException(ValidationException::class);
        $object->write();
    }

    /**
     *
     */
    public function testValidateImage()
    {
        $object = $this->objFromFixture(SlideImage::class, 'slide1');
        $object->ImageID = '';
        $this->setExpectedException(ValidationException::class);
        $object->write();
    }

    /**
     *
     */
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

    /**
     *
     */
    public function testCanCreate()
    {
        $object = $this->objFromFixture(SlideImage::class, 'slide1');
        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canCreate($admin));

        $author = $this->objFromFixture(Member::class, 'author');
        $this->assertTrue($object->canCreate($author));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canCreate($member));
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = $this->objFromFixture(SlideImage::class, 'slide1');
        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canEdit($admin));

        $author = $this->objFromFixture(Member::class, 'author');
        $this->assertTrue($object->canEdit($author));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canEdit($member));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture(SlideImage::class, 'slide1');
        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canDelete($admin));

        $author = $this->objFromFixture(Member::class, 'author');
        $this->assertTrue($object->canDelete($author));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canDelete($member));
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture(SlideImage::class, 'slide1');
        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canView($admin));

        $author = $this->objFromFixture(Member::class, 'author');
        $this->assertTrue($object->canView($author));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertTrue($object->canView($member));
    }

    /**
     *
     */
    public function testImageSizeLimit()
    {
        $default = 512000;
        $this->assertEquals(Config::modify()->get(SlideImage::class, 'image_size_limit'), $default);

        $new = 1024000;
        Config::modify()->update(SlideImage::class, 'image_size_limit', $new);
        $this->assertEquals(Config::modify()->get(SlideImage::class, 'image_size_limit'), $new);
    }
}
