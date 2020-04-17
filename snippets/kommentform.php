<?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>
<span><?php echo t('komment_elsewhere'); ?></span><br>
<a href="https://twitter.com/intent/tweet?url=<?php echo $actual_link; ?>" class="button button-tiny button-outlined share" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
<a href="https://www.addtoany.com/add_to/mastodon?linkurl=<?php echo $actual_link; ?>" class="button button-tiny button-outlined share" target="_blank"><i class="fab fa-mastodon"></i> Mastodon</a>

<form action="/komments/send" method="post" id="kommentform">
    <input type="text" name="url" id="url" placeholder="Diese Feld nicht ausfüllen/ Do not fill">
    <input type="email" name="email" id="email" placeholder="E-Mail*" required>
    <input type="text" name="author" id="author" placeholder="Name*" required>
    <input type="url" name="author_url" id="author_url" placeholder="Website">
    <blockquote class="visible-quote hidden"><p></p></blockquote>
    <textarea name="komment" id="komment" cols="30" rows="5" placeholder="Kommentar*" required></textarea>
    <div class="spam-indicator">
        <div class="progress"></div>
    </div>
    <input type="hidden" name="wmSource" value="<?php echo $page->url(); ?>">
    <input type="hidden" name="wmTarget" value="<?php echo $page->url(); ?>">
    <input type="hidden" name="wmProperty" value="komment">
    <input type="hidden" name="quote" class="quote" value="">
    <input type="hidden" name="cts" value="" class="cts">
    <span class="komment-privacy"><?php echo t('kommentinfo'); ?></span>
    <input type="submit" value="<?php echo t('send'); ?>" class="button button-tiny button-primary">
</form>
<script src="/media/plugins/mauricerenck/komments/komments.js"></script>
