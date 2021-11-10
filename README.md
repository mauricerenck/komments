# Komments 
#### A Kirby comment plugin

![GitHub release](https://img.shields.io/github/release/mauricerenck/komments.svg?maxAge=1800) ![License](https://img.shields.io/github/license/mashape/apistatus.svg) ![Kirby Version](https://img.shields.io/badge/Kirby-3.5%2B-black.svg)

---

![the dashboard](/doc-assets/komments-dashboard.png)

## Installation

Use one of these three methods to install the plugin:

- composer (recommended): `composer require mauricerenck/komments`
- zip file: unzip [master.zip](https://github.com/mauricerenck/komments/releases/latest) as folder `site/plugins/komments`
- git: `git submodule add https://github.com/mauricerenck/komments.git site/plugins/komments`

### Setup

* [How to configure the plugin](docs/options.md)
* [Setting up the panel](#)
* [Setting up your templates](docs/templates.md)
* [Receive and send Webmentions](docs/webmentions.md)
* [FAQ](docs/faq.md)

---
## Features

- Receive comments from a form on your site
  - The user will be informed that the comment is in moderation
  - Spam detection
  - auto delete spam or just mark comments as spam
- Receive webmentions (using an additional plugin)
- Panel support
  - Dashboard for comments in moderation/spam
  - Moderate comments on the panel page
  - Disable/enable comments per page
- Disable comments after a certain number of days in relation to the publish date
- Reply to comments
- Verified badge for logged in users



---

## Roadmap 

- [x] Kirby 3.6 ready
- [x] New panel view for moderation
  - [x] Mark comment as spam
  - [x] Mark comment as verified
  - [x] Delete comment
- [x] Pending comments field
- [x] Switch to KirbyUp
- [ ] Reply from within panel
- [ ] Comments list on page level
- [ ] Move "send to mastodon" to IndieConnector
- [ ] Move "ping archive.org" to IndieConnector
- [ ] Move "send webmentions" to IndieConnector
- [ ] Mark webmentions from known users as verified

---

## Soon Deprecated

- Send webmentions
- Send updates to Mastodon
- Ping archive.org
