<?php $commentList = $page->comments();?>
<?php if ($mentions = $commentList->filterBy('type', 'mention-of')) : ?>
    <ul class="list-mentions">
        <?php foreach ($mentions as $comment) : snippet('komments/response/mention', ['comment' => $comment]);
        endforeach; ?>
    </ul>
<?php endif; ?>
