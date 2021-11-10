
# Webmentions

## Receiving webmentions

**To receive webmentions you have to install the [IndieConnector plugin](https://github.com/mauricerenck/indieConnector) and configure it.** IndieConnector will handle all the webmentions and normalize their data. Currently only webmention.io is supported. After installing IndieConnector, Komment will automatically be informed about new webmentions.

**Webmention support is enabled by default but won't work until you install IndieConnector.**

---

## Sending Webmentions DEPRECATED

The first version of the Komments plugin allowed sending webmentions and mastodon toots when publishing a page. This will be deprecated with upcomming updates. All that functionality shouldn't be part of a comments plugin and will be moved to the [IndieConnector plugin](https://github.com/mauricerenck/indieConnector). Please be aware of this if you are currently using these functions and want to update Komments.

### Sending Webmentions (SOON DEPRECATED)

By default the plugin will try to send webmentions to all urls it finds in your page. You might want to tell the plugin in which fields to look for urls, you can do that by providing a list of fieldnames in the `mauricerenck.komments.send-mention-url-fields` option. So if you have an intro and a text field in your blueprint, you might want to add those:

```
'mauricerenck.komments.send-mention-url-fields' => [
        'intro',
        'text',
    ]
```

If you just want to send webmention on specific pages, like only on blogposts, you can set a limit to those templates by using the `mauricerenck.komments.send-limit-to-templates` option. For example, using the starterkit, if you just want to send mentions on notes, do so:

```
'mauricerenck.komments.send-limit-to-templates' => [
        'note',
    ]
```

### Sending new pages to mastodon (SOON DEPRECATED)

If you want to, you can inform your mastodon followers of new pages/posts on your site. Just set the `mauricerenck.komments.send-to-mastodon-on-publish` to `true`. Komments will then try to publish a mastodon post everytime you publish a page. This can also be limited by template (see sending webmentions above)

In order to be able to publish to your mastodon account, you need to set a bearer token and your mastodon api endpoint. Please have a look at your mastodon instance on how to get that data.

### Ping archive.org (SOON DEPRECATED)

set `ping-archiveorg` to true in your config (see [options](/docs/options.md))
