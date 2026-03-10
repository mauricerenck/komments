<?php if ($commentList = site()->latestComments()) : ?>
    <ul class="latest-comments">
        <?php foreach ($commentList as $comment) : ?>
            <?php $page = page($comment->pageUuid()); ?>
            <li>
                <span class="comment-author"><?= $comment->authorName(); ?></span>
                &mdash;
                <a href="<?= $page->url(); ?>#c<?= $comment->id(); ?>">
                    <?= $page->title(); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>