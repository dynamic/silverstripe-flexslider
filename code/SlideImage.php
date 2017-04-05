<?php

class SlideImage extends DataObject implements PermissionProvider
{
    /**
     * @var string
     */
    private static $singular_name = 'Slide';

    /**
     * @var string
     */
    private static $plural_name = 'Slides';

    /**
     * @var array
     */
    private static $db = array(
        'Name' => 'Varchar(255)',
        'Headline' => 'Varchar(255)',
        'Description' => 'Text',
        'SortOrder' => 'Int',
        'ShowSlide' => 'Boolean',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Image' => 'Image',
        'Page' => 'Page',
        'PageLink' => 'SiteTree',
    );

    /**
     * @var string
     */
    private static $default_sort = 'SortOrder';

    /**
     * @var array
     */
    private static $defaults = array(
        'ShowSlide' => true,
    );

    /**
     * @var array
     */
    private static $summary_fields = array(
        'Image.CMSThumbnail' => 'Image',
        'Name' => 'Name',
    );

    /**
     * @var array
     */
    private static $searchable_fields = array(
        'Name',
        'Headline',
        'Description',
    );

    /**
     * @var int
     */
    private static $image_size_limit = 512000;

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'SortOrder',
            'PageID',
        ]);

        if($name = $fields->dataFieldByName('Name')){
            $name->setDescription('for internal reference only');
        }

        if($headline = $fields->dataFieldByName('Headline')){
            $headline->setDescription('optional, used in template');
        }

        if($description = $fields->dataFieldByName('Description')){
            $description->setDescription('optional, used in template');
        }

        if($link = $fields->dataFieldByName('PageLinkID')){
            $link->setTitle("'Choose a page to link to:'");
        }

        if($image = $fields->dataFieldByName('Image')){
            $image->setFolderName('Uploads/SlideImages')
                ->setAllowedMaxFileNumber(1)
                ->setAllowedFileCategories('image');
            $fields->insertBefore($image, 'ShowSlide');
        }

        $fields->dataFieldByName('ShowSlide')
            ->setDescription('Include this slide in the slider. Uncheck to hide');

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
