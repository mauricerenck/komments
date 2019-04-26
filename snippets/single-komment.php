<?php
    namespace Plugin\Komments;

    $kommentUtils = new ReadKomments();
    $komments = $kommentUtils->getKommentsByKomment($page, $komment->id());
?>
<div class="komment">

    <img src="https://www.gravatar.com/avatar/<?php echo md5($komment->email()); ?>?s=100" alt="avatar" class="komment-gravatar">
    <span class="komment-author"><?php echo $komment->Author(); ?></span>
    <time class="komment-published" itemprop="datePublished" datetime="<?= date('c', $komment->date()->toDate()); ?>"><?php echo utf8_encode(strftime('%d.%m.%Y %H:%M', $komment->date()->toDate())); ?></time>

    <div class="komment-text">
        <?php echo $komment->text()->kirbytext(); ?>
    </div>

    <div class="komment-actions">
        <a href="#komment-form" class="komment-reply" data-slug="<?php echo $komment->id(); ?>" data-author="<?php echo $komment->author(); ?>" data-gravatar="<?php echo md5($komment->email()); ?>">reply</a>
    </div>

    <div class="komment-replies">
        <?php if($komments !== null) : ?>
            <ol class="komment-list">
                <?php foreach($komments as $komment): ?>
                <li class="single-komment">
                    <?php snippet('komment/single', ['komment' => $komment]); ?>
                </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </div>
</div>