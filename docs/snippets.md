# Snippets

This plugin provides snippets for displaying comments, webmentions and a form to submit a new comment.

There are three types of snippets:

1. The form snippet
2. Listing snippets
3. Single response type snippets

## DEPRECATION NOTICE

Due to the massive changes of this plugin and because of new possibilities I slimmed down most of the snippets. If you update from a prio version, please make sure to check the new snippets and adjust your templates accordingly.
Old snippets will echo a deprecation notice. The following snippets are deprecated:

- `komments/webmention`
- `komments/webmention-splitted`
- `komments/type/like`
- `komments/type/reply`
- `komments/type/repost`
- `komments/type/mention`
- `komments/type/comment`

## The form snippet

The form snippet is used to display a form to submit a new comment. It is used like this:

```php
<?php snippet('komments/form'); ?>
```

This will display a form to submit a new comment. The form will be prefilled with the name and email of the user if they are logged in.
It also loads the necessary JavaScript to submit the form without a page reload. You can customize the form by copying the `form.php` file from the plugin folder to your `snippets` folder into:

```
/site/snippets/komments/form.php
```

You then can modify the form to your needs. Please make sure to keep all the hidden fields and in general the field names as they are. If you want to use the JavaScript, IDs and classes should also be kept as they are.

If you just want to change the labels or other text, you can use translations.

## Listing snippets

The listing snippets are used to display lists comments or webmentions. They are used like this:

```php
<?php snippet('komments/list/TYPE'); ?>
```

Replace `TYPE` with the type of comments you want to display. The following types are available:

- `comments`
- `likes`
- `mentions`
- `replies`
- `reposts`

The list snippets take care of fetching the comments and filtering them by type. You can customize the list by copying the files from the plugin folder to your `snippets/komments` folder. The files are:

- `list/comments.php`
- `list/likes.php`
- `list/mentions.php`
- `list/replies.php`
- `list/reposts.php`

## Response type snippets

The response type snippets are used to display a single comment or webmention. They are used like this:

```php
<?php snippet('komments/response/TYPE', ['comment' => $comment]); ?>
```

Replace `TYPE` with the type of comment you want to display. The following types are available:

- `comment`
- `like`
- `mention`
- `reply`
- `repost`

### Customizing the response type snippets

Every response type snippets is based on the main response snippet

```php
<?php snippet('komments/response/base'); ?>
```

This snippet is used to display the basic structure of a response. It uses the the Kirby slots features to display the different parts of a response.
This way you can eaasily customize the layout and design if you want to. There are three slots available:

- `header`
- `body`
- `footer`

You can use it like so:

```php
<?php snippet('komments/response/base', ['comment' => $comment], slots: true); ?>
    <?php slot('body'); ?>Your special content<?php endslot(); ?>
<?php endsnippet(); ?>
```

You can customize the response snippets by copying the files from the plugin folder to your `snippets/komments` folder. The files are:

- `response/comment.php`
- `response/like.php`
- `response/mention.php`
- `response/reply.php`
- `response/repost.php`
- `response/base.php` (base snippet all the others are relying on)
