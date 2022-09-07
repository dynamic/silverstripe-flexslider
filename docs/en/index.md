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

##### Disabling Requirements

The Flexslider module allows you control over both your jQuery and flexslider.min.js files. Each file has an independent config option which can be disabled allowing you control over what version (you bring and) include in your project by setting the following config flags:

```yml
My\Page:
  jquery_enabled: false
  flexslider_enabled: false
```

**Notse**
- The `jquery_enabled` config allows for disabling specifically the jQuery library which is included to support `jquery.flexslider-min.js`. Disalbing this with a `false` value allows you to require your own version.
  - You may have to disable `flexslider_enabled` and re-require `dynamic/flexslider:thirdparty/flexslider/jquery.flexslider-min.js` in your project for inclusion order purposes. See the [Inclusion Order](https://docs.silverstripe.org/en/4/developer_guides/templates/requirements/#inclusion-order) documentation for more information.
- The `flexslider_enabled` config is generally for allowing fine tuned placement of the requirement vs replacement, however you can set the value to false and replace with your own flexslider client plugin.