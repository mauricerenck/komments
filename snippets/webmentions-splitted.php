<?php

namespace mauricerenck\Komments;

$kommentsFrontend = new KommentsFrontend();
$commentList = $kommentsFrontend->getCommentList($page);

function addReply($comment, $comments)
{
    snippet('komments/type/reply', ['komment' => $comment]);

    $replies = $comments->filterBy('mentionOf', '==', $comment->id());

    if ($replies->count() > 0) {
        echo '<ul>';
        foreach ($replies as $reply) {
            addReply($reply, $comments);
        }
        echo '</ul>';
    }
}
?>
<div id="kommentsWebmentions">
    <div class="splitted-komments">
        <?php if ($commentList['likes']->count() > 0) : ?>
            <h5><?php echo t('mauricerenck.komments.headline.likes'); ?></h5>
            <div class="list-likes">
                <?php $likes = $commentList['likes']; ?>
                <?php foreach ($likes as $comment) : snippet('komments/type/like', ['komment' => $comment]);
                endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($commentList['reposts']->count() > 0) : ?>
            <h5><?php echo t('mauricerenck.komments.headline.reposts'); ?></h5>
            <div class="list-reposts">
                <?php foreach ($commentList['reposts'] as $comment) : snippet('komments/type/repost', ['komment' => $comment]);
                endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($commentList['mentions']->count() > 0) : ?>
            <h5><?php echo t('mauricerenck.komments.headline.mentions'); ?></h5>
            <div class="list-mentions">
                <?php foreach ($commentList['mentions'] as $comment) : snippet('komments/type/mention', ['komment' => $comment]);
                endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($commentList['comments']->count() > 0) : ?>
            <h5><?php echo t('mauricerenck.komments.headline.comments'); ?></h5>
            <ul class="list-comments">
                <?php foreach ($commentList['comments']->filterBy('mentionOf', '*=', 'http') as $comment) : addReply($comment, $commentList['comments']);
                endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ($commentList['replies']->count() > 0) : ?>
            <h5><?php echo t('mauricerenck.komments.headline.replies'); ?></h5>
            <ul class="list-replies">
                <?php foreach ($commentList['replies'] as $comment) :  snippet('komments/type/reply', ['komment' => $comment]);
                endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>