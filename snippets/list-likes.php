<?php $commentList = $page->comments();?>
<?php if ($likes = $commentList->filterBy('type', 'like-of')) : ?>
    <div class="list-likes">
        <?php foreach ($likes as $comment) : snippet('komments/response/like', ['comment' => $comment]);
        endforeach; ?>
    </div>
<?php endif; ?>
