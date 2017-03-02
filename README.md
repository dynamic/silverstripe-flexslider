
# SilverStripe Flexslider

[![Build Status](https://travis-ci.org/dynamic/silverstripe-flexslider.svg?branch=master)](https://travis-ci.org/dynamic/silverstripe-flexslider)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/badges/build.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/build-status/master)
[![codecov.io](https://codecov.io/github/dynamic/silverstripe-flexslider/coverage.svg?branch=master)](https://codecov.io/github/dynamic/silverstripe-flexslider?branch=master)

[![Latest Stable Version](https://poser.pugx.org/dynamic/flexslider/v/stable)](https://packagist.org/packages/dynamic/flexslider)
[![Total Downloads](https://poser.pugx.org/dynamic/flexslider/downloads)](https://packagist.org/packages/dynamic/flexslider)
[![Latest Unstable Version](https://poser.pugx.org/dynamic/flexslider/v/unstable)](https://packagist.org/packages/dynamic/flexslider)
[![License](https://poser.pugx.org/dynamic/flexslider/license)](https://packagist.org/packages/dynamic/flexslider)

## Overview

The FlexSlider module allows a developer to attach a [Woothemes FlexSlider](https://github.com/woothemes/FlexSlider) to a Page or DataObject. Various options are built into the DataExtension to allow for some level of customization in the CMS.

## Requirements

* [silverstripe/silverstripe-framework](https://github.com/silverstripe/silverstripe-framework) ^3.1

## Installation

`composer require dynamic/flexslider`

## Recommended Add-Ons

* [colymba/gridfield-bulk-editing-tools](https://github.com/colymba/GridFieldBulkEditingTools)

## Example usage

FlexSlider displays an image slide show using the FlexSlider jQuery plugin. In the CMS you can specify a number of display options, including auto-animate, slide or fade, and loop.

![screen shot](images/FlexSlider.png)

## Pre-Release Migration Task

We've added some additional configuration options since the 1.0.0 pre-releases. To update all of your existing FlexSliders with the new default values, run `dev/tasks/SlideThumbnailNavMigrationTask`.

## Documentation

See the [docs/en](docs/en/index.md) folder.

## Maintainer Contact

 *  [Dynamic](http://www.dynamicagency.com) (<dev@dynamicagency.com>)
