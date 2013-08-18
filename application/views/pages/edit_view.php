
<link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />
<div id="wrapper">
    <div id="content">
        <form action="<?php echo base_url(); ?>/pages/edit/<?php echo htmlspecialchars($main_info['id']); ?>/" method="post" charset="utf-8">
            <div class="field-set">
                <div class="field-row">
                    <span class="field-name">
                        User Id:
                    </span>
                    <span class="field-value">
                        <?php echo htmlspecialchars($main_info['id']); ?>
                    </span>
                </div>
                <div class="field-row">
                    <span class="field-name">
                        Name:
                    </span>
                    <span class="field-value">
                        <input type="text" name="name" value="<?= htmlspecialchars(set_value('name', $main_info['name'])); ?>">
                        <strong><?= form_error('name'); ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <span class="field-name">
                        Surname:
                    </span>
                    <span class="field-value">
                        <input type="text" name="surname" value="<?= htmlspecialchars(set_value('surname', $main_info['surname'])); ?>">
                        <strong> <?= form_error('surname'); ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <span class="field-name">
                        Nickname:
                    </span>
                    <span class="field-value">
                        <input type="text" name="nick" value="<?= htmlspecialchars(set_value('nick', $main_info['nick'])); ?>">
                        <strong> <?= form_error('nick'); ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <input type="submit" name="edit" value="editare">
                    <a href="<?php echo base_url(); ?>pages/show/<?php echo htmlspecialchars($main_info['id']); ?>">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>