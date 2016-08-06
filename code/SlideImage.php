<?php

/**
 * Class SlideImage
 */
class SlideImage extends DataObject implements PermissionProvider
{

    /**
     * @var int
     */
    private static $flexslider_max_image_size = 512000;

    /**
     * @var array
     */
    private static $defaults = array(
        'ShowSlide' => true,
    );

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $ImageField = ImageUploadField::create('Image')
            ->setTitle('Image')
            ->setFolderName('Uploads/SlideImages');
        $ImageField->getValidator()->setAllowedMaxFileSize($this->config()->get('flexslider_max_image_size'));

        $fields->removeByName(array('ShowSlide'));

        $fields->addFieldsToTab('Root.Main', array(
            TextField::create('Name')
                ->setDescription('for internal reference only'),
            TextField::create('Headline')
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

    /**
     * @return ValidationResult
     */
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

    /**
     * @return array
     */
    public function providePermissions()
    {
        return array(
            'Slide_EDIT' => 'Slide Edit',
            'Slide_DELETE' => 'Slide Delete',
            'Slide_CREATE' => 'Slide Create',
        );
    }

    /**
     * @param null $member
     * @return bool|int
     */
    public function canCreate($member = null)
    {
        return Permission::check('Slide_CREATE');
    }

    /**
     * @param null $member
     * @return bool|int
     */
    public function canEdit($member = null)
    {
        return Permission::check('Slide_EDIT');
    }

    /**
     * @param null $member
     * @return bool|int
     */
    public function canDelete($member = null)
    {
        return Permission::check('Slide_DELETE');
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canView($member = null)
    {
        return true;
    }

}
