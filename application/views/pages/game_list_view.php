<span>
    Lists Game-Play 
</span>
<?php foreach ($games_list as $games_data) { ?>
    <div class="content-left">
        <a style="display: block;" class="ui-button ui-state-default ui-corner-all" href="<?= base_url() . "games/show/{$games_data['game_id']}"; ?>">
            <span class="field-name">
                Game #:
            </span>
            <span class="field-value">
                <?php echo htmlspecialchars($games_data['game_id']); ?>
            </span>
            <span>
                <?php echo htmlspecialchars($games_data['name']); ?>
            </span>
        </a>
    </div>
<?php } ?>
<div class="pages">
    <?php echo $page_links; ?>
</div>                  

<div >
    <a class="ui-button ui-state-default ui-corner-all" href="<?php echo base_url(); ?>games/newgame">New-Game</a>
</div>
<iframe name="uploadgameData" id="uploadgameData" lang="0" onload="if(this.lang == '1') alert('Data uploaded!'); this.lang = '0';"></iframe>
<form action="/games/importData" name="importGameData" target="uploadgameData" method="post" charset="utf-8" enctype="multipart/form-data">
<input type="file" name="importContent" value=".." onchange="$('#uploadgameData').attr('lang','1');document.forms['importGameData'].submit()" placeholder="import game data" >
</form>