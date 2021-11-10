# Options

You can fine tune the komments plugin to behave as you whish. Use these options in `config.php` file.

**Please make sure to prefix all the options with `mauricerenck.komments.`**. For example the debug option should be set in your `config.php` like so: `'mauricerenck.komments.debug' => true`


| Option                            | Default                                                             | Description                                                                                      |
| --------------------------------- | ------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------ |
| `debug`                           | `false`                                                             | Enables debug mode and logs all webmentions to a file                                            |
| `enable-webmention-support`       | `true`                                                              | Listen to Webmentions and save them as komment                                                   |
| `webmention-auto-publish`         | `true`                                                              | When you receive a webmention set status to published                                            |
| `komment-auto-publish`            | `false`                                                             | When you receive a komment set status to published                                               |
| `auto-delete-spam`                | `true`                                                              | When comment spam is detected it will be rejected, set to false to just mark the comment as SPAM |
| `auto-disable-komments`           | `0`                                                                 | Disables the komment form after `n` number of days. Use `0` to never disable komments (default)  |
| `auto-disable-komments-datefield` | `'date'`                                                            | Set a field to function as publish date field used for `auto-disable-komments`                   |
| `komment-icon-like`               | '❤️'                                                                 | The icon for likes in your komment list                                                          |
| `komment-icon-reply`              | '💬'                                                                 | The icon for replies/comments in your komment list                                               |
| `komment-icon-repost`             | '♻️'                                                                 | The icon for reposts in your komment list                                                        |
| `komment-icon-mention`            | '♻️'                                                                 | The icon for mention in your komment list                                                        |
| `komment-icon-verified`           | '✅'                                                                 | The icon for the verify badge list                                                               |
| `replyClassNames`                 | ''                                                                  | add classnames to the reply link                                                                 |
| `form.submit.classNames`          | `'button button-tiny button-primary'`                               | add classnames to the submit button                                                              |
| `form.twitter.classNames`         | `'button button-tiny button-outlined share komment-share-twitter'`  | add classnames to the twitter button                                                             |
| `form.mastodon.classNames`        | `'button button-tiny button-outlined share komment-share-mastodon'` | add classnames to the mastodon button                                                            |


## Soon deprecated

These options / functions will soon be moved to the IndieConnector plugin.

| Option                        | Default                                     | Description                                                                                              |
| ----------------------------- | ------------------------------------------- | -------------------------------------------------------------------------------------------------------- |
| `send-mention-on-update`      | `true`                                      | Detect urls in your pages and send webmentions                                                           |
| `send-limit-to-templates`     | `[]`                                        | An array of template names (strings). When set webmentions will be sent only when this pages are updated |
| `send-mention-url-fields`     | `['text']`                                  | An array of fieldnames in which the plugin will search for urls                                          |
| `send-to-mastodon-on-publish` | `false`                                     | Send a post to mastodon when publishing a page                                                           |
| `mastodon-bearer`             | -                                           | Your Mastodon bearer Token                                                                               |
| `mastodon-instance-url`       | `'https://mastodon.social/api/v1/statuses‘` | Your Mastodon API Endpoint                                                                               |
| `mastodon-text-field`         | `'mastodonTeaser'`                          | The fieldname of the field you write your mastodon msg in, otherwise the title is used                   |
| `ping-archiveorg`             | `false`                                     | Enable if you want to inform archive.org when you update a page                                          |
