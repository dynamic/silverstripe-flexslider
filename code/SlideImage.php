<?php

class SlideImage extends DataObject {

	//TODO: move to config.yml
	private static $defaults = array(
		'ShowSlide' => true
	);

	public function GridThumb() {
		$Image = $this->Image();
		if ( $Image )
			return $Image->CMSThumbnail();
		else
			return null;
	}

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$ImageField = new UploadField('Image', 'Image');
		$ImageField->getValidator()->allowedExtensions = array('jpg', 'gif', 'png');
		$ImageField->setFolderName('Uploads/SlideImages');
		$ImageField->setConfig('allowedMaxFileNumber', 1);

	   	$fields->addFieldsToTab('Root.Main',array(
	   		new TextField('Name'),
	   		CheckboxField::create('ShowSlide')->setTitle('Show Slide'),
			TextareaField::create('Description'),
			$ImageField,
			new TreeDropdownField("PageLinkID", "Choose a page to link to:", "SiteTree")
		));
		$fields->removeFieldsFromTab('Root.Main',array(
			'SortOrder',
			'PageID'));
		$this->extend('updateCMSFields', $fields);
		return $fields;
	}

	public function Thumbnail() {
		return $this->Image()->CroppedImage(80,80);
	}

	public function Large() {
		if ($this->Image()->GetHeight() > 700) {
			return $this->Image()->SetHeight(700);
		} else {
			return $this->Image();
		}
	}

	public function Slide() {
		if ($this->Page() && $this->Page()->SliderWidth && $this->Page()->SliderHeight) {
			$width = $this->Page()->SliderWidth;
			$height = $this->Page()->SliderHeight;
		} else {
			$width = 640;
			$height = 400;
		}
		return $this->Image()->PaddedImage($width, $height);
	}

	public function CroppedSlide() {
		if ($this->Page() && $this->Page()->SliderWidth && $this->Page()->SliderHeight) {
			$width = $this->Page()->SliderWidth;
			$height = $this->Page()->SliderHeight;
		} else {
			$width = 640;
			$height = 400;
		}
		return $this->Image()->CroppedImage($width, $height);
	}

	public function providePermissions() {
		return array(
			//'Location_VIEW' => 'Read a Location',
			'Slide_EDIT' => 'Edit a Slide',
			'Slide_DELETE' => 'Delete a Slide',
			'Slide_CREATE' => 'Create a Slide'
		);
	}
	function canCreate($member=null) {
		return Permission::check('Slide_CREATE');
	}
	function canEdit($member=null) {
		return Permission::check('Slide_EDIT');
	}
	function canDelete($member=null) {
		return Permission::check('Slide_DELETE');
	}
	function canView($member=null) { return true; }
}
