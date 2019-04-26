<?php
namespace Plugin\Komments;
use Kirby;
use Kirby\Exception\Exception;
use Kirby\Http\Response;
use stdClass;

load([
    'Plugin\Komments\ReadKomments' => 'utils/readKomments.php',
    'Plugin\Komments\WriteKomments' => 'utils/writeKomments.php',
], __DIR__);

Kirby::plugin('mauricerenck/komments', [
    'options' => [
        'kommentUserId' => 'CHANGEME',
    ],
    'templates' => [],
    'blueprints' => [
        'users/komments' => __DIR__ . '/blueprints/users/komments.yml',
        'tabs/komments' => __DIR__ . '/blueprints/tabs/komments.yml',
        'pages/komments' => __DIR__ . '/blueprints/pages/komments.yml',
        'pages/komment' => __DIR__ . '/blueprints/pages/komment.yml'
    ],
    'snippets' => [
        'komment/list' => __DIR__ . '/snippets/list-komments.php',
        'komment/single' => __DIR__ . '/snippets/single-komment.php',
        'komments/form' => __DIR__ . '/snippets/komment-form.php',
    ],
    'routes' => [
        [
            'pattern' => '(:all)/komment/save',
            'action' => function () {
                $kommentData = new stdClass();
                $kommentData->title = substr($_POST['text'], 0, 30);
                $kommentData->author = $_POST['author'];
                $kommentData->email = $_POST['email'];
                $kommentData->text = $_POST['text'];
                $kommentData->replyTo = $_POST['replyTo'];

                $slug = $_POST['page_slug'];
                $kommentUtils = new WriteKomments();
                $kommentUtils->createKomment($slug, $kommentData);

                go($slug);
            },
            'method' => 'POST'
        ]
    ],
    'hooks' => []
]);