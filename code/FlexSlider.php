<?php

class FlexSlider extends DataExtension {

	static $db = array(
		'Animation' => "Enum('slide, fade', 'slide')",
		'Loop' => 'Boolean',
		'Animate' => 'Boolean',
		'ThumbnailNav' => 'Boolean'
	);

	static $has_many = array(
		'Slides' => 'SlideImage'
	);

	static $defaults = array(
		'Loop' => '1',
		'Animate' => '1'
	);

	public function populateDefaults() {
		parent::populateDefaults();

		$this->owner->SliderWidth = 640;
		$this->owner->SliderHeight = 400;
		$this->Loop = 1;
		$this->Animate = 1;
	}

	public function updateCMSFields(FieldList $fields) {

		// Slides
		$gridFieldConfig = GridFieldConfig::create()->addComponents(
		   new GridFieldToolbarHeader(),
		   new GridFieldAddNewButton('toolbar-header-right'),
		   new GridFieldSortableHeader(),
		   new GridFieldDataColumns(),
		   new GridFieldPaginator(20),
		   new GridFieldEditButton(),
		   new GridFieldDeleteAction(),
		   new GridFieldDetailForm()
		);
		if (class_exists('GridFieldBulkEditingTools')) {
			$gridFieldConfig->addComponent(new GridFieldBulkEditingTools());
			$gridFieldConfig->addComponent(new GridFieldBulkImageUpload('ImageID', array('Name')));
		}
		if (class_exists('GridFieldSortableRows')) $gridFieldConfig->addComponent(new GridFieldSortableRows("SortOrder"));

		$SlidesField = GridField::create("Slides", "Slides", $this->owner->Slides()->sort('SortOrder'), $gridFieldConfig);

	    // add FlexSlider, width and height
	    $fields->addFieldsToTab("Root.Slides", array(
	    	$SlidesField,
	    	HeaderField::create('Config', 'Configuration', 3),
	    	CheckboxField::create('Animate', 'Animate automatically'),
	    	DropdownField::create('Animation', 'Animation option', $this->owner->dbObject('Animation')->enumValues()),
	    	CheckboxField::create('Loop', 'Loop the carousel'),
	    	CheckboxField::create('ThumbnailNav')->setTitle('Thumbnail Navigation')
	    ));

	}

	function contentcontrollerInit($controller) {
		//Requirements::javascript('framework/thirdparty/jquery/jquery.min.js');

	}

	public function SlideShow() {

		$slides = $this->owner->Slides()->filter(array('ShowSlide'=>1))->sort('SortOrder');

		return $slides;
		//return $slides->renderWith('FlexSlider');
	}

}
