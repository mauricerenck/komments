<?php

namespace mauricerenck\Komments;

$storage = StorageFactory::create();
$comment = $storage->getSingleComment($page->commentId());

if (!$comment) {
    go('error');
}
?>
<html>

<head>
    <title><?= $page->title() ?></title>
</head>

<body>
    <div style="display: flex; place-items: center; justify-content: center; height: 100vh;">
        <div style="max-width: 500px; border: 1px solid #ccc; border-radius: 5px; padding: 20px; text-align: center;">
            <article class="h-entry">
                <h1 class="p-name"><?= $page->title() ?></h1>

                <p>Thank you for verifing your comment, <?= $comment->authorName(); ?>.</p>

                <?php $targetPage = page($comment->pageuuid()); ?>

                <?php if ($comment->published()->isTrue()): ?>
                    <p>You can view your comment here: <a href="<?= $targetPage->url(); ?>"><?= $targetPage->url(); ?></a></p>
                <?php else: ?>
                    <p>Your comment still awaits moderation and may be published soon.</p>
                    <p>You can view the original post here: <a href="<?= $targetPage->url(); ?>"><?= $targetPage->url(); ?></a></p>
                <?php endif; ?>

            </article>
        </div>
    </div>
</body>

</html>