<?php

/**
 * Class FlexSliderExtension
 *
 * @deprecated 1.0.0 This class's methods have been moved to {@link FlexSlider}
 */
class FlexSliderExtension extends Extension
{
    public function __construct()
    {
        trigger_error('Class no longer used, please remove references to this class from any extension declarations.', E_USER_NOTICE);
        parent::__construct();
    }
}
