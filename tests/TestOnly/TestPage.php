<?php

namespace Dynamic\FlexSlider\Test\TestOnly;

use Dynamic\FlexSlider\ORM\FlexSlider;
use SilverStripe\Dev\TestOnly;

/**
 * Class TestPage
 * @package Dynamic\FlexSlider\Tests
 */
class TestPage extends \Page implements TestOnly
{
    /**
     * @var string
     */
    private static $slide_tab_title = '';

    /**
     * @var string
     */
    private static $table_name = 'FlexsliderTestPage';

    /**
     * @var array
     */
    private static $extensions = [
        FlexSlider::class,
    ];
}
