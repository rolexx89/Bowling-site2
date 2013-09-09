<script type="text/javascript">
    function updateAjaxSpace(data) {
        $.post('/games/show/<?php echo $currentGameData['game']->getGameId(); ?>/1',
                    data ? data : {},
                    function(dataResponse){
                        
                        // json example
                        // $('div#ajax-space').get(0).innerHTML = dataResponse["html-output"];
                        
                        // xml example
                        var text = $('bowling-data > html-output',dataResponse).text();
                        $('div#ajax-space',document).html(text);
                        $('input#i0').val('');
                        $('input#i0').focus();
               },'xml');
    }
</script>
<div id="ajax-space">
<?php if(isset($currentGameData['game-status'])) {  // controlam ca datele jocului au fost primite in view

    if( $currentGameData['game-status']['status'] != "completed" ) { ?>
        <form action="" charset="utf-8" method="post" style="border: 1px solid #c0c0c0; padding: 10px; margin: 10px;">
        <?php                   
            // afiseaza lista tuturor user pentru a ii selecta 
            if( $currentGameData['game-status']['allowed-new'] == true
                && empty($currentGameData['game-players'])
                && empty($currentGameData['game-data']) ) {
                ?><div style="padding-left: 30px;padding-top: 10px;">
                    <center>
                    <h4>Select User</h4>
                    <sub>While the first round is not finished in game can enter other players</sub>
                    </center>
                    <?php foreach ( $currentGameData['all-users'] as $item_id => $item )
                        if(!isset($currentGameData['game-data-grouped']['users'][$item_id])) { ?>
                            <label class="ui-state-default" >
                                <input type="checkbox" name="game_data[player][]" value="<?=$item_id;?>">
                                <span>
                                <?=htmlspecialchars($item['name']); ?>
                                    <?=htmlspecialchars($item['surname']); ?>
                                    ( <?=htmlspecialchars($item['nick']); ?> )
                                </span>
                            </label>
                    <?php }
                ?></div>
            <div id="header">
                    <div class="nav">
                        <hr />
                <input class="ui-button ui-state-default ui-corner-all" type="submit">
                    </div>
            </div>
                <?php
            } else if( empty($currentGameData['game-data']) ) {
                // afisam lista useri care joaca
                //la control daca putem arunca sau e complet cu ajax
                ?>
            <hr />
            <h4>Select User</h4>
            <hr />    
                <?php
                $only_first  = true;
                foreach ( $currentGameData['all-users'] as $item_id => $item )
                    if( in_array($item_id,$currentGameData['game-players']) ) { ?>
                    <div style="padding-left: 30px;">   
                      <label class="ui-state-default" >
                          <input <?php if($only_first) { $only_first = false; echo " checked=\"true\" match=\"this\" "; } ?> type="radio" name="game_data[player]" value="<?=$item_id;?>">
                           <span>    
                              <?=htmlspecialchars($item['name']); ?>
                              <?=htmlspecialchars($item['surname']); ?>
                              ( <?=htmlspecialchars($item['nick']); ?> )
                           </span>
                      </label>
                    </div>
                
            <?php } ?>
            <hr />
                <input id="i0" type="text" name="game_data[value]" value="" autocomplete="off" >
            <hr />
                <input class="ui-button ui-state-default ui-corner-all" text-align="center" type="submit">
            <hr />
            <?php } else { ?>
        <script type="text/javascript">
            updateAjaxSpace();
        </script>
        <?php } ?>
  </form>
    <?php } ?>
  </div>
  <?php
    if( $currentGameData['game-status']['status'] != "completed"
        && !empty($currentGameData['game-data']) ) { ?>
        <h3>Push Data</h3>
        <h3>Enter Throw score</h3>
        <input id="i0" type="text" name="game_data[value]" value="" autocomplete="off" />
        <hr />
        <input class="ui-button ui-state-default ui-corner-all" type="submit" value="Arunca" onclick="
                    updateAjaxSpace({
                        // input#i0 = introdu val , match= round , $#x22 = '' '' 
                        'game_data[value]' : $('input#i0').val(),
                        'game_data[player]': $('input[name=&#x22;game_data[player]&#x22;][match]').val()
                    });" />
        <hr />
        <div id="header">
        <div class="nav">
            <a class="but-nav" href="<?php echo base_url(); ?>games/newgame">New-Game</a>
        </div>
        </div>
        
  <?php }

} else { ?>
</div>
        
<?php } ?>