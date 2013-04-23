<?php

class FlexSlider extends DataExtension {

	static $db = array(
		'SliderWidth' => 'Int',
		'SliderHeight' => 'Int'
	);
	
	static $has_many = array(
		'Slides' => 'SlideImage'
	);
	
	static $defaults = array(
		'SliderWidth' => 350,
		'SliderHeight' => 350
	);
	
	public function updateCMSFields(FieldList $fields) {
		
		// Slides
		$config = GridFieldConfig_RelationEditor::create();	
		$config->addComponent(new GridFieldBulkEditingTools());
		$config->addComponent(new GridFieldBulkImageUpload('ImageID', array('Name')));
		$config->addComponent(new GridFieldSortableRows("SortOrder"));
	    
		$PhotosGridField = GridField::create("Slides", "Slides", $this->owner->Slides()->sort('SortOrder'), $config);
	    	    
	    // add FlexSlider, width and height
	    $fields->addFieldsToTab("Root.Slides", array(
	    	TextField::create('SliderWidth', 'Image Width'),
	    	TextField::create('SliderHeight', 'Image Height'),
	    	$PhotosGridField
	    ));
	    		
	}
	
	function contentcontrollerInit($controller) {
		//Requirements::javascript('framework/thirdparty/jquery/jquery.min.js');
		
	}
	
	public function SlideShow() {
		
		$slides = $this->owner->Slides()->sort('SortOrder');
		//debug::show($slides);
		
		return $slides;
		//return $slides->renderWith('FlexSlider');
	}
	
	// set default width/height if not set
	public function onBeforeWrite() {
	
		if (!$this->owner->SliderWidth || $this->owner->SliderWidth == 0) $this->owner->SliderWidth = 350;
		if (!$this->owner->SliderHeight || $this->owner->SliderHeight == 0) $this->owner->SliderHeight = 350;
		
		parent::onBeforeWrite();
	}
			
}