<?php
    $classNames = ['u-comment', 'h-cite'];
    $classNames[] = 'comment-type_' . $comment->type();

    if ($comment->verified()->isTrue()) {
        $classNames[] = 'verified';
    }
?>
<li class="<?= implode(' ', $classNames); ?>" id="c<?= $comment->id(); ?>">
    <?php if ($header = $slots->header()): ?>
        <?= $header ?>
    <?php else: ?>
        <header class="h-card">
            <img class="u-photo" src="<?= $comment->authorAvatar(); ?>" alt="<?= $comment->authorName(); ?>"/>
            <?php if ($comment->authorUrl()->isNotEmpty()): ?>
                <a class="u-author" href="<?= $comment->authorUrl(); ?>" rel="nofollow" target="_blank"><?= $comment->authorName(); ?></a>
            <?php else: ?>
                <span class="p-author"><?= $comment->authorName(); ?></span>
            <?php endif; ?>
        </header>
    <?php endif; ?>

    <?php if ($body = $slots->body()): ?>
        <?= $body ?>
    <?php else: ?>
        <div class="p-content p-name"><?= $comment->content()->kirbytext(); ?></div>
    <?php endif; ?>

    <?php if ($footer = $slots->footer()): ?>
        <?= $footer ?>
    <?php else: ?>
        <footer>
            <a class="u-url" href="<?= $comment->permalink(); ?>">
                <time class="dt-published"><?= $comment->createdAt(); ?></time>
            </a>
            <a href="#kommentform" class="kommentReply" data-id="<?= $comment->id(); ?>" data-handle="<?= $comment->authorName(); ?>"><?= t('mauricerenck.komments.action.reply.text'); ?></a>
        </footer>
    <?php endif; ?>
</li>
