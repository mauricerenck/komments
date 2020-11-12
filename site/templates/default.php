<html>
    <head>
        <?php echo css(['/media/plugins/mauricerenck/komments/komments.css']); ?>
        </head>
        </html>
        <body>
<h1><?= $page->title() ?></h1>

<?php snippet('komments/kommentform'); ?>
<hr>
<?php snippet('komments/webmention'); ?>
<hr>
<?php snippet('komments/webmention-splitted'); ?>

<?php if ($page->kommentsAreEnabled()): ?>komments are enabled<?php endif; ?>
</body>
</html>