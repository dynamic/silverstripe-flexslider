<?php

namespace Dynamic\FlexSlider\Model;

use function GuzzleHttp\Psr7\parse_request;
use Sheadawson\Linkable\Forms\EmbeddedObjectField;
use Sheadawson\Linkable\Models\EmbeddedObject;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;
use UncleCheese\DisplayLogic\Forms\Wrapper;

/**
 * Class SlideImage
 * @package Dynamic\FlexSlider\Model
 * @property string $Name
 * @property string $Headline
 * @property string $Description
 * @property int $SortOrder
 * @property string $SlideType
 * @property int $ImageID
 * @property int $VideoID
 * @property int $PageID
 * @property int $PageLinkID
 * @property int $LinkID
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
    private static $db = [
        'Name' => 'Varchar(255)',
        'Headline' => 'Varchar(255)',
        'Description' => 'Text',
        'SortOrder' => 'Int',
        'SlideType' => 'Varchar',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Image' => Image::class,
        'Video' => EmbeddedObject::class,
        'Page' => \Page::class,
        'PageLink' => SiteTree::class,
        'Link' => Link::class,
    ];

    /**
     * @var array
     */
    private static $owns = [
        'Image',
    ];

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
    private static $defaults = [
        'SlideType' => 'Image',
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Image',
        'Name' => 'Name',
    ];

    /**
     * @var array
     */
    private static $searchable_fields = [
        'Name',
        'Headline',
        'Description',
    ];

    /**
     * @var int
     */
    private static $image_size_limit = 512000;

    /**
     * @var array
     */
    private static $slide_types = [
        'Image',
        'Video',
        'Text',
    ];

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
                'SlideType',
                'Video',
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
            $fields->replaceField(
                'PageLinkID',
                TreeDropdownField::create('PageLinkID', '', SiteTree::class)
                    ->setTitle(
                        _t(__CLASS__ . '.PAGE_LINK', "Choose a page to link to:")
                    )
            );

            // Image
            $image = UploadField::create(
                'Image',
                _t(__CLASS__ . '.IMAGE', 'Image')
            )->setFolderName('Uploads/SlideImages');

            $image->getValidator()->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif']);

            $fields->addFieldToTab(
                'Root.Main',
                CompositeField::create(FieldList::create(
                    DropdownField::create('SlideType')
                        ->setSource($this->getTypeSource())
                        ->setTitle('Image or Video'),
                    Wrapper::create(
                        $image
                    )->displayIf('SlideType')->isEqualTo('Image')->orIf('SlideType')->isEqualTo('Video')->end(),
                    Wrapper::create(
                        $videoField = EmbeddedObjectField::create('Video')
                            ->setTitle('Video URL')
                            ->setDescription('Supported links: YouTube, Vimeo')
                    )->displayIf('SlideType')->isEqualTo('Video')->end()
                ))->setName('MediaFields'),
                'Description'
            );
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

        $types = $this->getTypeSource();

        if (isset($types['Video']) && $this->SlideType == 'Video' && !$this->VideoID) {
            $result->addError(
                _t(__CLASS__ . '.VIDEO_REQUIRED', 'An Video Link is required before you can save')
            );
        }

        if (isset($types['Image']) && $this->SlideType == 'Image' && !$this->ImageID) {
            $result->addError(
                _t(__CLASS__ . '.IMAGE_REQUIRED', 'An Image is required before you can save')
            );
        }

        if (isset($types['Text']) && $this->SlideType == 'Text' && !$this->Description) {
            $result->addError(
                _t(__CLASS__ . '.DESCRIPTION_REQUIRED', 'A Description is required before you can save')
            );
        }

        return $result;
    }

    /**
     * @return array
     */
    public function providePermissions()
    {
        return [
            'Slide_EDIT' => 'Slide Edit',
            'Slide_DELETE' => 'Slide Delete',
            'Slide_CREATE' => 'Slide Create',
        ];
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

    /**
     * @return array
     */
    public function getTypeSource()
    {
        $types = $this->config()->get('slide_types');
        asort($types);
        return array_combine($types, $types);
    }

    /**
     * @param null $template
     * @param null $customFields
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function renderWith($template = null, $customFields = null)
    {
        if ($template === null) {
            $template = static::class;
            $template = ($this->SlideType) ? $template . "_{$this->SlideType}" : '';
        }

        return parent::renderWith($template);
    }

    /**
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function forTemplate()
    {
        return $this->renderWith();
    }
}
