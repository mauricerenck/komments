<?php

namespace mauricerenck\Komments;

use Kirby\Toolkit\Str;

$storage = StorageFactory::create();
$parentComment = $storage->getSingleComment($page->inReplyTo());

if (!$parentComment) {
    go('error');
}
?>
<html>

<head>
    <?php echo css(['/media/plugins/mauricerenck/komments/komments.css']); ?>
</head>

<body>
    <div style="max-width: 500px; margin: 50px auto; border: 1px solid #ccc; border-radius: 5px; padding: 20px;">
        <article class="h-entry">
            <h1 class="p-name"><?= $page->title() ?></h1>

            <div class="p-summary">
                <p><?= Str::short($page->text()->kt(), 200); ?></p>
            </div>
            <p class="e-content"><?= $page->text()->kt(); ?></p>
            <a class="u-url" href="<?= $page->commentLink() ?>">Permalink</a>

            <a class="u-in-reply-to" href="<?= $parentComment->authorUrl() ?>"><?= $parentComment->authorUrl() ?></a>

            <time class="published date dt-published"
                itemprop="datePublished"
                datetime="<?= $parentComment->createdAt()->toDate('Y-m-d H:i:s') ?>">
                <?= $parentComment->createdAt()->toDate('d.m.Y') ?>
            </time>

            <p class="h-card" style="margin-top: 50px; border-top: 1px solid #ccc; padding-top: 50px;">
                <img class="u-photo" src="<?= $page->authorAvatar() ?>" alt="" />
                <a class="p-name u-url" href="<?= $site->url() ?>"><?= $page->authorName() ?></a>
            </p>
        </article>
    </div>
</body>

</html>