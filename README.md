
# SilverStripe Flexslider

[![CI](https://github.com/dynamic/silverstripe-flexslider/actions/workflows/ci.yml/badge.svg)](https://github.com/dynamic/silverstripe-flexslider/actions/workflows/ci.yml)
[![Build Status](https://travis-ci.org/dynamic/silverstripe-flexslider.svg?branch=master)](https://travis-ci.org/dynamic/silverstripe-flexslider)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-flexslider/?branch=master)
[![codecov.io](https://codecov.io/github/dynamic/silverstripe-flexslider/coverage.svg?branch=master)](https://codecov.io/github/dynamic/silverstripe-flexslider?branch=master)

[![Latest Stable Version](https://poser.pugx.org/dynamic/flexslider/v/stable)](https://packagist.org/packages/dynamic/flexslider)
[![Total Downloads](https://poser.pugx.org/dynamic/flexslider/downloads)](https://packagist.org/packages/dynamic/flexslider)
[![Latest Unstable Version](https://poser.pugx.org/dynamic/flexslider/v/unstable)](https://packagist.org/packages/dynamic/flexslider)
[![License](https://poser.pugx.org/dynamic/flexslider/license)](https://packagist.org/packages/dynamic/flexslider)

## Overview

The FlexSlider module allows a developer to attach a [Woothemes FlexSlider](https://github.com/woothemes/FlexSlider) to a Page or DataObject. Various options are built into the DataExtension to allow for some level of customization in the CMS.

## Requirements

* [silverstripe/silverstripe-framework](https://github.com/silverstripe/silverstripe-framework) ^4.0

## Installation

`composer require dynamic/flexslider ^4.2`

## License

See [License](license.md)

## Documentation

See the [docs/en](docs/en/index.md) folder.

## Troubleshooting

- I've applied the `FlexSlider` DataExtension to a DataObject or Page and am receiving errors.
  - Be sure you have run a `dev/build?flush=all`
  - If this is an existing site installation and `FlexSlider` is being applied to existing records, be sure to run `dev/tasks/SlideThumbnailNavMigrationTask`. This will ensure default values expected for the module are setup for the existing records.

## Translations

The translations for this project are managed via [Transifex](https://www.transifex.com/dynamicagency/silverstripe-flexslider/)
and are updated automatically during the release process. To contribute, please head to the link above and get
translating!

## Maintainer Contact

 *  [Dynamic](http://www.dynamicagency.com) (<dev@dynamicagency.com>)

## Bugtracker
Bugs are tracked in the issues section of this repository. Before submitting an issue please read over 
existing issues to ensure yours is unique. 
 
If the issue does look like a new bug:
 
 - Create a new issue
 - Describe the steps required to reproduce your issue, and the expected outcome. Unit tests, screenshots 
 and screencasts can help here.
 - Describe your environment as detailed as possible: SilverStripe version, Browser, PHP version, 
 Operating System, any installed SilverStripe modules.
 
Please report security issues to the module maintainers directly. Please don't file security issues in the bugtracker.


## Development and contribution
If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.
