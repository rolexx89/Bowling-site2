<link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />
<div id="wrapper">
    <div id="content">


        <form action="<?php echo base_url(); ?>pages/filed" method="post">
            <div class="field-set">
                <div class="field-row">
                    <span class="field-name">
                        Numele vostru
                    </span>
                    <span class="field-value">
                        <input type ="text" name="name" value="<?= set_value('name'); ?>"><br>
                        <strong><?= form_error('name'); ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <span class="field-name">
                        prenumele
                    </span>
                    <span class="field-value">
                        <input type="text" name="surname" value="<?= set_value('surname'); ?>"><br>
                        <strong> <?= form_error('surname'); ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <span class="field-name">
                        Nickname
                    </span>
                    <span class="field-value">
                        <input type="text" name="nick" value="<?= set_value('nick'); ?>"><br>
                        <strong> <?= form_error('nick'); ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <span class="field-name">
                        <?= $imgcode ?>
                    </span>
                    <span class="field-value">
                        <input type="text" name="captcha" placeholder="introdu textul din imagine"><br>
                        <strong><?= form_error('captcha'), $info; ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <input type="submit" name="send_message" value="inregistrare">
                    <a href="<?php echo base_url(); ?>pages/show/all">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>