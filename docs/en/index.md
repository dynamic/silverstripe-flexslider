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

##### Adjusting Requirements

The Flexslider module allows you control over both your jQuery and flexslider.min.js files. Each file has an independent config option which can be disabled allowing you control over what version (you bring and) include in your project. Below are the default config settings:

```yml
My\Page:
  jquery_enabled: true
  flexslider_enabled: true
```

**Note** the `flexslider_enabled` config is generally for allowing fine tuned placement of the requirement vs replacement, however you can set the value to false and replace with your own flexslider client plugin.