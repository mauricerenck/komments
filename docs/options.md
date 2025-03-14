# Options

You can fine tune the komments plugin to behave as you whish. Use these options in `config.php` file.

**Please make sure to prefix all the options with `mauricerenck.komments.`**. For example the debug option should be set in your `config.php` like so: `'mauricerenck.komments.debug' => true`

## General settings

| Option                      | Default  | Description                                                                                     |
| --------------------------- | -------- | ----------------------------------------------------------------------------------------------- |
| `comments.disabled`         | `false`  | Disable comments if you only want to show webmentions                                           |
| `autoDisable.ttl`           | `0`      | Disables the komment form after `n` number of days. Use `0` to never disable komments (default) |
| `autoDisable.datefield`     | `'date'` | Set a field to function as publish date field used for `autoDisable.ttl`                        |
| `enable-webmention-support` | `true`   | DEPRECATED - see `webmentions.enabled`                                                          |
| `webmention-auto-publish`   | `true`   | DEPRECATED - see `webmentions.publish`                                                          |
| `auto-delete-spam`          | `true`   | DEPRECATED - See `spam.delete`                                                                  |

## Storage Settings

| Option               | Default             | Description                                       |
| -------------------- | ------------------- | ------------------------------------------------- |
| `storage.type`       | `sqlite `           | `sqlite` or `markdown`                            |
| `storage.sqlitePath` | `../relative/path ` | Path to a folder in which the database is stored. |

## Migration Settings

| Option                | Default  | Description                                       |
| --------------------- | -------- | ------------------------------------------------- |
| `migrations.comments` | `true `  | Migrate comments to new format                    |
| `migrations.disabled` | `false ` | Disables database migrations after plugin updates |

## UI settings

| Option                     | Default                | Description                   |
| -------------------------- | ---------------------- | ----------------------------- |
| `form.submit.classNames`   | 'button button-primary | CSS classes for submit button |
| `komment-icon-like`        | -                      | DEPRECATED                    |
| `komment-icon-reply`       | -                      | DEPRECATED                    |
| `komment-icon-repost`      | -                      | DEPRECATED                    |
| `komment-icon-mention`     | -                      | DEPRECATED                    |
| `komment-icon-verified`    | -                      | DEPRECATED                    |
| `replyClassNames`          | -                      | DEPRECATED                    |
| `form.twitter.classNames`  | -                      | DEPRECATED                    |
| `form.mastodon.classNames` | -                      | DEPRECATED                    |

## Notification settings

| Option                                  | Default   | Description                                                 |
| --------------------------------------- | --------- | ----------------------------------------------------------- |
| `notifications.cronSecret`              | `''`      | A secret token to secure the cronjobs                       |
| `notifications.email.enable`            | `false`   | Enables or disables notification of new comments via e-mail |
| `notifications.email.sender`            | `''`      | E-mail-address for sending notifications                    |
| `notifications.email.emailReceiverList` | `[]`      | A list of e-mail-addresses                                  |
| `notifications.email.notificationMode`  | `instant` | When should the notification be sent: `instant` or `cron`   |

## Moderation settings

| Option                        | Default | Description                                                                     |
| ----------------------------- | ------- | ------------------------------------------------------------------------------- |
| `komment-auto-publish`        | `false` | When you receive a komment set status to published                              |
| `moderation.publish-verified` | `true`  | New comments by verified users are automatically published                      |
| `moderation.autoPublish`      | `[]`    | An array of email addresses which comments will be published without moderation |
| `auto-publish-verified`       | `true`  | DEPRECATED                                                                      |

## Webmention settings

| Option                | Default | Description                                                        |
| --------------------- | ------- | ------------------------------------------------------------------ |
| `webmentions.enabled` | `true`  | Whether to listen to webmentions (using the IndieConnector plugin) |
| `webmentions.publish` | `true`  | Auto publish webmentions or keep them unpublished until review     |

## Spam settings

| Option                 | Default | Description                                                                                                                        |
| ---------------------- | ------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| `spam.delete`          | `true`  | Weather to directly delete comments marked as spam or only flag them                                                               |
| `spam.sensibility`     | `60`    | An integer from 0 to 100 - Defines when a comment should be marked as spam, the higher the number to higher the possibilty of spam |
| `spam.akismet`         | `false` | Set to true to enable akismet spam detection (needs an api key)                                                                    |
| `spam.akismet_api_key` | `''`    | Akismet API key, see https://akismet.com/                                                                                          |

## Privacy settings

| Option               | Default | Description                                                                |
| -------------------- | ------- | -------------------------------------------------------------------------- |
| `privacy.storeEmail` | `false` | Enable to also store the email address of the comment sender in plain text |

## Panel settings

| Option              | Default | Description                                                          |
| ------------------- | ------- | -------------------------------------------------------------------- |
| `panel.enabled`     | `true`  | Adds a comment moderation view to the panel showing pending comments |
| `panel.webmentions` | `false` | Shows received Webmentions in the moderation view                    |
