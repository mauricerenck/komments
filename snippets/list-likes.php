<?php $commentList = $page->comments();?>
<?php if ($likes = $commentList->filterBy('type', 'like-of')) : ?>
    <ul class="list-likes">
        <?php foreach ($likes as $comment) : snippet('komments/response/like', ['comment' => $comment]);
        endforeach; ?>
    </ul>
<?php endif; ?>
