<?php

namespace Dynamic\FlexSlider\Test\Model;

use Dynamic\FlexSlider\Model\Slide;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\Member;

/**
 * Class SlideTest
 * @package Dynamic\FlexSlider\Test\Model
 */
class SlideTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     *
     */
    public function testCanCreate()
    {
        /** @var Member $canCreate */
        $canCreate = $this->objFromFixture(Member::class, 'slide_author');
        /** @var Member $canAdminister */
        $canAdminister = $this->objFromFixture(Member::class, 'slide_admin');
        /** @var Member $noPermission */
        $noPermission = $this->objFromFixture(Member::class, 'slide_no_permission');

        $this->logInAs($canCreate);
        $slide = Slide::singleton();

        $this->assertTrue($slide->canCreate());

        $this->logOut();
        $this->logInAs($canAdminister);

        $this->assertTrue($slide->canCreate());

        $this->logOut();
        $this->logInAs($noPermission);

        $this->assertFalse($slide->canCreate());
        $this->logOut();
    }

    /**
     *
     */
    public function testCanEdit()
    {
        /** @var Slide $slide */
        $slide = $this->objFromFixture(Slide::class, 'base_slide');
        /** @var Member $canCreate */
        $canEdit = $this->objFromFixture(Member::class, 'slide_author');
        /** @var Member $canAdminister */
        $canAdminister = $this->objFromFixture(Member::class, 'slide_admin');
        /** @var Member $noPermission */
        $noPermission = $this->objFromFixture(Member::class, 'slide_no_permission');

        $this->logInAs($canEdit);

        $this->assertTrue($slide->canEdit());

        $this->logOut();
        $this->logInAs($canAdminister);

        $this->assertTrue($slide->canEdit());

        $this->logOut();
        $this->logInAs($noPermission);

        $this->assertFalse($slide->canEdit());
        $this->logOut();
    }

    /**
     *
     */
    public function testCanDelete()
    {
        /** @var Slide $slide */
        $slide = $this->objFromFixture(Slide::class, 'base_slide');
        /** @var Member $canCreate */
        $noDelete = $this->objFromFixture(Member::class, 'slide_author');
        /** @var Member $canAdminister */
        $canAdminister = $this->objFromFixture(Member::class, 'slide_admin');
        /** @var Member $noPermission */
        $noPermission = $this->objFromFixture(Member::class, 'slide_no_permission');

        $this->logInAs($noDelete);

        $this->assertFalse($slide->canDelete());

        $this->logOut();
        $this->logInAs($canAdminister);

        $this->assertTrue($slide->canDelete());

        $this->logOut();
        $this->logInAs($noPermission);

        $this->assertFalse($slide->canDelete());
        $this->logOut();
    }

    public function testCanPublish()
    {
        /** @var Slide $slide */
        $slide = $this->objFromFixture(Slide::class, 'base_slide');
        /** @var Member $canCreate */
        $noPublish = $this->objFromFixture(Member::class, 'slide_author');
        /** @var Member $canAdminister */
        $canAdminister = $this->objFromFixture(Member::class, 'slide_admin');
        /** @var Member $noPermission */
        $noPermission = $this->objFromFixture(Member::class, 'slide_no_permission');

        $this->logInAs($noPublish);

        $this->assertFalse($slide->canPublish());

        $this->logOut();
        $this->logInAs($canAdminister);

        $this->assertTrue($slide->canPublish());

        $this->logOut();
        $this->logInAs($noPermission);

        $this->assertFalse($slide->canPublish());
        $this->logOut();
    }
}
