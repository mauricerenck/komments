<?php
$commentList = $page->comments();

function addReply($comment, $comments)
{
    snippet('komments/response/comment', ['comment' => $comment]);

    $replies = $comments->filterBy('parentId', '==', $comment->id());

    if ($replies->count() > 0) {
        echo '<ul>';
        foreach ($replies as $reply) {
            addReply($reply, $comments);
        }
        echo '</ul>';
    }
}
?>
<?php if ($comments = $commentList->filterBy('type', 'comment')) : ?>
    <ul class="list-comments">
        <?php foreach ($comments->filterBy('parentId', 'maxlength', 0) as $comment) : addReply($comment, $comments);
        endforeach; ?>
    </ul>
<?php endif; ?>
