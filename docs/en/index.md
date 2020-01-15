# SilverStripe FlexSlider

Display FlexSlider slide shows on your SilverStripe website.

## Getting started

### Configuration

In your `mysite/_config/config.yml` add the following to the desired page type or DataObject you wish to add the FlexSlider to:

```yml
Page:
  extensions:
    - Dynamic\FlexSlider\ORM\FlexSlider
```

After attaching the DataExtension to your page type or DataObject run a `dev/build`.

#### Adjust slider speed

Adding `FlexSliderSpeed` to the config will adjust the speed of the slider in milliseconds.
Sliders default to 7000 milliseconds, or 7 seconds to show each slide.

```yml
Page:
  FlexSliderSpeed: 3000
  extensions:
    - Dynamic\FlexSlider\ORM\FlexSlider
```

The object that has FlexSlider applied can also have a method `setFlexSliderSpeed()`.
This will allow for a field to be added to the cms to control speed, or more fine grained control over the speed of the slider.
If `setFlexSliderSpeed()` return 0 or false the slider will fall back to using the config value.

```php
public function setFlexSliderSpeed()
{
    return 3000;
}
```

Adjusting the defualt for all sliders can also be done in the config.

```yml
Dynamic\FlexSlider\ORM\FlexSlider:
  FlexSliderSpeed: 3000
```

To disable including the custom JavaScript, use the `clear_requirements` configuration:

```yml
Dynamic\FlexSlider\ORM\FlexSlider:
  clear_requirements: true
```

### User Guide

You should now see a "Slides" tab on the page type or DataObject to which you applied the DataExtension. Simply create Slides to be included in the slide show that link to other pages on your website.

![screen shot](../../images/FlexSliderCMS.png)

You can inculde FlexSlider in your layout by using `<% include FlexSlider %>`

![screen shot](../../images/FlexSlider.png)
