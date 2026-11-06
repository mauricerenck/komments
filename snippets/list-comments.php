<?php
$commentList = $page->comments();
?>
<?php if ($comments = $commentList->filterBy('type', 'comment')) : ?>
    <ul class="list-comments">
        <?php foreach ($comments->filterBy('parentId', 'maxlength', 0) as $comment) : snippet('komments/response/comment', ['comments' => $comments, 'comment' => $comment]);
        endforeach; ?>
    </ul>
<?php endif; ?>
