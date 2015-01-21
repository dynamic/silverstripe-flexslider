<?php

class SlideImageTest extends FlexSliderTest{

	protected static $use_draft_site = true;

	function setUp(){
		parent::setUp();
	}

	function testSlideImageCreation(){

		$this->logInWithPermission('ADMIN');
		$slide = $this->objFromFixture('SlideImage', 'slide1');

		$this->assertTrue($slide->canCreate());

		$slideID = $slide->ID;

		$this->assertTrue($slideID > 0);

		$getSlide = SlideImage::get()->byID($slideID);
		$this->assertTrue($getSlide->ID == $slideID);

	}

	function testSlideImageDeletion(){

		$this->logInWithPermission('ADMIN');
		$slide = $this->objFromFixture('SlideImage', 'slide2');
		$slideID = $slide->ID;

		$this->assertTrue($slide->canDelete());
		$slide->delete();

		$slides = SlideImage::get()->column('ID');
		$this->assertFalse(in_array($slideID, $slides));

	}


}
