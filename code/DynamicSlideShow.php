<?php

class DynamicSlideShow extends DataExtension {
	
	static $has_many = array(
		'Slides' => 'SlideImage'
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
		$PhotosGridField = new GridField("Slides", "SlideImage", $this->owner->Slides(), $PhotosGridFieldConfig);
		
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
	    
	    $fields->addFieldToTab("Root.Slides", $PhotosGridField);
		
	}
	
	public function getSlideList() {
		return $this->owner->Slides()->sort('SortOrder');
	}
	
	
		
}