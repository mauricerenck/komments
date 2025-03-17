# Komments

#### A Kirby comments plugin

![GitHub release](https://img.shields.io/github/release/mauricerenck/komments.svg?maxAge=1800) ![License](https://img.shields.io/github/license/mashape/apistatus.svg) ![Kirby Version](https://img.shields.io/badge/Kirby-4%2B-black.svg)

---

![the dashboard](/doc-assets/panel-moderation-view)

## Installation

Use one of these methods to install the plugin:

-   composer (recommended): `composer require mauricerenck/komments`
-   zip file: unzip [main.zip](https://github.com/mauricerenck/komments/releases/latest) as folder `site/plugins/komments`

## Setup

The new documentation can be found [here](https://maurice-renck.de/kirby/komments).

## Features

-   Receive comments from a form on your site
    -   The user will be informed that the comment is in moderation
    -   Spam detection
    -   auto delete spam or just mark comments as spam
-   Receive webmentions (using an additional plugin)
-   Panel support
    -   Dashboard for comments in moderation/spam
    -   Support for Kirby stats
    -   Moderate comments on the panel page
    -   Disable/enable comments per page
-   Disable comments after a certain number of days in relation to the publish date
-   Reply to comments
-   Verified users
-   Automatically publish comments of verified users
-   Automatically publish comments of specified users
-   E-Mail notifications for new comments (instant or via cronjob)

---

Please use the [IndieConnector Plugin](https://github.com/mauricerenck/indieConnector) to receive and send webmentions
