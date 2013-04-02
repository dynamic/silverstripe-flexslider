<?php

class SlideImage extends DataObject {

	static $db = array(
		"Name" => "Text",
		'SortOrder' => 'Int'
	);
	
	static $has_one = array(
		"Image" => "Image",
		"Page" => "Page",
		"PageLink" => "SiteTree"
	);
	
	static $singular_name = "Slide";
	static $plural_name = "Slides";
	
	static $default_order = "SortOrder";
	
	static $summary_fields = array (
		'Name' => 'Caption',
		'GridThumb' => 'Image'
	);
	
	public function GridThumb() {
		$Image = $this->Image();
		if ( $Image ) 
			return $Image->CMSThumbnail();
		else 
			return null;
	}
	
	function getCMSFields() {
	
		$ImageField = new UploadField('Image', 'Image');
		$ImageField->getValidator()->allowedExtensions = array('jpg', 'gif', 'png');
		$ImageField->setFolderName('Uploads/SlideImages');
		$ImageField->setConfig('allowedMaxFileNumber', 1);
	   	
	   	return new FieldList(
			new TextField('Name'),
			$ImageField,
			new TreeDropdownField("PageLinkID", "Choose a page to link to:", "SiteTree")
		);
	}
	
	/*
	function getCMSFields_forPopup() {
		return new FieldSet(
			new TextField('Name'),
			new ImageField('Image')
			//new DropDown($this->ID,'Product No')
		);
	}
	*/
   
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
			$width = 350;
			$height = 350;
		}
		return $this->Image()->PaddedImage($width, $height);
	}
	
	function canCreate($member=null) {return true;} 
	function canEdit($member=null) {return true;} 
	function canDelete($member=null) {return true;}
}