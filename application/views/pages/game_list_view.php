
<link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />
<hr />
    <span>
        <center> <h3> Lists Game-Play </h3></center>
    </span>
<hr />
<?php foreach ($games_list as $games_data) { ?>
    <div class="field-set">
        <div class="field-row">
            <a style="display: block;" href="<?= base_url() . "games/show/{$games_data['game_id']}"; ?>">
                <span class="field-name">
                    Game #:
                </span>
                <span class="field-value">
                    <?php echo htmlspecialchars($games_data['game_id']); ?>
                </span>
            </a>
        </div>
        
    </div>
<?php } ?>
</div>
<li class="ui-button ui-widget ui-state-default ui-corner-all" title="icon back">
    <a class="ui-icon ui-icon-circle-arrow-w" href="<?php echo base_url(); ?>"> back </a>
</li>
<hr />
   &nbsp;
<hr />
</div>
  