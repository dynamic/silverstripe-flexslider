<?php

namespace Dynamic\FlexSlider\Model;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;

/**
 * Class SlideImage
 * @package Dynamic\FlexSlider\Model
 * @property string $Name
 * @property string $Headline
 * @property string $Description
 * @property int $SortOrder
 * @property int $ImageID
 * @property int $PageID
 * @property int $PageLinkID
 */
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
        'Image' => Image::class,
        'Page' => \Page::class,
        'PageLink' => SiteTree::class,
    );

    /**
     * @var array
     */
    private static $owns = array(
        'Image'
    );

    /**
     * @var string
     */
    private static $table_name = 'SlideImage';

    /**
     * @var string
     */
    private static $default_sort = 'SortOrder';

    /**
     * Adds Publish button to SlideImage record
     *
     * @var bool
     */
    private static $versioned_gridfield_extensions = true;

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
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName([
                'ShowSlide',
                'SortOrder',
                'PageID',
                'Image',
            ]);

            // Name
            $fields->dataFieldByName('Name')
                ->setTitle(
                    _t(__CLASS__ . '.NAME', 'Name')
                )
                ->setDescription(
                    _t(__CLASS__ . '.INTERNAL_USE', 'for internal reference only')
                );

            // Headline
            $fields->dataFieldByName('Headline')
                ->setTitle(
                    _t(__CLASS__ . '.HEADLINE', 'Headline')
                )
                ->setDescription(
                    _t(__CLASS__ . '.USED_IN_TEMPLATE', 'optional, used in template')
                );

            // Description
            $fields->dataFieldByName('Description')
                ->setTitle(
                    _t(__CLASS__ . '.DESCRIPTION', 'Description')
                )
                ->setDescription(
                    _t(__CLASS__ . '.USED_IN_TEMPLATE', 'optional, used in template')
                );

            // Page link
            $fields->dataFieldByName('PageLinkID')
                ->setTitle(
                    _t(__CLASS__ . '.PAGE_LINK', "Choose a page to link to:")
                );

            // Image
            $image = UploadField::create(
                'Image',
                _t(__CLASS__ . '.IMAGE', 'Image')
            )->setFolderName('Uploads/SlideImages');

            $image->getValidator()->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif']);

            $fields->insertAfter($image, 'Description');
        });

        $fields = parent::getCMSFields();

        $this->extend('updateSlideImageFields', $fields);

        return $fields;
    }

    /**
     * @return \SilverStripe\ORM\ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->Name) {
            $result->addError(
                _t(__CLASS__ . '.NAME_REQUIRED', 'A Name is required before you can save')
            );
        }

        if (!$this->ImageID) {
            $result->addError(
                _t(__CLASS__ . '.IMAGE_REQUIRED', 'An Image is required before you can save')
            );
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
     * @param array $context
     *
     * @return bool|int
     */
    public function canCreate($member = null, $context = [])
    {
        return Permission::check('Slide_CREATE', 'any', $member);
    }

    /**
     * @param null $member
     * @param array $context
     *
     * @return bool|int
     */
    public function canEdit($member = null, $context = [])
    {
        return Permission::check('Slide_EDIT', 'any', $member);
    }

    /**
     * @param null $member
     * @param array $context
     *
     * @return bool|int
     */
    public function canDelete($member = null, $context = [])
    {
        return Permission::check('Slide_DELETE', 'any', $member);
    }

    /**
     * @param null $member
     * @param array $context
     *
     * @return bool
     */
    public function canView($member = null, $context = [])
    {
        return true;
    }
}
