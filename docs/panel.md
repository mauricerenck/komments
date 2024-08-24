# Adding Komments to the panel

## Moderation view

By default Komments comes with a panel view for moderation. You don't need to do anything for this. In the panel menu you should see an entry called "Komments".

![the dashboard](../doc-assets/komments-dashboard.png)


### Disable moderation view

You can disable the moderation view by setting the option `komments.panel.enabled` to `false` in your `config.php`:

```php
'mauricerenck.komments.panel.enabled' => false
```

## Webmentions

By default the moderation view does not show Webmentions. If you want to see them in the moderation view you can enable this by setting the option `komments.panel.webmentions` to `true` in your `config.php`:

```php
'mauricerenck.komments.panel.webmentions' => true
```

## Adding comment moderation to your panel pages

### Komments section

To add the moderation view to your panel pages you can use the section blueprint coming with Komments.
This will add a toggle to enable/disable comments for each page and the moderation panel showing all comments for that page.


```yaml
sections:
    komments:
        extends: sections/komments
```

### Panel fields

If you want to have more control over the fields shown in the moderation view you can use the fields blueprintcoming with Komments directly.

#### Toggle to enable/disable comments for the page:

```yaml
kommentsEnabledOnpage:
    type: toggle
    label: Komments enabled
    default: true
    text:
        - Disabled
        - Enabled
```

#### Moderation table:

```yaml
komments:
  type: CommentsTable
  label: Inbox
```

Note that the field name for the comments table must be `komments` to work. The plugin internally fetches the comment independent of the field name.

##### Customizing the moderation table

You can customize the moderation table by using the `columns` option. The following columns are available:

- author
- content
- pageTitle
- updatedAt
- spamlevel
- verified
- published
- type

Example:

```yaml
komments:
  type: CommentsTable
  label: Inbox
  columns:
    - author
    - content
```

This will only show the author and content columns. This way you can customize the moderation table to your needs.

## Show number of pending Comments in Kirby Panel Stats

```
sections:
  stats:
    type: stats
    reports:
      - label: Pending Comments
        value: "{{ site.numberOfPendingComments }}"
        info: "Possible spam: {{ site.numberOfSpamComments }}"
        link: https://getkirby.com/shop
        theme: negative
```

![komment section](../doc-assets/komment-stats.png)

To get the number of pending comments use the site method `numberOfPendingComments`. To get pending comments marked as spam use `numberOfSpamComments`

To learn more about Kirby stats, please have a look here: https://getkirby.com/docs/reference/panel/sections/stats
