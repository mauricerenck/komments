# Options

You can fine tune the komments plugin to behave as you whish. Use these options in `config.php` file.

**Please make sure to prefix all the options with `mauricerenck.komments.`**. For example the debug option should be set in your `config.php` like so: `'mauricerenck.komments.debug' => true`


## General settings

| Option                            | Default  | Description                                                                                      |
| --------------------------------- | -------- | ------------------------------------------------------------------------------------------------ |
| `debug`                           | `false`  | Enables debug mode and logs all webmentions to a file                                            |
| `enable-webmention-support`       | `true`   | Listen to Webmentions and save them as komment                                                   |
| `webmention-auto-publish`         | `true`   | When you receive a webmention set status to published                                            |
| `auto-delete-spam`                | `true`   | When comment spam is detected it will be rejected, set to false to just mark the comment as SPAM |
| `auto-disable-komments`           | `0`      | Disables the komment form after `n` number of days. Use `0` to never disable komments (default)  |
| `auto-disable-komments-datefield` | `'date'` | Set a field to function as publish date field used for `auto-disable-komments`                   |

## UI settings

| Option                     | Default                                                             | Description                                        |
| -------------------------- | ------------------------------------------------------------------- | -------------------------------------------------- |
| `komment-icon-like`        | '❤️'                                                                 | The icon for likes in your komment list            |
| `komment-icon-reply`       | '💬'                                                                 | The icon for replies/comments in your komment list |
| `komment-icon-repost`      | '♻️'                                                                 | The icon for reposts in your komment list          |
| `komment-icon-mention`     | '♻️'                                                                 | The icon for mention in your komment list          |
| `komment-icon-verified`    | '✅'                                                                 | The icon for the verify badge list                 |
| `replyClassNames`          | ''                                                                  | add classnames to the reply link                   |
| `form.submit.classNames`   | `'button button-tiny button-primary'`                               | add classnames to the submit button                |
| `form.twitter.classNames`  | `'button button-tiny button-outlined share komment-share-twitter'`  | add classnames to the twitter button               |
| `form.mastodon.classNames` | `'button button-tiny button-outlined share komment-share-mastodon'` | add classnames to the mastodon button              |

## Notification settings

| Option                                  | Default   | Description                                                 |
| --------------------------------------- | --------- | ----------------------------------------------------------- |
| `notifications.cronSecret`              | `''`      | A secret token to secure the cronjobs                       |
| `notifications.email.enable`            | `false`   | Enables or disables notification of new comments via e-mail |
| `notifications.email.sender`            | `''`      | E-mail-address for sending notifications                    |
| `notifications.email.emailReceiverList` | `[]`      | A  list of e-mail-addresses                                 |
| `notifications.email.notificationMode`  | `instant` | When should the notification be sent: `instant` or `cron`   |


## Moderation settings

| Option                   | Default | Description                                                                     |
| ------------------------ | ------- | ------------------------------------------------------------------------------- |
| `komment-auto-publish`   | `false` | When you receive a komment set status to published                              |
| `auto-publish-verified`  | `true`  | New comments by verified users are automatically published                      |
| `moderation.autoPublish` | `[]`    | An array of email addresses which comments will be published without moderation |

## Privacy settings

| Option               | Default | Description                                                                |
| -------------------- | ------- | -------------------------------------------------------------------------- |
| `privacy.storeEmail` | `false` | Enable to also store the email address of the comment sender in plain text |
