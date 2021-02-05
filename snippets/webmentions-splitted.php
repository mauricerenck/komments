<?php

  namespace mauricerenck\Komments;

    $kommentUtils = new KommentBaseUtils();
    $komments = $kommentUtils->parseKomments($page->kommentsInbox());
    $kommentList = ['LIKES' => [], 'REPOSTS' => [], 'REPLIES' => [], 'MENTIONS' => []];
    $kommentsInModeration = 0;

    function addReply($komment)
    {
        snippet('komments/type/reply', ['komment' => $komment]);

        if (count($komment['replies']) > 0) {
            echo '<ul>';
            foreach ($komment['replies'] as $reply) {
                addReply($reply);
            }
            echo '</ul>';
        }
    }

    foreach ($komments['replies'] as $komment) {
        if ($page->hasQueuedKomments($komment['komment']->id(), $komment['komment']->status())) {
            $kommentsInModeration++;
        }
    }
?>
<div id="kommentsWebmentions">

<?php if ($kommentsInModeration > 0): ?><div class="moderation-note" id="inModeration"><?php echo t('mauricerenck.komments.moderation'); ?></div><?php endif; ?>

<div class="splitted-komments">
    <?php if (count($komments['likes']) > 0) : ?>
        <h5><?php echo t('mauricerenck.komments.headline.likes'); ?></h5>
        <div class="list-likes">
            <?php foreach ($komments['likes'] as $komment) : snippet('komments/type/like', ['komment' => $komment]); endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (count($komments['reposts']) > 0) : ?>
        <h5><?php echo t('mauricerenck.komments.headline.reposts'); ?></h5>
        <div class="list-reposts">
            <?php foreach ($komments['reposts'] as $komment) : snippet('komments/type/repost', ['komment' => $komment]); endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (count($komments['mentions']) > 0) : ?>
        <h5><?php echo t('mauricerenck.komments.headline.mentions'); ?></h5>
        <div class="list-mentions">
            <?php foreach ($komments['mentions'] as $komment) : snippet('komments/type/mention', ['komment' => $komment]); endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (count($komments['replies']) > 0) : ?>
    <h5><?php echo t('mauricerenck.komments.headline.replies'); ?></h5>
    <ul class="list-replies">
        <?php foreach ($komments['replies'] as $komment) : addReply($komment); endforeach; ?>
    </ul>
<?php endif; ?>
</div>

</div>

