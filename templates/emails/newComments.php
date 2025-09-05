Hi,

There are <?= $pendingComments; ?> new comments in moderation<?php if ($spamComments > 0) : ?> (<?= $spamComments; ?> of them may be spam)<?php endif; ?>.
To moderate them, have a look here: <?= $panelUrl; ?>


The following comments are waiting for moderation:

<?= $mailSummary; ?>

<?php if ($spamComments > 0) : ?>
The following comments might be spam:

<?= $spamSummary; ?>
<?php endif; ?>

Yours sincerely
The friendly Komments Bot