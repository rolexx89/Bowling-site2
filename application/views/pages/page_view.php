<link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />

<form action="<?php echo base_url(); ?>/pages/show/<?php echo htmlspecialchars($main_info['id']); ?>" method="post">
    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($main_info['id']); ?>" > 
    <div class="field-set">
        <div class="field-row">
            <span class="field-name">
                Nume Utilizator:
            </span>
            <span class="field-value">
                <?= $main_info['name']; ?>
            </span>
        </div>
        <div class="field-row">
            <span class="field-name">
                Nick:
            </span>
            <span class="field-value">
                <?= $main_info['nick']; ?>
            </span>
        </div>
        <div class="field-row">
            <a href="<?php echo base_url(); ?>/pages/userremove/<?php echo htmlspecialchars($main_info['id']); ?>">Delete</a>
            <a href="<?php echo base_url(); ?>/pages/all">Cancel</a>
        </div>
    </div>
</form>