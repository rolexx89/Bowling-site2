
<link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />
<div class="field-set">
    <div class="field-row">
        <span class="field-name">
            Actions:
        </span>
        <span class="field-value">
            <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-contact">
            <a class="ui-icon ui-icon-contact" href="<?php echo base_url(); ?>pages/filed">Add new user</a> </li>
        </span>
    </div>
</div>
<?php foreach ($all_users as $item) { ?>
    <div class="field-set">
        <div class="field-row">
            <span class="field-name">
                Id Utilizator:
            </span>
            <span class="field-value">
                <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-unlocked">
                <a class="ui-icon ui-icon-unlocked" href="<?= base_url() . "pages/show/$item[id]"; ?>"><?php echo htmlspecialchars($item['id']); ?></a>
                </li>
            </span>
        </div>
        <div class="field-row">
            <span class="field-name">
                Nick:
            </span>
            <span class="field-value">
                <?php echo htmlspecialchars($item['nick']); ?>
            </span>
        </div>
        <div class="field-row">
            <span class="field-name">
                Name:
            </span>
            <span class="field-value">
                <?php echo htmlspecialchars($item['name']); ?>
            </span>
        </div>
        <div class="field-row">
            <span class="field-name">
                Surname:
            </span>
            <span class="field-value">
                <?php echo htmlspecialchars($item['surname']); ?>
            </span>
        </div>
    </div>
<?php } ?>






</div>
</div>