<?php

namespace Dynamic\FlexSlider\Test;

use Dynamic\FlexSlider\Model\SlideImage;
use Sheadawson\Linkable\Forms\EmbeddedObjectField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Security\Member;

/**
 * Class SlideImageTest
 * @package Dynamic\FlexSlider\Test
 */
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
        $object = SlideImage::singleton();
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertInstanceOf(TextField::class, $fields->dataFieldByName('Name'));
        $this->assertInstanceOf(UploadField::class, $fields->dataFieldByName('Image'));
        $this->assertInstanceOf(EmbeddedObjectField::class, $fields->dataFieldByName('Video'));
        $this->assertInstanceOf(TextareaField::class, $fields->dataFieldByName('Description'));
    }

    /**
     * @throws ValidationException
     */
    public function testValidateName()
    {
        $object = $this->objFromFixture(SlideImage::class, 'slide1');
        $object->Name = '';
        $object->ImageID = 1;
        $this->setExpectedException(ValidationException::class);
        $object->write();

        $object->Name = 'Foo';
        $this->assertGreaterThan(0, $object->write());
    }

    /**
     * @throws ValidationException
     */
    public function testValidateImage()
    {
        $object = $this->objFromFixture(SlideImage::class, 'slide1');
        $object->ImageID = null;
        $this->setExpectedException(ValidationException::class);
        $object->write();

        $base->ImageID = 1;
        $this->assertGreaterThan(0, $object->write());
    }

    /**
     * @throws ValidationException
     */
    public function testValidateVideo()
    {
        $object = $this->objFromFixture(SlideImage::class, 'slide2');
        $object->VideoID = null;
        $this->setExpectedException(ValidationException::class);
        $object->write();

        $object->VideoID = 1;
        $this->assertGreaterThan(0, $object->write());
    }

    /**
     * @throws ValidationException
     */
    public function testValidateText()
    {
        $object = $this->objFromFixture(SlideImage::class, 'slide3');
        $description = $object->Description;

        $object->Description = null;
        $this->setExpectedException(ValidationException::class);
        $object->write();

        $object->Description = $description;
        $this->assertGreaterThan(0, $object->write());
    }

    /**
     *
     */
    public function testProvidePermissions()
    {
        $object = SlideImage::singleton();

        $expected = [
            'Slide_EDIT' => 'Slide Edit',
            'Slide_DELETE' => 'Slide Delete',
            'Slide_CREATE' => 'Slide Create',
        ];

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

    /**
     *
     */
    public function testRenderWith()
    {
        $this->markTestSkipped("Todo SlideImageText::testRenderWith()");
        //$slide = SlideImage::singleton();

        //$this->assertInstanceOf(DBHTMLText::class, $slide->renderWith());
    }

    /**
     *
     */
    public function testForTemplate()
    {
        $this->markTestSkipped("Todo SlideImageText::testForTemplate()");
        //$slide = SlideImage::singleton();

        //$this->assertInstanceOf(DBHTMLText::class, $slide->forTemplate());
    }
}
