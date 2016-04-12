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
            TextField::create('Name')
                ->setDescription('for internal reference only'),
            TextField::create('Title')
                ->setDescription('optional, used in template'),
            TextareaField::create('Description')
                ->setDescription('optional, used in template'),
            TreeDropdownField::create('PageLinkID', 'Choose a page to link to:', 'SiteTree'),
            $ImageField,
            CheckboxField::create('ShowSlide')->setTitle('Show Slide')
                ->setDescription('Include this slide in the slider. Uncheck to hide'),
        ));
        $fields->removeByName(array(
            'SortOrder',
            'PageID',
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

    public function providePermissions()
    {
        return array(
            'Slide_EDIT' => 'Slide Edit',
            'Slide_DELETE' => 'Slide Delete',
            'Slide_CREATE' => 'Slide Create',
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
