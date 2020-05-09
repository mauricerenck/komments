<div class="single-komment komment-type-<?php echo strtolower($komment->property()->raw()); ?>">
    <div class="type-of"><?php echo option('mauricerenck.komments.komment-icon-mention'); ?></div>
    <div class="author-avatar">
        <a href="<?php echo $komment->authorUrl(); ?>" rel="nofollow" target="_blank">
            <img src="<?php echo $komment->avatar(); ?>" alt="<?php echo $komment->author(); ?>">
        </a>
    </div>
    <div class="author-action">
        <a href="<?php echo $komment->authorUrl(); ?>" rel="nofollow" target="_blank">
            @<?php echo $komment->author(); ?>
        </a>
        <?php echo t('mauricerenck.komments.mentioned'); ?>
    </div>
</div>