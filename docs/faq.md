# FAQ

> My panel view looks so different! What's going on?!

The new Komments view is only available for Kirby 3.6+ if you use a version below that, you'll still the the old moderation view.

> I enabled webmentions but nothing happens

Komments does not provide an endpoint for webmentions but it listens on a webmention hook. In order to receive webmentions, you have to install the [IndieConnector plugin](https://github.com/mauricerenck/indieConnector).

> I don't see any comments marked as spam

By default comments detected as spam are rejected. If you want to moderate spam comments, disable the `auto-delete-spam` option. (see [options](/docs/options.md))