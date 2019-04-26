<form action="<?php echo $page->url(); ?>/komment/save" method="POST" id="komment-form">
    <div class="komment-reply-indicator">
        <span class="komment-gravatar"></span>
        <span class="komment-author"></span>
    </div>

    <input type="text" name="author" id="author" required>
    <input type="email" name="email" id="email" required>
    <textarea name="text" id="text" required></textarea>
    <input type="hidden" name="page_slug" value="<?php echo $page->id(); ?>">
    <input type="hidden" name="replyTo" id="replyTo" value="<?php echo (isset($reply)) ? $reply : ''; ?>">
    <input type="submit" value="Senden">
</form>
<script src="/media/plugins/mauricerenck/komments/komments.js"></script>