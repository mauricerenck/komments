<?php
    if (!$page->kommentsAreEnabled()): ?>
        <div class="moderation-note" id="disabled"><?php echo t('mauricerenck.komments.disabled'); ?></div>
        <?php return false; ?>
    <?php endif; ?>
<?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>
<div class="share-elsewhere">
    <span><?php echo t('mauricerenck.komments.externalReply'); ?></span><br>
    <a href="https://twitter.com/intent/tweet?url=<?php echo $actual_link; ?>" class="button button-tiny button-outlined share komment-share-twitter" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
    <a href="https://www.addtoany.com/add_to/mastodon?linkurl=<?php echo $actual_link; ?>" class="button button-tiny button-outlined share komment-share-mastodon" target="_blank"><i class="fab fa-mastodon"></i> Mastodon</a>
</div>
<form action="<?= $kirby->url('index') ?>/komments/send" method="post" id="kommentform">
    <div class="loading-invisible loader sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div>
    <div class="form-feedback"></div>

    <blockquote class="visible-quote hidden"><p></p></blockquote>
    <span class="replyHandleDisplay"></span>
    <textarea name="komment" id="komment" cols="30" rows="5" placeholder="Kommentar*" required></textarea>
    <input type="text" name="url" id="url" placeholder="Leave empty" tabindex="-1">
    <input type="email" name="email" id="email" placeholder="E-Mail*" required>
    <input type="text" name="author" id="author" placeholder="Name*" required>
    <input type="url" name="author_url" id="author_url" placeholder="Website">
    <div class="spam-indicator">
        <div class="progress"></div>
    </div>
    <input type="hidden" name="wmSource" value="<?php echo $page->url(); ?>">
    <input type="hidden" name="wmTarget" value="<?php echo $page->url(); ?>">
    <input type="hidden" name="wmProperty" value="komment">
    <input type="hidden" name="quote" class="quote" value="">
    <input type="hidden" name="replyTo" value="">
    <input type="hidden" name="replyHandle" value="">
    <input type="hidden" name="cts" value="" class="cts">
    <span class="komment-privacy"><?php echo t('mauricerenck.komments.form.privacy'); ?></span>
    <input type="submit" value="<?php echo t('mauricerenck.komments.form.submit'); ?>" class="button button-tiny button-primary">
</form>
<?php echo js(['/media/plugins/mauricerenck/komments/komments.js']); ?>