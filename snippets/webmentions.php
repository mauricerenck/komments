<?php
    $kommenTypes = ['like-of' => 'fas fa-heart', 'repost-of' => 'fas fa-share', 'komment' => 'fas fa-comment-alt-smile', 'in-reply-to' => 'fas fa-comment-alt-smile', 'mention-of' => 'far fa-link'];
    $komments = $page->kommentsInbox()->toStructure();
    $kommentActions = ['like-of' => 'komment_liked', 'repost-of' => 'komment_shared', 'komment' => 'komment_replied', 'in-reply-to' => 'komment_replied', 'mention-of' => 'komment_mentioned'];
?>

<div id="kommentsWebmentions">
<?php foreach ($komments as $reply) : ?>
    <?php $wmProperty = (string) $reply->wmProperty(); ?>

    <div class="single-komment <?php echo $wmProperty; ?>">
        <div class="type-of"><i class="<?php echo $kommenTypes[$wmProperty]; ?>"></i></div>
        <div class="author-avatar"><a href="<?php echo $reply->authorUrl(); ?>" rel="nofollow" target="_blank"><img src="<?php echo $reply->avatar(); ?>" alt="<?php echo $reply->author(); ?>"></a></div>
        <div class="author-action"><a href="<?php echo $reply->authorUrl(); ?>" rel="nofollow" target="_blank">@<?php echo $reply->author(); ?></a> <?php echo t($kommentActions[$wmProperty]); ?></div>
        <div class="mention-content">
            <?php if ($reply->quote()->isNotEmpty()): ?> 
                <div class="quote"><p><?php echo $reply->quote()->html(); ?></p></div>
            <?php endif; ?>
            <?php if ($reply->komment()->isNotEmpty()): ?> 
              <div class="komment-text"><?php echo $reply->komment()->html(); ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>