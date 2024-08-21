<html>
    <head>
       <?php echo css(['/media/plugins/mauricerenck/komments/komments.css']); ?>
    </head>
    <body>
        <div style="max-width: 500px; margin: 0 auto;">

            <pre>
                <?php
                    $migration = new mauricerenck\Komments\Migrations();
                    $migration->convertCommentsFromMarkdownToSqlite();
                ?>
                </pre>
            <pre>
                <?php dump($page->mastodonStatusUrl()) ?>
            </pre>
            <h2>FIELDS</h2>
            <ul>
                <li>kommentsAreEnabled: <?php var_dump($page->kommentsAreEnabled()) ?></li>
                <li>KommentCount: <?php echo $page->kommentCount() ?></li>
                <li>Pending Comments: <?php echo $site->numberOfPendingComments() ?></li>
                <li>Spam Comments: <?php echo $site->numberOfSpamComments() ?></li>
            </ul>

            <h2>Form</h2>
            <?php snippet('komments/form'); ?>

            <h2>New</h2>
            <?php snippet('komments/list/likes');?>
            <?php snippet('komments/list/mentions');?>
            <?php snippet('komments/list/replies');?>
            <?php snippet('komments/list/reposts');?>
            <?php snippet('komments/list/comments');?>

        </div>
    </body>
</html>
