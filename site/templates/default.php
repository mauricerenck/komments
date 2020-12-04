<html>
    <head>
       <?php echo css(['/media/plugins/mauricerenck/komments/komments.css']); ?>
    </head>
    <body>
        <div style="max-width: 500px; margin: 0 auto;">

            <h2>FIELDS</h2>
            <ul>
                <li>kommentsAreEnabled: <?php var_dump($page->kommentsAreEnabled()) ?></li>
                <li>hasQueuedKomments: <?php var_dump($page->hasQueuedKomments('1', '2')) ?></li>
                <li>KommentCount: <?php echo $page->kommentCount() ?></li>
            </ul>

            <h2>Form</h2>
            <?php snippet('komments/kommentform'); ?>

            <h2>Chatansicht</h2>
            <?php snippet('komments/webmention'); ?>

            <h2>Splitted</h2>
            <?php snippet('komments/webmention-splitted'); ?>
        </div>
    </body>
</html>