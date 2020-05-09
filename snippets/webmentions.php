<div id="kommentsWebmentions">
<?php $komments = $page->kommentsInbox()->toStructure(); ?>
<?php foreach ($komments as $komment) : ?>

    <?php if ($page->hasQueuedKomments($komment->id(), $komment->status())): ?>
        <div class="moderation-note" id="inModeration"><?php echo t('mauricerenck.komments.moderation'); ?></div>
    <?php endif; ?>

    <?php if ($komment->status()->isFalse()) : continue; endif; ?>
    <?php

        switch ($komment->property()->raw()) {
            case 'LIKE': snippet('komments/type/like', ['komment' => $komment]); break;
            case 'REPOST': snippet('komments/type/repost', ['komment' => $komment]); break;
            case 'REPLY': snippet('komments/type/reply', ['komment' => $komment]); break;
            case 'MENTION': snippet('komments/type/mention', ['komment' => $komment]); break;
            default: snippet('komments/type/reply', ['komment' => $komment]); break;
        }
    ?>
<?php endforeach; ?>
</div>