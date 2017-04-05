<?php

namespace Dynamic\FlexSlider\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\Security\Permission;
use SilverStripe\Forms\FieldList;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\CMS\Model\SiteTree;

/**
 * Class SlideImage
 * @package Dynamic\FlexSlider\Model
 * @property string $Name
 * @property string $Headline
 * @property string $Description
 * @property int $SortOrder
 * @property bool $ShowSlide
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
     * @var string
     */
    private static $table_name = 'SlideImage';

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
        'PageLink' => SiteTree::class,
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

        $fields->dataFieldByName('Name')
            ->setDescription('for internal reference only');

        $fields->dataFieldByName('Headline')
            ->setDescription('optional, used in template');

        $fields->dataFieldByName('Description')
            ->setDescription('optional, used in template');

        $fields->dataFieldByName('PageLinkID')
            ->setTitle("'Choose a page to link to:'");

        $image = $fields->dataFieldByName('Image');
        if (class_exists('SilverStripe\\AssetAdmin\\Forms\\UploadField')) {
            if ($image instanceof UploadField) {
                $image->setFolderName('Uploads/SlideImages')
                    ->setIsMultiUpload(false)
                    ->setAllowedFileCategories('image/supported');
            }
        }

        $fields->insertBefore('ShowSlide', $image);

        $fields->dataFieldByName('ShowSlide')
            ->setDescription('Include this slide in the slider. Un-check to hide');

        return $fields;
    }

    /**
     * @return ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->Name) {
            $result->addError('A Name is required before you can save');
        }

        if (!$this->ImageID) {
            $result->addError('An Image is required before you can save');
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
