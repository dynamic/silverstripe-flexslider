<?php

class SlideImage extends DataObject implements PermissionProvider
{
    //TODO: move to config.yml
    private static $defaults = array(
        'ShowSlide' => true,
    );

    public function getCMSFields()
    {
		$fields = parent::getCMSFields();
		$ImageField = new UploadField('Image', 'Image');
		$ImageField->getValidator()->allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
		$ImageField->setFolderName('Uploads/SlideImages');
		$ImageField->setConfig('allowedMaxFileNumber', 1);
		$ImageField->getValidator()->setAllowedMaxFileSize(FLEXSLIDER_IMAGE_FILE_SIZE_LIMIT);

		$fields->removeByName(array('ShowSlide'));

		$fields->addFieldsToTab('Root.Main', array(
			TextField::create('Name'),
			TextareaField::create('Description'),
			TreeDropdownField::create('PageLinkID', 'Choose a page to link to:', 'SiteTree'),
			$ImageField,
			CheckboxField::create('ShowSlide')->setTitle('Show Slide')
				->setDescription('Include this slide in the slider. Uncheck to hide'),
		));
		$fields->removeByName(array(
			'SortOrder',
			'PageID'
		));

		$this->extend('updateCMSFields', $fields);
		return $fields;
    }

    public function validate()
    {
        $result = parent::validate();

        if (!$this->Name) {
            $result->error('A Name is required before you can save');
        }

        if (!$this->ImageID) {
            $result->error('An Image is required before you can save');
        }

        return $result;
    }

    public function Thumbnail()
    {
        return $this->Image()->CroppedImage(80, 80);
    }

    public function Large()
    {
        if ($this->Image()->GetHeight() > 700) {
            return $this->Image()->SetHeight(700);
        } else {
            return $this->Image();
        }
    }

    public function providePermissions()
    {
        return array(
            'Slide_EDIT' => 'Edit a Slide',
            'Slide_DELETE' => 'Delete a Slide',
            'Slide_CREATE' => 'Create a Slide',
        );
    }
    public function canCreate($member = null)
    {
        return Permission::check('Slide_CREATE');
    }
    public function canEdit($member = null)
    {
        return Permission::check('Slide_EDIT');
    }
    public function canDelete($member = null)
    {
        return Permission::check('Slide_DELETE');
    }
    public function canView($member = null)
    {
        return true;
    }
}