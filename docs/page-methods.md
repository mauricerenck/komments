# Page and Site methods

## Page methods

| Method                        | Return type | Description                                                                               |
| ----------------------------- | ----------- | ----------------------------------------------------------------------------------------- |
| `$page->comments()`           | Structure   | Returns all published comments for the page                                               |
| `$page->commentsAreEnabled()` | Boolean     | Checks if comments are enabled for the page. Returns `true` if enabled, `false` otherwise |
| `$page->commentCount()`       | Integer     | Returns the number of published comments of the page                                      |

## Site methods

| Method                             | Return type | Description                                         |
| ---------------------------------- | ----------- | --------------------------------------------------- |
| `$page->numberOfPendingComments()` | Integer     | Returns the number of comments waiting for approval |
| `$page->numberOfSpamComments()`    | Integer     | Returns the number of comments marked as spam       |

## Filtering comments

The page method `$page->comments()` returns all published comments for the page. As it return a Kirby `Structure` object, you can use the `filter()` method to filter the comments by any field.
In general you can use any of Kirbys methods available for the `Structure` object: https://getkirby.com/docs/reference/objects/cms/structure

The following fields are available for filtering:

| Field          | Type           | Description                                                            |
| -------------- | -------------- | ---------------------------------------------------------------------- |
| `id`           | String         | The unique ID of the comment                                           |
| `pageUuid`     | String         | The unique UUID of the page the comment is related to                  |
| `parentId`     | String or NULL | The unique UUID of parent comment in case of a reply                   |
| `type`         | String         | The type of the comment (see below)                                    |
| `content`      | String         | The comment itself                                                     |
| `authorName`   | String         | The name of the comment author                                         |
| `authorAvatar` | String         | The avatar url of the comment author                                   |
| `authorEmail`  | String         | The email address of the comment author (if enabled)                   |
| `authorUrl`    | String         | The url the comment author                                             |
| `published`    | Boolean        | If the comment is published or not                                     |
| `verified`     | Boolean        | If the comment is verified or not                                      |
| `spamlevel`    | Integer        | A number between `0` and `100` - representing the chance of being spam |
| `language`     | String         | If used on a multilanguage site, the language of the page              |
| `upvotes`      | Integer        | Feature not available yet                                              |
| `downvotes`    | Integer        | Feature not available yet                                              |
| `createdAt`    | String         | Date string                                                            |
| `updatedAt`    | String         | Date string                                                            |
| `permalink`    | String         | The deeplink of the comment `/@/comment/ID'`                           |

## Comment types

| Type          | Description                              |
| ------------- | ---------------------------------------- |
| `comment`     | A comment submitted via the comment form |
| `like-of`     | A webmention like                        |
| `repost-of`   | A webmention repost                      |
| `bookmark-of` | A webmention bookmark                    |
| `in-reply-to` | A webmention reply                       |
| `mention-of`  | A webmention mention                     |
| `rsvp`        | A webmention rsvp                        |
| `invite`      | A webmention invite                      |
