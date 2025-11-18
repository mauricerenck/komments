## [3.7.7](https://github.com/mauricerenck/komments/compare/v3.7.6...v3.7.7) (2025-11-18)


### Bug Fixes

* migration history ([01f948c](https://github.com/mauricerenck/komments/commit/01f948c55fea08e81723dcfc924f7e45784b4aad))

## [3.7.6](https://github.com/mauricerenck/komments/compare/v3.7.5...v3.7.6) (2025-11-17)


### Bug Fixes

* migrate existing comment status ([ac66a7b](https://github.com/mauricerenck/komments/commit/ac66a7b40388732c116b6edd6b549f42a58e8392))

## [3.7.5](https://github.com/mauricerenck/komments/compare/v3.7.4...v3.7.5) (2025-11-13)


### Bug Fixes

* correct status for webmentions ([5980e4d](https://github.com/mauricerenck/komments/commit/5980e4daba42cda03d1c13cdb95c0ca8396067fb))
* filter comments by new status field ([c56fae1](https://github.com/mauricerenck/komments/commit/c56fae17991b620109f8ec013f844f7f014fd503))

## [3.7.4](https://github.com/mauricerenck/komments/compare/v3.7.3...v3.7.4) (2025-11-13)


### Bug Fixes

* filter unverified comments in panel and notifications ([89d5c82](https://github.com/mauricerenck/komments/commit/89d5c828f75b60196a25b2738163786a945dfb45))

## [3.7.3](https://github.com/mauricerenck/komments/compare/v3.7.2...v3.7.3) (2025-11-12)


### Bug Fixes

* change field name due to issues ([fe01021](https://github.com/mauricerenck/komments/commit/fe0102182c8a50560ee84d4653fd38e5aaf3afb5))

## [3.7.2](https://github.com/mauricerenck/komments/compare/v3.7.1...v3.7.2) (2025-11-12)


### Bug Fixes

* remove sqlite status check ([38280af](https://github.com/mauricerenck/komments/commit/38280afe5a73b9fc6ef208e6e2960a2b499c15ba))

## [3.7.1](https://github.com/mauricerenck/komments/compare/v3.7.0...v3.7.1) (2025-11-09)


### Bug Fixes

* type mixups ([4448fec](https://github.com/mauricerenck/komments/commit/4448fece42abfc8c365acea95b53e6808deb65e5))

# [3.7.0](https://github.com/mauricerenck/komments/compare/v3.6.0...v3.7.0) (2025-11-08)


### Features

* email verification ([414b04e](https://github.com/mauricerenck/komments/commit/414b04ed4fcf2cb7d39db84fa56398b43b12f079))

# [3.6.0](https://github.com/mauricerenck/komments/compare/v3.5.0...v3.6.0) (2025-10-08)


### Features

* spam phrases and keywords ([cfa7bb7](https://github.com/mauricerenck/komments/commit/cfa7bb7d156120acdbdf0152cee959eb4391803c))

# [3.5.0](https://github.com/mauricerenck/komments/compare/v3.4.0...v3.5.0) (2025-09-05)


### Features

* Enriched Notifications ([e991980](https://github.com/mauricerenck/komments/commit/e9919809f9964714efad767bfa573d4a492fb5b5)), closes [#78](https://github.com/mauricerenck/komments/issues/78) [#78](https://github.com/mauricerenck/komments/issues/78) [#75](https://github.com/mauricerenck/komments/issues/75)

# [3.4.0](https://github.com/mauricerenck/komments/compare/v3.3.1...v3.4.0) (2025-07-11)


### Features

* detect duplicated webmentions and dont store them again ([3593d11](https://github.com/mauricerenck/komments/commit/3593d11100036e89d7394917a8d2573804b7dc1a))

## [3.3.1](https://github.com/mauricerenck/komments/compare/v3.3.0...v3.3.1) (2025-06-22)


### Bug Fixes

* avatar return string prevented saving comments in some cases ([f14a03f](https://github.com/mauricerenck/komments/commit/f14a03f329a72a7d89991d71800e7c25b2e3df0d))
* prevent malicious chars in comment text ([01d0ca4](https://github.com/mauricerenck/komments/commit/01d0ca49329bf8a4be3be3332553d818c9d42d32))

# [3.3.0](https://github.com/mauricerenck/komments/compare/v3.2.3...v3.3.0) (2025-06-20)


### Bug Fixes

* hand empty string secrets ([91ac5b0](https://github.com/mauricerenck/komments/commit/91ac5b0a1fa82bddb4cb9fe7cf546db2d9617f5d))


### Features

* new moderation hooks [#76](https://github.com/mauricerenck/komments/issues/76) ([7d7e355](https://github.com/mauricerenck/komments/commit/7d7e3558fedd1a11f945b40e3ab7f9c9a020cbd8))

## [3.2.3](https://github.com/mauricerenck/komments/compare/v3.2.2...v3.2.3) (2025-06-20)


### Bug Fixes

* allow different outputs for better backwards compatibility ([47856c5](https://github.com/mauricerenck/komments/commit/47856c5fb51362e3549e8c1fadf6296ed9c80d7a))

## [3.2.2](https://github.com/mauricerenck/komments/compare/v3.2.1...v3.2.2) (2025-06-20)


### Bug Fixes

* allow different return types ([5fe9e44](https://github.com/mauricerenck/komments/commit/5fe9e4458830646a045bf375657953f746d72c11))

## [3.2.1](https://github.com/mauricerenck/komments/compare/v3.2.0...v3.2.1) (2025-06-20)


### Bug Fixes

* reset default avatar service to gravatar ([3b042e6](https://github.com/mauricerenck/komments/commit/3b042e60fc6deb9dda072c48f2678076ce6f43c3))

# [3.2.0](https://github.com/mauricerenck/komments/compare/v3.1.1...v3.2.0) (2025-06-20)


### Features

* use different avatar services ([4609a43](https://github.com/mauricerenck/komments/commit/4609a4338d5805b8b7218ff0081fee624d027c51))

## [3.1.1](https://github.com/mauricerenck/komments/compare/v3.1.0...v3.1.1) (2025-04-18)


### Bug Fixes

* check if the x-return-type header is in request header ([#72](https://github.com/mauricerenck/komments/issues/72)) ([2131b85](https://github.com/mauricerenck/komments/commit/2131b853ee01c1feabcdb52f5c9d5ab51d687658))

# [3.1.0](https://github.com/mauricerenck/komments/compare/v3.0.4...v3.1.0) (2025-04-04)


### Features

* reply via webmention ([#74](https://github.com/mauricerenck/komments/issues/74)) ([4f634a0](https://github.com/mauricerenck/komments/commit/4f634a0bc1814db5472e2079b302766eb39cd85a))

## [3.0.4](https://github.com/mauricerenck/komments/compare/v3.0.3...v3.0.4) (2025-04-04)


### Bug Fixes

* use hostname as author of webmentions when not author name present ([9655e20](https://github.com/mauricerenck/komments/commit/9655e2085e88c30075f6fc2107f0e7c1415a64b3))

## [3.0.3](https://github.com/mauricerenck/komments/compare/v3.0.2...v3.0.3) (2025-03-26)


### Bug Fixes

* gravatar link is saved instead of the e-mail address ([#71](https://github.com/mauricerenck/komments/issues/71)) ([2a42356](https://github.com/mauricerenck/komments/commit/2a42356cc5991daf85ed3b71d3b71694b082a91f))

## [3.0.2](https://github.com/mauricerenck/komments/compare/v3.0.1...v3.0.2) (2025-03-21)


### Bug Fixes

* use textare field to avoid html content in replis ([ba5188a](https://github.com/mauricerenck/komments/commit/ba5188a54f1f7c7544c3410696355f9c17dda078))

## [3.0.1](https://github.com/mauricerenck/komments/compare/v3.0.0...v3.0.1) (2025-03-20)


### Bug Fixes

* single language handling in form ([132050c](https://github.com/mauricerenck/komments/commit/132050c93ff343988427aafd69d66be422d4ff8c))

# [3.0.0](https://github.com/mauricerenck/komments/compare/v2.1.2...v3.0.0) (2025-03-18)


### Features

* komments version 3 ([#69](https://github.com/mauricerenck/komments/issues/69)) ([c9553bc](https://github.com/mauricerenck/komments/commit/c9553bca7380ac54df5c8146fb51f1a6d17ef368))


### BREAKING CHANGES

* old comments have to be migrated

* feat: SQLite storage

* feat: new folder structure

* feat: database migrations

* feat: comments deep link via uuid

* feat: new snippets for lists and responses
* old snippets are deprecated, new snippets with different names and more condensed

* feat: new panel view

* feat: new comment moderation panel view

* feat: reply from panel

* feat: manage comments on page level

* feat: show or hide webmentions in moderation view via field config or options

* feat: updated comment form with less overhead

* feat: new markdown inbox format

* feat: akismet spam detection

* feat: migration flow in panel

## [2.1.2](https://github.com/mauricerenck/komments/compare/v2.1.1...v2.1.2) (2024-09-02)


### Bug Fixes

* new webmention format can be a string for targetpage ([a3714ea](https://github.com/mauricerenck/komments/commit/a3714eae7c36c4859a97811fe4039cc2dd960bb4)), closes [#68](https://github.com/mauricerenck/komments/issues/68)

## [2.1.1](https://github.com/mauricerenck/komments/compare/v2.1.0...v2.1.1) (2024-08-10)


### Bug Fixes

* only create webhook debug files when debug enabled ([5bf780c](https://github.com/mauricerenck/komments/commit/5bf780cb5491fd0a460dd2d2510e5ba72a8e4be0))

# [2.1.0](https://github.com/mauricerenck/komments/compare/v2.0.5...v2.1.0) (2024-08-06)


### Features

* handle new indieconnector types ([d6696b5](https://github.com/mauricerenck/komments/commit/d6696b5062fc91ae9d6357082dddacc08563e18d))

## [2.0.5](https://github.com/mauricerenck/komments/compare/v2.0.4...v2.0.5) (2024-05-14)


### Bug Fixes

* pending comments shown on page ([422a8e8](https://github.com/mauricerenck/komments/commit/422a8e85f02d4df78e2eb407fe25ec3b58c8a0f0))

## [2.0.4](https://github.com/mauricerenck/komments/compare/v2.0.3...v2.0.4) (2024-04-30)


### Bug Fixes

* comment moderation on non-primary language ([3bda0f2](https://github.com/mauricerenck/komments/commit/3bda0f284f8e415a95fec35cc1581957bcf0762c))

## [2.0.3](https://github.com/mauricerenck/komments/compare/v2.0.2...v2.0.3) (2024-03-04)


### Bug Fixes

* privacy text ([bf4cbea](https://github.com/mauricerenck/komments/commit/bf4cbea892d2e73119841703a29cb29a6bb79182))

## [2.0.2](https://github.com/mauricerenck/komments/compare/v2.0.1...v2.0.2) (2024-03-04)


### Bug Fixes

* multilanguage inbox handling ([e51bcc9](https://github.com/mauricerenck/komments/commit/e51bcc925927631dd720ad26a7a0fa22ec3b6494))

## [2.0.1](https://github.com/mauricerenck/komments/compare/v2.0.0...v2.0.1) (2024-03-04)


### Bug Fixes

* handle missing inbox ([2f539e4](https://github.com/mauricerenck/komments/commit/2f539e4d3d96c1b3a68f5c0fdc8ccdadad312a98))

# [2.0.0](https://github.com/mauricerenck/komments/compare/v1.13.2...v2.0.0) (2024-03-04)


* Code and compatibility improvements (#66) ([51e4ccf](https://github.com/mauricerenck/komments/commit/51e4ccf8a09ae8b9454c86c7d4ce1bcb8721947d)), closes [#66](https://github.com/mauricerenck/komments/issues/66)


### BREAKING CHANGES

* Komments plugin will not use cookies anymore

* improvement: use structures in snippets no more arrays
* comments and replies are splitted, strcutures are used now

* chore: add deprecation warning

* improvement: base utils optimization

* feat: added frontend class (wip)

* feat: removed unused quote feature

BRAKING CHANGE: Quotes are getting removed

* improvement: moved kommentsAreExpired to frontend class

* feat: multilang page mock

* improvement: tests

* chore: ignore tilde folder

* chore: remove dump

* chore: class loader

* improvement: refactored classes and tests

* improvement: remove needless api calls

* fix: better backwards compatibility with Kirby 3

* chore: added translations

* fix: show all language comments in panel

* improvement: reduced css
* CSS has been reduced to a minimum

## [1.13.2](https://github.com/mauricerenck/komments/compare/v1.13.1...v1.13.2) (2024-01-22)


### Bug Fixes

* better mocks for tests ([1160be6](https://github.com/mauricerenck/komments/commit/1160be66f503c463e3fa88fd3100bd404b1a1403)), closes [#64](https://github.com/mauricerenck/komments/issues/64)

## [1.13.1](https://github.com/mauricerenck/komments/compare/v1.13.0...v1.13.1) (2023-12-18)


### Bug Fixes

* js get submit button if not input element ([0f1883b](https://github.com/mauricerenck/komments/commit/0f1883beb4bdf901c03c572c09c2a0da8f1095ae))

# [1.13.0](https://github.com/mauricerenck/komments/compare/v1.12.2...v1.13.0) (2023-11-28)


### Features

* kirby 4 release ([#62](https://github.com/mauricerenck/komments/issues/62)) ([86ba8e2](https://github.com/mauricerenck/komments/commit/86ba8e2d0d3ce15775aff91ac0d549173cc6eb0f)), closes [#61](https://github.com/mauricerenck/komments/issues/61)

## [1.12.2](https://github.com/mauricerenck/komments/compare/v1.12.1...v1.12.2) (2023-10-29)


### Bug Fixes

* handle empty mail address in webmentions [#60](https://github.com/mauricerenck/komments/issues/60) ([8c5b3e8](https://github.com/mauricerenck/komments/commit/8c5b3e84a2da4f61574ff172acb616b175f12dbd))

## [1.12.1](https://github.com/mauricerenck/komments/compare/v1.12.0...v1.12.1) (2023-09-21)


### Bug Fixes

* thank you message translation ([#59](https://github.com/mauricerenck/komments/issues/59)) ([f4cbfa3](https://github.com/mauricerenck/komments/commit/f4cbfa3a6f398ccb888ab9a6cc4c9e252c7a054a)), closes [/github.com/mauricerenck/komments/pull/59#issuecomment-1729101856](https://github.com//github.com/mauricerenck/komments/pull/59/issues/issuecomment-1729101856)

# [1.12.0](https://github.com/mauricerenck/komments/compare/v1.11.1...v1.12.0) (2023-09-13)


### Features

* added option to store email of senders ([#58](https://github.com/mauricerenck/komments/issues/58)) ([2d0f4e6](https://github.com/mauricerenck/komments/commit/2d0f4e61b869b0fc1943f6b857d41bde3b3312c2))

## [1.11.1](https://github.com/mauricerenck/komments/compare/v1.11.0...v1.11.1) (2023-08-08)


### Bug Fixes

* get page from url when slug is translated ([5bc51b4](https://github.com/mauricerenck/komments/commit/5bc51b4c9cc3e44de7cd2ff9e0c5e9c99e2c3683)), closes [#56](https://github.com/mauricerenck/komments/issues/56)

# [1.11.0](https://github.com/mauricerenck/komments/compare/v1.10.0...v1.11.0) (2022-12-06)


### Features

* autopublish comments of configured email addresses ([b7ac409](https://github.com/mauricerenck/komments/commit/b7ac409ebfba5d04a815e5b50be36c4c8895f25f))

# [1.10.0](https://github.com/mauricerenck/komments/compare/v1.9.1...v1.10.0) (2022-10-15)


### Features

* kirby 3.8 removed deprecated server ([bfb18d9](https://github.com/mauricerenck/komments/commit/bfb18d9f5199845ef4668fe6d25b3b1cb8ac556c))

## [1.9.1](https://github.com/mauricerenck/komments/compare/v1.9.0...v1.9.1) (2022-07-01)


### Bug Fixes

* some code cleanup ([289b2b0](https://github.com/mauricerenck/komments/commit/289b2b0b5ed68dcdec7110931e8cc75a9aeaaec4))

# [1.9.0](https://github.com/mauricerenck/komments/compare/v1.8.2...v1.9.0) (2022-07-01)


### Features

* support for kirby 3.7 stats sections ([961d857](https://github.com/mauricerenck/komments/commit/961d857f563400d920cadab187db086ef38960cf))

## [1.8.2](https://github.com/mauricerenck/komments/compare/v1.8.1...v1.8.2) (2022-04-26)


### Bug Fixes

* bump version ([63096e1](https://github.com/mauricerenck/komments/commit/63096e12f7865c8dfc67fbeb5474ea3c346b1e56))

## [1.8.1](https://github.com/mauricerenck/komments/compare/v1.8.0...v1.8.1) (2022-04-11)


### Bug Fixes

* panel url in mail notification ([c63bcd2](https://github.com/mauricerenck/komments/commit/c63bcd22068726ad1f013a01ebe06e4911fde989))

# [1.8.0](https://github.com/mauricerenck/komments/compare/v1.7.0...v1.8.0) (2022-03-25)


### Features

* auto publish comments of verified users ([de0e17c](https://github.com/mauricerenck/komments/commit/de0e17caa2f0126a240e2738a942ee52d7128b79))

# [1.7.0](https://github.com/mauricerenck/komments/compare/v1.6.0...v1.7.0) (2022-02-26)


### Features

* DEPRECATED removed sending webmentions ([#44](https://github.com/mauricerenck/komments/issues/44)) ([7d31fdb](https://github.com/mauricerenck/komments/commit/7d31fdb01e0791b78d4c4f5a77ea72fd5703a209))

# [1.6.0](https://github.com/mauricerenck/komments/compare/v1.5.2...v1.6.0) (2022-01-27)


### Features

* panel ui refinements ([6ebe3b9](https://github.com/mauricerenck/komments/commit/6ebe3b941ddbca5dcb4aa9a11eada0efd659146d))

## [1.5.2](https://github.com/mauricerenck/komments/compare/v1.5.1...v1.5.2) (2022-01-25)


### Bug Fixes

* php 8 boolean alias no more supported - use bool instead ([5cbca29](https://github.com/mauricerenck/komments/commit/5cbca29b141f76a474f65c4ed5b5c1220c1e239f))

## [1.5.1](https://github.com/mauricerenck/komments/compare/v1.5.0...v1.5.1) (2021-12-18)


### Bug Fixes

* transform webmention to comment bug when empty mentionOf field ([384711a](https://github.com/mauricerenck/komments/commit/384711a4f74f33d70a12da1ba0a0a6bd612c88bb))

# [1.5.0](https://github.com/mauricerenck/komments/compare/v1.4.0...v1.5.0) (2021-12-17)


### Features

* bump version ([#40](https://github.com/mauricerenck/komments/issues/40)) ([f1c60a4](https://github.com/mauricerenck/komments/commit/f1c60a4e3119db60b5a4665cf267c2fda930ae1c))

# [1.4.0](https://github.com/mauricerenck/komments/compare/v1.3.5...v1.4.0) (2021-11-15)


### Features

* receive webmentions from new indieconnector hook ([503039e](https://github.com/mauricerenck/komments/commit/503039eb1126a13e5381d5c23c522ab3a6e33708))

## [1.3.5](https://github.com/mauricerenck/komments/compare/v1.3.4...v1.3.5) (2021-11-13)


### Bug Fixes

* moved no comments screen into component ([67b26a8](https://github.com/mauricerenck/komments/commit/67b26a89fcccba0f7269865628fb21da53efbb85))

## [1.3.4](https://github.com/mauricerenck/komments/compare/v1.3.3...v1.3.4) (2021-11-13)


### Bug Fixes

* replace slug with id for nested pages [#31](https://github.com/mauricerenck/komments/issues/31) ([074aeca](https://github.com/mauricerenck/komments/commit/074aecac8a00d2f8ecf0ea21317e644746bd01c1))

## [1.3.3](https://github.com/mauricerenck/komments/compare/v1.3.2...v1.3.3) (2021-11-12)


### Bug Fixes

* set pending comments label via field settings [#32](https://github.com/mauricerenck/komments/issues/32) ([c2b56e7](https://github.com/mauricerenck/komments/commit/c2b56e783221dcf4f99bbd236b255b9c2c9a9728))

## [1.3.2](https://github.com/mauricerenck/komments/compare/v1.3.1...v1.3.2) (2021-11-12)


### Bug Fixes

* typo ([#33](https://github.com/mauricerenck/komments/issues/33)) ([f56b22a](https://github.com/mauricerenck/komments/commit/f56b22a6f0529ad15cb4fc9535d11f01fa3a9268))

## [1.3.1](https://github.com/mauricerenck/komments/compare/v1.3.0...v1.3.1) (2021-11-12)


### Bug Fixes

* use Exception to prevent 500 error [#31](https://github.com/mauricerenck/komments/issues/31) ([9ff17e3](https://github.com/mauricerenck/komments/commit/9ff17e301df0efffd67304a32f84cc7b3b1c8e0d))

# [1.3.0](https://github.com/mauricerenck/komments/compare/v1.2.0...v1.3.0) (2021-11-10)


### Features

* remove manually created changelog ([ec6a22e](https://github.com/mauricerenck/komments/commit/ec6a22e8be9be85dde78daf86a0f41426a8bc423))

# [1.2.0](https://github.com/mauricerenck/komments/compare/v1.1.0...v1.2.0) (2021-11-10)


### Features

* release test (sorry) ([9facbb3](https://github.com/mauricerenck/komments/commit/9facbb354bb6c84e4bdf604090b5e278078e9f1b))
