# Receive Notifications

You can receive notifications on new comments via E-Mail.

There are two modes for getting notified:

- **instant** - you'll get an e-mail for each new comment, right after the comment was submitted. Suitable for sites without a lot of comments
- **cron** you'll get an e-mail whenever the cron job runs and there are pending comments

## Setting up the cronjob (webhook)

To trigger notifications you can use the webhook url: https://domain.tld/komments/cron/notification/SECRET 
In your kirby configuration set the `cronSecret` to any string (without any slashes). The secret in your webhook url has to match the secret in your configuration.

In your cronjob you then can open the url.

You may need to configure how kirby should send e-mails. Please have a look here: https://getkirby.com/docs/guide/emails#transport-configuration