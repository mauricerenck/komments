<?php $commentList = $page->comments();?>
<?php if ($replies = $commentList->filterBy('type', 'in-reply-to')) : ?>
    <ul class="list-replies">
        <?php foreach ($replies as $comment) :  snippet('komments/response/reply', ['comment' => $comment]);
        endforeach; ?>
    </ul>
<?php endif; ?>
