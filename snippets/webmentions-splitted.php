<div id="kommentsWebmentions">
<?php $komments = $page->kommentsInbox()->toStructure(); ?>
<?php $kommentList = ['LIKES' => [], 'REPOSTS' => [], 'REPLIES' => [], 'MENTIONS' => []]; ?>
<?php foreach ($komments as $komment) : ?>

    <?php if ($page->hasQueuedKomments($komment->id(), $komment->status())): ?>
        <div class="moderation-note" id="inModeration"><?php echo t('mauricerenck.komments.moderation'); ?></div>
    <?php endif; ?>

    <?php
    if ($komment->status()->isFalse()) {
        continue;
    }
    ?>

    <?php
        switch ($komment->kommenttype()->raw()) {
            case 'LIKE': $kommentList['LIKES'][] = snippet('komments/type/like', ['komment' => $komment], true); break;
            case 'REPOST': $kommentList['REPOSTS'][] = snippet('komments/type/repost', ['komment' => $komment], true); break;
            case 'REPLY': $kommentList['REPLIES'][] = snippet('komments/type/reply', ['komment' => $komment], true); break;
            case 'MENTION': $kommentList['MENTIONS'][] = snippet('komments/type/mention', ['komment' => $komment], true); break;
            default: $kommentList['REPLIES'][] = snippet('komments/type/reply', ['komment' => $komment], true); break;
        }
    ?>
<?php endforeach; ?>

<div class="splitted-komments">
    <?php if (count($kommentList['LIKES']) > 0) : ?>
        <h5><?php echo t('mauricerenck.komments.headline.likes'); ?></h5>
        <div class="list-likes">
            <?php foreach ($kommentList['LIKES'] as $like) : echo $like; endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (count($kommentList['REPOSTS']) > 0) : ?>
        <h5><?php echo t('mauricerenck.komments.headline.reposts'); ?></h5>
        <div class="list-reposts">
            <?php foreach ($kommentList['REPOSTS'] as $repost) : echo $repost; endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (count($kommentList['MENTIONS']) > 0) : ?>
        <h5><?php echo t('mauricerenck.komments.headline.mentions'); ?></h5>
        <div class="list-mentions">
            <?php foreach ($kommentList['MENTIONS'] as $mention) : echo $mention; endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php if (count($kommentList['REPLIES']) > 0) : ?>
    <h5><?php echo t('mauricerenck.komments.headline.replies'); ?></h5>
    <div class="list-mentions">
        <?php foreach ($kommentList['REPLIES'] as $reply) : echo $reply; endforeach; ?>
    </div>
<?php endif; ?>

</div>