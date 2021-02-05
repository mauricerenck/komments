<li class="single-komment komment-type-<?php echo strtolower($komment['kommenttype']); ?>" id="komment_<?php echo $komment['id']; ?>">
    <div class="type-of"><?php echo option('mauricerenck.komments.komment-icon-reply'); ?></div>
    <div class="author-avatar">
        <a href="<?php echo $komment['authorurl']; ?>" rel="nofollow" target="_blank">
            <img src="<?php echo $komment['avatar']; ?>" alt="<?php echo $komment['author']; ?>">
        </a>
    </div>
    <div class="author-action">
        <a href="<?php echo $komment['authorurl']; ?>" rel="nofollow" target="_blank"><?php echo $komment['author']; ?></a>&nbsp;
        <?php echo t('mauricerenck.komments.replied'); ?>
    </div>
    <div class="mention-content">
        <?php if ($komment['quote']->quote()->isNotEmpty()): ?>
            <div class="quote"><p><?php echo $komment['quote']->quote()->html(); ?></p></div>
        <?php endif; ?>
        <?php if ($komment['komment']->komment()->isNotEmpty()): ?>
            <div class="komment-text">
                <span class="date"><?php echo $komment['published']->published()->toDate('d.m.Y H:i'); ?></span>
                <?php echo $komment['komment']->komment()->kirbytext(); ?>
            </div>
        <?php endif; ?>
        <a href="#kommentform" class="kommentReply" data-id="<?php echo $komment['id']; ?>" data-handle="<?php echo $komment['author']; ?>">Reply</a>
    </div>
</li>