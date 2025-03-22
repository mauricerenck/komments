<?php

namespace mauricerenck\Komments;

use Kirby\Cms\App as Kirby;


@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('mauricerenck/komments', [
    'areas' => require_once(__DIR__ . '/plugin/areas.php'),
    'options' => require_once(__DIR__ . '/plugin/options.php'),
    'snippets' => require_once(__DIR__ . '/plugin/snippets.php'),
    'templates' => [
        'emails/newcomments' => __DIR__ . '/templates/emails/newComments.php',
        'response' => __DIR__ . '/templates/pages/response.php'
    ],
    'blueprints' => require_once(__DIR__ . '/plugin/blueprints.php'),
    'pageMethods' => require_once(__DIR__ . '/plugin/page-methods.php'),
    'siteMethods' => require_once(__DIR__ . '/plugin/site-methods.php'),
    'fields' => require_once(__DIR__ . '/plugin/fields.php'),
    'translations' => require_once(__DIR__ . '/plugin/translations.php'),
    'api' => require_once(__DIR__ . '/plugin/api.php'),
    'hooks' => require_once(__DIR__ . '/plugin/hooks.php'),
    'routes' => require_once(__DIR__ . '/plugin/routes.php'),
]);
