<li class="single-komment komment-type-<?php echo strtolower($komment->kommentType()); ?> <?php echo ($komment->verified()->isTrue()) ? 'verified' : '' ?>" id="komment_<?php echo $komment->id(); ?>">
    <div class="type-of"><?php echo option('mauricerenck.komments.komment-icon-reply'); ?></div>
    <div class="author-avatar">
        <a href="<?php echo $komment->authorUrl(); ?>" rel="nofollow" target="_blank">
            <img src="<?php echo $komment->avatar(); ?>" alt="<?php echo $komment->author(); ?>">
        </a>
    </div>
    <div class="author-action">
        <?php if ($komment->verified()->isTrue()) : ?><span class="verified-badge"><?php echo option('mauricerenck.komments.komment-icon-verified', '✅'); ?></span><?php endif; ?>
        <?php if($komment->authorUrl()->isNotEmpty()): ?>
            <a href="<?php echo $komment->authorUrl(); ?>" rel="nofollow" target="_blank"><?php echo $komment->author(); ?></a>&nbsp;
        <?php else: ?>
            <?php echo $komment->author(); ?>
        <?php endif; ?>
        <?php echo t('mauricerenck.komments.replied'); ?>
    </div>
    <div class="mention-content">
        <?php if ($komment->komment()->komment()->isNotEmpty()) : ?>
            <div class="komment-text">
                <span class="date"><?php echo $komment->published()->published()->toDate('d.m.Y H:i'); ?></span>
                <?php echo $komment->komment()->komment()->kirbytext(); ?>
            </div>
        <?php endif; ?>
        <a href="#kommentform" class="kommentReply <?php echo option('mauricerenck.komments.replyClassNames'); ?>" data-id="<?php echo $komment->id(); ?>" data-handle="<?php echo $komment->author(); ?>"><?php echo t('mauricerenck.komments.action.reply.text'); ?></a>
    </div>
</li>