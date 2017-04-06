<?php

namespace Dynamic\FlexSlider\Test\TestOnly;

use Dynamic\FlexSlider\ORM\FlexSlider;
use SilverStripe\Dev\TestOnly;

/**
 * Class TestOnlyPage
 * @package Dynamic\FlexSlider\Test\TestOnly
 */
class TestOnlyPage extends \Page implements TestOnly
{

    private static $extensions = [
        FlexSlider::class,
    ];

}