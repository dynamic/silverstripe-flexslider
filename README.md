[![Build Status](https://travis-ci.org/dynamic/SilverStripe-FlexSlider.svg)](https://travis-ci.org/dynamic/SilverStripe-FlexSlider)

Overview
=======================

The FlexSlider module allows a developer to attach a [woothemes flexslider](https://github.com/woothemes/FlexSlider) to a Page or DataObject. Various FlexSlider options are built into the DataExtension to allow for some level of customization.

Composer Installation
=======================

`"require": { "dynamic/silverstripe-flexslider" }`

Add `flexslider` to your `.gitignore`

Git Installation
=======================

`git clone https://github.com/dynamic/SilverStripe-FlexSlider.git flexslider`

Requirements
=======================

* [silverstripe/silverstripe-framework](https://github.com/silverstripe/silverstripe-framework) 3.1.x

Recommended Add-Ons
=======================

* [colymba/gridfield-bulk-editing-tools](https://github.com/colymba/GridFieldBulkEditingTools)
* [undefinedoffset/sortablegridfield](https://github.com/UndefinedOffset/SortableGridField)

Usage
=======================

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
```
Page::add_extension('FlexSlider');
```

```
Page_Controller::add_extension('FlexSliderExtension')
```

After attaching the DataExtension to your page type or DataObject run a `dev/build` then `?flush=all`. You should now see a "Slides" tab on the page type or DataObject you applied the DataExtension to. You can now add Slides that will be looped through in your layout by using the `FlexSlider` include.
`<% include FlexSlider %>`

Maintainer Contact
=======================

* Dynamic (<dev@dynamicagency.com>)

Links
=======================

* [Grid Field Bulk Editing Tools](https://github.com/colymba/GridFieldBulkEditingTools)
* [SortableGridField](https://github.com/UndefinedOffset/SortableGridField)
* [SilverStripe CMS](http://silverstripe.org/)

License
=================================

	Copyright (c) 2015, Dynamic Inc
	All rights reserved.

	Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

	Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
	
	Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
	
	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
