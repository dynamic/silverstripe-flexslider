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
		$PhotosGridFieldConfig = GridFieldConfig::create()->addComponents(
			new GridFieldToolbarHeader(),
			new GridFieldSortableHeader(),
			new GridFieldDataColumns(),
			new GridFieldPaginator(10),
			new GridFieldEditButton(),
			new GridFieldDeleteAction(),
			new GridFieldDetailForm(),
			new GridFieldBulkEditingTools(),
			new GridFieldBulkImageUpload(),
			new GridFieldSortableRows("SortOrder")
		);
		$PhotosGridField = new GridField("Slides", "SlideImage", $this->owner->Slides()->sort('SortOrder'), $PhotosGridFieldConfig);
		
		/*
		$gridFieldConfig = GridFieldConfig_RelationEditor::create()->addComponents(
	    	new GridFieldSortableRows('SortOrder')
	    );
	    $gridFieldConfig->getComponentByType('GridFieldAddExistingAutocompleter')
	    	->setSearchFields(array('Name'))
	    	//->setResultsFormat('$Firstname - $Surname')
	    	; 
	    $SlidesField = new GridField("Slides", "Slides", $this->owner->Slides()->sort('SortOrder'), $gridFieldConfig);
	    */
	    // add FlexSlider, width and height
	    $fields->addFieldsToTab("Root.Slides", array(
	    	TextField::create('SliderWidth', 'Slideshow width'),
	    	TextField::create('SliderHeight', 'Slideshow height'),
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