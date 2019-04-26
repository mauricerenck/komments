<?php
    namespace Plugin\Komments;

    $kommentUtils = new ReadKomments();
    $komments = $kommentUtils->showKommentList($page);
?>
<div id="komments" class="komments">
    <div class="komment-page-reply"><a href="#komment-form">reply</a></div>

    <?php if($komments === null) : ?>
        <div class="komments-empty">THERE ARE NO COMMENTS</div>
    <?php else: ?>
    <ol class="komment-list">
        <?php foreach($komments as $komment): ?>
        <li class="single-komment">
            <?php snippet('komment/single', ['komment' => $komment]); ?>
        </li>
        <?php endforeach; ?>
    </ol>
    <?php endif; ?>
    <?php snippet('komments/form', ['page' => $page]); ?>
</div>