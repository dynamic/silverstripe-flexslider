# SilverStripe FlexSlider

Display FlexSlider slide shows on your SilverStripe website.

## Getting started

### Configuration

In your `mysite/_config/config.yml` add the following to the desired page type or DataObject you wish to add the FlexSlider to:

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
Page_Controller::add_extension('FlexSliderExtension')
```

After attaching the DataExtension to your page type or DataObject run a `dev/build` then `?flush=all`. 

### User Guide

You should now see a "Slides" tab on the page type or DataObject to which you applied the DataExtension. Simply create Slides to be included in the slide show that link to other pages on your website.

![screen shot](../../images/FlexSliderCMS.png)

You can inculde FlexSlider in your layout by using `<% include FlexSlider %>`

![screen shot](../../images/FlexSlider.png)