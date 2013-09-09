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
<div class="pages">
    <?php echo $page_links; ?>
</div>

<hr />                   
<div id="header">
    <div class="nav">
        <a class="but-nav" href="<?php echo base_url(); ?>games/newgame">New-Game</a>
    </div>
</div>
<hr />
  