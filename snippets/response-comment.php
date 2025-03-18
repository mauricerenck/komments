<?php snippet('komments/response/base', ['comments' => $comments, 'comment' => $comment], slots: true); ?>
    <?php $replies = $comments->filterBy('parentId', '==', $comment->id()); ?>
    <?php if ($replies->count() > 0): ?>
    <?php slot('replies'); ?>
        <ul>
            <?php foreach ($replies as $reply): ?>
            <?php snippet('komments/response/comment', ['comments' => $comments, 'comment' => $reply]); ?>
            <?php endforeach; ?>
        </ul>
    <?php endslot(); ?>
    <?php endif; ?>
<?php endsnippet(); ?>
