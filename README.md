
# SilverStripe Flexslider
[![Build Status](https://travis-ci.org/dynamic/silverstripe-flexslider.svg?branch=continuous_integration)](https://travis-ci.org/dynamic/silverstripe-flexslider)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/badges/quality-score.png?b=continuous_integration)](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/?branch=continuous_integration)
[![Code Coverage](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/badges/coverage.png?b=continuous_integration)](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/?branch=continuous_integration)
[![Build Status](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/badges/build.png?b=continuous_integration)](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/build-status/continuous_integration)
[![codecov.io](https://codecov.io/github/dynamic/silverstripe-flexslider/coverage.svg?branch=continuous_integration)](https://codecov.io/github/dynamic/silverstripe-flexslider?branch=continuous_integration)

[![Latest Stable Version](https://poser.pugx.org/dynamic/flexslider/version)](https://packagist.org/packages/dynamic/flexslider)
[![Latest Unstable Version](https://poser.pugx.org/dynamic/flexslider/v/unstable)](//packagist.org/packages/dynamic/flexslider)
[![Total Downloads](https://poser.pugx.org/dynamic/flexslider/downloads)](https://packagist.org/packages/dynamic/flexslider)
[![License](https://poser.pugx.org/dynamic/flexslider/license)](https://packagist.org/packages/dynamic/flexslider)
[![Monthly Downloads](https://poser.pugx.org/dynamic/flexslider/d/monthly)](https://packagist.org/packages/dynamic/flexslider)
[![Daily Downloads](https://poser.pugx.org/dynamic/flexslider/d/daily)](https://packagist.org/packages/dynamic/flexslider)

[![Dependency Status](https://www.versioneye.com/php/dynamic:flexslider/badge.svg)](https://www.versioneye.com/php/dynamic:flexslider)
[![Reference Status](https://www.versioneye.com/php/dynamic:flexslider/reference_badge.svg?style=flat)](https://www.versioneye.com/php/dynamic:flexslider/references)

![codecov.io](https://codecov.io/github/dynamic/silverstripe-flexslider/branch.svg?branch=continuous_integration)


## Overview

The FlexSlider module allows a developer to attach a [woothemes flexslider](https://github.com/woothemes/FlexSlider) to a Page or DataObject. Various FlexSlider options are built into the DataExtension to allow for some level of customization.

## Installation

`composer require dynamic/silverstripe-flexslider dev-master`

Add `flexslider` to your `.gitignore`

## Requirements

* [silverstripe/silverstripe-framework](https://github.com/silverstripe/silverstripe-framework) ^3.1.x

## Recommended Add-Ons

* [colymba/gridfield-bulk-editing-tools](https://github.com/colymba/GridFieldBulkEditingTools)
* [undefinedoffset/sortablegridfield](https://github.com/UndefinedOffset/SortableGridField)

## Usage

In your `mysite/_config/config.yml` add the following to the desired page type or DataObject you wish to add the flexslider to:

```
Page:
  extensions:
    - FlexSlider
Page_Controller:
  extensions:
    - FlexSliderExtension
```

Alternatively you could add the following to your `mysite/_config.php` file:
```Page::add_extension('FlexSlider');```
```Page_Controller::add_extension('FlexSliderExtension')```

After attaching the DataExtension to your page type or DataObject run a `dev/build` then `?flush=all`. You should now see a "Slides" tab on the page type or DataObject you applied the DataExtension to. You can now add Slides that will be looped through in your layout by using the `FlexSlider` include.
`<% include FlexSlider %>`

## Maintainer Contact

* [Dynamic](http://www.dynamicagency.com) (<dev@dynamicagency.com>)

## Links

* [Grid Field Bulk Editing Tools](https://github.com/colymba/GridFieldBulkEditingTools)
* [SortableGridField](https://github.com/UndefinedOffset/SortableGridField)
* [SilverStripe CMS](http://silverstripe.org/)