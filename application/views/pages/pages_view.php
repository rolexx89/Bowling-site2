
<link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />

<?php foreach ($all_users as $item) { ?>
    <div class="field-set">
        <div class="field-row">
            <span class="field-name">
                Id Utilizator:
            </span>
            <span class="field-value">
                <a href="<?= base_url() . "pages/show/$item[id]"; ?>"><?php echo htmlspecialchars($item['id']); ?></a>
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