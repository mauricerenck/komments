<?php $commentList = $page->comments();?>
<?php if ($mentions = $commentList->filterBy('type', 'mention-of')) : ?>
    <div class="list-mentions">
        <?php foreach ($mentions as $comment) : snippet('komments/response/mention', ['comment' => $comment]);
        endforeach; ?>
    </div>
<?php endif; ?>