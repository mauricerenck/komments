<?php
    $formName = '';
    $formEmail = '';
    $pageLanguage = $kirby->language()->code() ?? 'en';
    $user = $kirby->user();

    if (!is_null($user) && $user->isLoggedIn()) {
        $formName = $user->name();
        $formEmail = $user->email();
    }
?>
<form action="<?= $kirby->url('index') ?>/komments/send" method="post" id="kommentform">

    <div class="form-feedback">
        <div class="msg user-feedback"></div>
        <div class="msg loader">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3C16.9706 3 21 7.02944 21 12H19C19 8.13401 15.866 5 12 5V3Z"></path></svg>
            <span><?php echo t('mauricerenck.komments.sending'); ?></span>
        </div>
    </div>

    <span class="replyHandleDisplay">@test</span>

    <label for="comment" class="comment">
        <?php echo t('mauricerenck.komments.form.label.comment'); ?>
        <textarea name="comment" id="comment" cols="30" rows="5" placeholder="<?php echo t('mauricerenck.komments.form.label.comment'); ?>*" required></textarea>
    </label>

    <label for="email">
        <?php echo t('mauricerenck.komments.form.label.email'); ?>
        <input type="email" name="email" id="email" placeholder="<?php echo t('mauricerenck.komments.form.label.email'); ?>*" required value="<?php echo $formEmail; ?>">
    </label>

    <label for="author">
        <?php echo t('mauricerenck.komments.form.label.name'); ?>
        <input type="text" name="author" id="author" placeholder="<?php echo t('mauricerenck.komments.form.label.name'); ?>*" required value="<?php echo $formName; ?>">
    </label>

    <label for="author_url">
        <?php echo t('mauricerenck.komments.form.label.website'); ?>
        <input type="url" name="author_url" id="author_url" placeholder="<?php echo t('mauricerenck.komments.form.label.website'); ?>">
    </label>

    <input type="text" name="url" id="url" placeholder="Leave empty" tabindex="-1">
    <input type="hidden" name="replyTo" value="">
    <input type="hidden" name="replyHandle" value="">
    <input type="hidden" name="language" value="<?php echo $pageLanguage; ?>">
    <input type="hidden" name="pageUuid" value="<?php echo $page->uuid() ?>">

    <span class="komment-privacy"><?php echo t('mauricerenck.komments.form.privacy'); ?></span>
    <input type="submit" value="<?php echo t('mauricerenck.komments.form.submit'); ?>" class="<?php echo option('mauricerenck.komments.form.submit.classNames', 'button button-tiny button-primary'); ?>">
</form>
<?php echo js(['/media/plugins/mauricerenck/komments/komments.js']); ?>
