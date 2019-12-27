<?php

namespace Dynamic\FlexSlider\Model;

use DNADesign\Elemental\Forms\TextCheckboxGroupField;
use Dynamic\FlexSlider\Interfaces\SlideInterface;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\InheritedPermissions;
use SilverStripe\Security\InheritedPermissionsExtension;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;
use SilverStripe\Security\Security;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Versioned\Versioned;

/**
 * Class Slide
 * @package Dynamic\FlexSlider\Model
 *
 * @mixin Versioned
 * @mixin InheritedPermissionsExtension
 */
class Slide extends DataObject implements PermissionProvider, SlideInterface
{
    /**
     * The Create permission
     */
    const SLIDE_CREATE = 'SLIDE_CREATE';

    /**
     * The Publish permission
     */
    const SLIDE_PUBLISH = 'SLIDE_PUBLISH';

    /**
     * The Edit permission
     */
    const SLIDE_EDIT = 'SLIDE_EDIT';

    /**
     * The Delete permission
     */
    const SLIDE_DELETE = 'SLIDE_DELETE';

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
    private static $table_name = 'Slide';

    /**
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(255)',
        'ShowTitle' => 'Boolean',
        'Content' => 'HTMLText',
        'SortOrder' => 'Int',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Page' => \Page::class,
    ];

    /**
     * @var array
     */
    private static $extensions = [
        Versioned::class,
        InheritedPermissionsExtension::class,
    ];

    /**
     * @var array
     */
    private static $versioning = [
        "Stage", "Live",
    ];


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
    private static $searchable_fields = [
        'Title',
        'Content',
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'SlideType',
        'Title',
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $viewInherit = $fields->dataFieldByName('CanViewType');
            $editInherit = $fields->dataFieldByName('CanEditType');

            $fields->removeByName([
                'Title',
                'ShowTitle',
                'SortOrder',
                'CanViewType',
                'CanEditType',
                'PageID',
            ]);

            $fields->addFieldToTab(
                'Root.Main',
                TextCheckboxGroupField::create(),
                'Content'
            );

            $fields->addFieldsToTab(
                'Root.Permissions',
                [
                    $viewInherit,
                    $editInherit,
                ]
            );
        });

        return parent::getCMSFields();
    }

    /**
     * @return array
     */
    public function providePermissions()
    {
        return [
            static::SLIDE_CREATE => [
                'name' => _t(__CLASS__ . '.PERMISSION_CREATE_DESCRIPTION', 'Create Slides'),
                'help' => _t(__CLASS__ . '.PERMISSION_CREATE_HELP', 'Allow creating slides'),
                'category' => _t(__CLASS__ . '.PERMISSIONS_CATEGORY', 'FlexSlider Permissions'),
                'sort' => 100,
            ],
            static::SLIDE_PUBLISH => [
                'name' => _t(__CLASS__ . '.PERMISSION_PUBLISH_DESCRIPTION', 'Publish Slides'),
                'help' => _t(__CLASS__ . '.PERMISSION_PUBLISH_HELP', 'Allow publishing slides'),
                'category' => _t(__CLASS__ . '.PERMISSIONS_CATEGORY', 'FlexSlider Permissions'),
                'sort' => 100,
            ],
            static::SLIDE_EDIT => [
                'name' => _t(__CLASS__ . '.PERMISSION_EDIT_DESCRIPTION', 'Edit Slides'),
                'help' => _t(__CLASS__ . '.PERMISSION_EDIT_HELP', 'Allow editing slides'),
                'category' => _t(__CLASS__ . '.PERMISSIONS_CATEGORY', 'FlexSlider Permissions'),
                'sort' => 100,
            ],
            static::SLIDE_DELETE => [
                'name' => _t(__CLASS__ . '.PERMISSION_DELETE_DESCRIPTION', 'Delete Slides'),
                'help' => _t(__CLASS__ . '.PERMISSION_DELETE_HELP', 'Allow deleting slides'),
                'category' => _t(__CLASS__ . '.PERMISSIONS_CATEGORY', 'FlexSlider Permissions'),
                'sort' => 100,
            ],
        ];
    }

    /**
     * @param null $member
     * @param array $context
     * @return bool|int
     */
    public function canCreate($member = null, $context = [])
    {
        if (!$member) {
            $member = Security::getCurrentUser();
        }

        // Standard mechanism for accepting permission changes from extensions
        $extended = $this->extendedCan(__FUNCTION__, $member, $context);
        if ($extended !== null) {
            return $extended;
        }

        // Check permission
        if ($member && Permission::checkMember($member, "ADMIN") || Permission::checkMember($member, static::SLIDE_CREATE)) {
            return true;
        }

        // This doesn't necessarily mean we are creating a root page, but that
        // we don't know if there is a parent, so default to this permission
        return SiteConfig::current_site_config()->canCreateTopLevel($member);
    }

    /**
     * @param null $member
     * @return bool|int
     */
    public function canPublish($member = null)
    {
        if (!$member) {
            $member = Security::getCurrentUser();
        }

        // Check extension
        $extended = $this->extendedCan('canPublish', $member);
        if ($extended !== null) {
            return $extended;
        }

        if (Permission::checkMember($member, "ADMIN") || Permission::checkMember($member, static::SLIDE_PUBLISH)) {
            return true;
        }

        return false;
    }

    /**
     * @param null $member
     * @return bool|int
     */
    public function canEdit($member = null)
    {
        if (!$member) {
            $member = Security::getCurrentUser();
        }

        // Standard mechanism for accepting permission changes from extensions
        $extended = $this->extendedCan('canEdit', $member);
        if ($extended !== null) {
            return $extended;
        }

        // Default permissions
        if (Permission::checkMember($member, "ADMIN") || Permission::checkMember($member, static::SLIDE_EDIT)) {
            return true;
        }


        return false;
    }

    /**
     * @param null $member
     * @return bool|null
     */
    public function canView($member = null)
    {
        if (!$member) {
            $member = Security::getCurrentUser();
        }

        // Standard mechanism for accepting permission changes from extensions
        $extended = $this->extendedCan('canView', $member);
        if ($extended !== null) {
            return $extended;
        }

        // admin override
        if ($member && Permission::checkMember($member, ["ADMIN", "SITETREE_VIEW_ALL"])) {
            return true;
        }

        // Note: getInheritedPermissions() is disused in this instance
        // to allow parent canView extensions to influence subpage canView()

        // check for empty spec
        if (!$this->CanViewType || $this->CanViewType === InheritedPermissions::ANYONE) {
            return true;
        }

        // check for inherit
        if ($this->CanViewType === InheritedPermissions::INHERIT) {
            return $this->getSiteConfig()->canViewPages($member);
        }

        // check for any logged-in users
        if ($this->CanViewType === InheritedPermissions::LOGGED_IN_USERS && $member && $member->ID) {
            return true;
        }

        // check for specific groups
        if ($this->CanViewType === InheritedPermissions::ONLY_THESE_USERS
            && $member
            && $member->inGroups($this->ViewerGroups())
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param null $member
     * @return bool|int
     */
    public function canDelete($member = null)
    {
        if (!$member) {
            $member = Security::getCurrentUser();
        }

        // Standard mechanism for accepting permission changes from extensions
        $extended = $this->extendedCan('canDelete', $member);
        if ($extended !== null) {
            return $extended;
        }

        if (!$member) {
            return false;
        }

        // Default permission check
        if (Permission::checkMember($member, ["ADMIN", static::SLIDE_DELETE])) {
            return true;
        }

        return false;
    }

    /**
     * Stub method to get the site config, unless the current class can provide an alternate.
     *
     * @return SiteConfig
     */
    public function getSiteConfig()
    {
        $configs = $this->invokeWithExtensions('alternateSiteConfig');
        foreach (array_filter($configs) as $config) {
            return $config;
        }

        return SiteConfig::current_site_config();
    }

    /**
     * @return string
     */
    public function getSlideType()
    {
        return static::i18n_singular_name();
    }
}
