<?php $commentList = $page->comments();?>
<?php if ($reposts = $commentList->filterBy('type', 'repost-of')) : ?>
    <ul class="list-reposts">
        <?php foreach ($reposts as $comment) : snippet('komments/response/repost', ['comment' => $comment]);
        endforeach; ?>
    </ul>
<?php endif; ?>
