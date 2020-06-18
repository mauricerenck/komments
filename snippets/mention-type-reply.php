<div class="single-komment komment-type-<?php echo strtolower($komment->kommenttype()->raw()); ?>">
    <div class="type-of"><?php echo option('mauricerenck.komments.komment-icon-reply'); ?></div>
    <div class="author-avatar">
        <a href="<?php echo $komment->authorUrl(); ?>" rel="nofollow" target="_blank">
            <img src="<?php echo $komment->avatar(); ?>" alt="<?php echo $komment->author(); ?>">
        </a>
    </div>
    <div class="author-action">
        <a href="<?php echo $komment->authorUrl(); ?>" rel="nofollow" target="_blank">
            @<?php echo $komment->author(); ?>
        </a>
        <?php echo t('mauricerenck.komments.replied'); ?>
    </div>
    <div class="mention-content">
        <?php if ($komment->quote()->isNotEmpty()): ?>
            <div class="quote"><p><?php echo $komment->quote()->kirbytext(); ?></p></div>
        <?php endif; ?>
        <?php if ($komment->komment()->isNotEmpty()): ?>
            <div class="komment-text"><?php echo $komment->komment()->kirbytext(); ?></div>
        <?php endif; ?>
    </div>
</div>