# Setting up your templates

There are two main snippets to help you add Komments to your templates.

## Showing the comment form

To add the comment form to your template, simply use the following snippet:

```
<?php snippet('komments/kommentform'); ?>
```

This will show the form and also load the JavaScript files making it possible to send webmentions without a page reload and better spam detection.

## Showing the comment list

To list all comments and webmentions, simply use this snippet:

```
<?php snippet('komments/webmention-splitted'); ?>
```

This will list all the comments and also nest them.

## Loading the css

It's recommended to use the (very basic) css styles comming with the plugin. You can also use your own styles if you want.

Add the stylesheet within the `<head></head>` of your site:

```
?php echo css(['/media/plugins/mauricerenck/komments/komments.css']); ?>
```

## Disable komment form after n days

You can let the plugin automatically disable the comment form after a certain number of days after the page was published. So you could set `autoDisable.ttl` to `14`. When you publish a page the comment form on that page will be disabled 14 days after the publish date. Only webmentions will be received after this. You can define any date field as a source by using the option `autoDisable.datefield`. The default datefield is `date`.

Please be aware: If you configure a non-existing date field, this will result in a disabled komment state for all pages.

## Further customization

You can use the [options](/docs/options.md) to customize icons and class names, if you want to. You could also write your own snippets for each comment type, the listing and form. I wrote about it [here](https://maurice-renck.de/en/projects/komments/custom-comments-design).
