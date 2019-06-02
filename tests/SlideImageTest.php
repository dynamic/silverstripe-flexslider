<?php

namespace Dynamic\FlexSlider\Test;

use Dynamic\FlexSlider\Model\SlideImage;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ValidationException;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Security\Member;

class SlideImageTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'fixtures.yml';

    /**
     * @var array
     */
    protected static $extra_dataobjects = [
        TestPage::class,
    ];

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
        $this->expectException(ValidationException::class);
        $object->write();
    }

    /**
     *
     */
    public function testValidateImage()
    {
        /** @var SlideImage $object */
        $object = $this->objFromFixture(SlideImage::class, 'slide1');
        $object->Name = 'Test';
        $object->ImageID = 0;

        // test valid if require_image is default(true) on SlideImage
        $object->config()->set('require_image', true);
        $result = $object->validate();
        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertFalse($result->isValid());
        $this->assertContains([
            'message' => 'An Image is required before you can save',
            'fieldName' => null,
            'messageType' => 'error',
            'messageCast' => 'text',
        ], $result->getMessages());

        // test valid if require_image is false on SlideImage
        $object->config()->set('require_image', false);
        $result = $object->validate();
        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertTrue($result->isValid());

        // TestPage init
        /** @var \Dynamic\FlexSlider\Test\TestPage $page */
        $page = Injector::inst()->get(TestPage::class);
        $object->PageID = $page->ID;

        // test valid if require_image is true on TestPage
        $object->config()->set('require_image', true);
        $page->config()->set('require_image', false);
        $result = $object->validate();
        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertTrue($result->isValid());

        // test valid if require_image is false on TestPage
        $object->config()->set('require_image', true);
        $page->config()->set('require_image', true);
        $result = $object->validate();
        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertFalse($result->isValid());
        $this->assertContains([
            'message' => 'An Image is required before you can save',
            'fieldName' => null,
            'messageType' => 'error',
            'messageCast' => 'text',
        ], $result->getMessages());
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
