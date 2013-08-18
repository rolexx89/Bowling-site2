
<link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />

<?php foreach ($games_list as $games_data) { ?>
    <div class="field-set">
        <div class="field-row">
            <span class="field-name">
                Game #:
            </span>
            <span class="field-value">
                <a href="<?= base_url() . "games/show/{$games_data['game_id']}"; ?>">
                    <?php echo htmlspecialchars($games_data['game_id']); ?>
                </a>
            </span>
        </div>
    </div>
<?php } ?>
</div>
</div>
