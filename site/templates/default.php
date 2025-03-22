<html>

<head>
  <?php echo css(['/media/plugins/mauricerenck/komments/komments.css']); ?>
</head>

<body>
  <div style="max-width: 500px; margin: 0 auto;">

    <h1><?= $page->title() ?></h1>
    <h2>FIELDS</h2>
    <ul>
      <li>comments are enabled: <?php var_dump($page->commentsAreEnabled()) ?></li>
      <li>Comment Count: <?php echo $page->commentCount() ?></li>
      <li>Pending Comments: <?php echo $site->numberOfPendingComments() ?></li>
      <li>Spam Comments: <?php echo $site->numberOfSpamComments() ?></li>
    </ul>

    <h2>Form</h2>
    <?php snippet('komments/form'); ?>

    <h2>New</h2>
    <?php snippet('komments/list/likes'); ?>
    <?php snippet('komments/list/mentions'); ?>
    <?php snippet('komments/list/replies'); ?>
    <?php snippet('komments/list/reposts'); ?>
    <?php snippet('komments/list/comments'); ?>
  </div>
</body>

</html>