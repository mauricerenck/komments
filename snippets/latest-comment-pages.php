<?php if ($commentGroups = site()->latestCommentsPerPage()) : ?>
    <ul class="latest-comment-pages">
        <?php foreach ($commentGroups as $commentGroup) : ?>
            <?php
            $latestComment = $commentGroup->first();
            $page = page($latestComment->pageUuid());
            $commentCount = $commentGroup->count();
            ?>
            <li>
                <a href="<?= $page->url(); ?>#c<?= $latestComment->id(); ?>">
                    <span class="comment-page-title"><?= $page->title(); ?></span>
                    <span class="comment-info">(<?= $commentCount; ?> <?= t('mauricerenck.komments.comments') ?>, <?= t('mauricerenck.komments.latestBy') ?> <?= $latestComment->authorName(); ?>)</span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>