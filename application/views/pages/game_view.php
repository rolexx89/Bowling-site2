<?php if(empty($currentGameData['ajax-request'])) { ?>
    <link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<div id="ajax-space">
<?php } ?>
<?php if(isset($currentGameData['game-status'])) {  // controlam ca datele jocului au fost primite in view

        if($currentGameData['game-status']['status'] == "completed" ) { ?>
            Game Status: completed
        <?php } else { ?>
            Game Status: <?php echo htmlspecialchars($currentGameData['game-status']['status']); ?>
            <br />
            Round: <?php echo htmlspecialchars($currentGameData['game-status']['round']); ?>
        <?php }
       
        
    $userNext   = false;
    if($currentGameData['game-data']) {
        ?>
        <hr />
        <hr />
        <h3>Game Table</h3>
        <?php
        if(!empty($currentGameData['game-data'])) {
            ?>
        <center>
            <table class="list">
                <tr class="mark">
                    <td>Game #<?=$currentGameData['game']->getGameId(); ?></td>
                    <?php
                    // coloanele roundurilor
                    for($i=1;$i<=10;$i++) echo "<td>{$i}</td>";
                    ?>
                    <td>Total</td>
                    <td>Total Full</td>
                </tr>
            <?php
            foreach ($currentGameData['game-data-grouped']['users'] as $user_id => $user ) {
                ?>
                <tr>
                    <td><?=htmlspecialchars($user['user_data']['nick']);?></td>
                    <?php
                        // afisam valorile pentru roundurile curente 1..10
                        for ($i=1;$i<=10;$i++) {
                            ?><td><?php
                            $k  = 0;
                            // controlam daca userul are valori pentru roundul $i
                            if(isset($user['rounds'][$i])) {
                                // daca userul are valori pentru round-ul curent afisam valorile
                                // ... priveste functia actionSufix din controlerul games
                                $i_val  = 0;
                                foreach ( $user['rounds'][$i] as $r ) {
                                    $k  += $r['value'];
                                    $i_val  += $r['value'];
                                    if( $k == 10 && count($user['rounds'][$i]) > 1 ) {
                                        echo "&nbsp;x&nbsp;";
                                    } else {
                                        if( $r['value'] > 0 && $r['value'] < 12)
                                        echo "&nbsp;".$r['value']."&nbsp;";
                                        if($r['value'] == 0)
                                        echo "&nbsp;-&nbsp;";
                                        if($r['value'] == 12)
                                        echo "&nbsp;x&nbsp;";
                                    }
                                }
                                    $i_try = count($user['rounds'][$i]);
//                                    echo "[ $i_try | $i_val | $i | $userNext - $user_id ]";
                                    if( $userNext === false )  {
                                        if( $i == 10 ) {
                                            if( $i_try < 3 && $i_val < 24 )
                                                $userNext   = $user_id;
                                        } else {
                                            if(  $i_try < 2 && $i_val < 10 )
                                                $userNext   = $user_id;
                                        }
                                    }
//                                    echo "[$userNext]";
                                
                            } else {
                                if( 
                                    $userNext === false
                                        &&
                                    $currentGameData['game-status']['round'] == $i
                                        &&
                                    ( $currentGameData['game-status']['allowed-new'] == false
                                        ||
                                      count($currentGameData['game-data-grouped']['users']) == count($currentGameData['game-players'])
                                    )
                                  )
                                    $userNext   = $user_id;
                              echo "&nbsp;";
                            }
                            ?></td><?php
                        }
                    ?>
                    <td><?=($user['total']);?></td>
                    <td><?=( $currentGameData['game-status']['status'] == "completed" ? $user['total'] : "&nbsp;" );?></td>
                </tr>
                <?php
            }
            ?>
            </table>
            </center>
            <?php
        }

    }

    if($currentGameData['game-status']['status'] != "completed") {
        
         ?>
        <hr />
        <hr />
        <form action="" charset="utf-8" method="post" style="border: 1px solid #c0c0c0; padding: 10px; margin: 10px;">
            <h4>Select User</h4>
        <?php
           
            if( $userNext === false )
            foreach ( $currentGameData['all-users'] as $item_id => $item ) {
//                echo "{$item_id}:".((int)isset($currentGameData['game-data-grouped']['users'][$item_id]))." ";
                if( 
                    !isset($currentGameData['game-data-grouped']['users'][$item_id]) 
                     &&
                    in_array($item_id,$currentGameData['game-players'])
                     ) {
                        $userNext = $item_id;
                    }
            }
                   
            // afisam utilizatorii ce deja joaca
            foreach ( $currentGameData['all-users'] as $item_id => $item )
                if( isset($currentGameData['game-data-grouped']['users'][$item_id]) 
                     ||
                    in_array($item_id,$currentGameData['game-players'])
                ) {
                    if( $userNext === false )
                        $userNext = $item_id;
                ?>
                  <div style="padding-left: 30px;">   
                <label class="ui-state-default" >
                    <input <?php echo ( $userNext == $item_id ? " checked=\"true\" match=\"this\" " : ""); ?> type="radio" name="game_data[player]" value="<?=$item_id;?>">
                     <span>    
                        <?=htmlspecialchars($item['name']); ?>
                        <?=htmlspecialchars($item['surname']); ?>
                        ( <?=htmlspecialchars($item['nick']); ?> )
                     </samp>
                </label>
                  </div>
                <?php }
             // afisam utilizatorii ce pot intra in joc pentru selecare
            if($currentGameData['game-status']['allowed-new'] == true && empty($currentGameData['game-players']) ) {
                ?><div style="padding-left: 30px;padding-top: 10px;">
                    <sub>While the first round is not finished in game can enter other players</sub>
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
                <input type="submit">
                <?php
            } else if( empty($currentGameData['game-data']) ) { ?>
            <input id="i0" type="text" name="game_data[value]" value="" autocomplete="off" >
            <input type="submit">   
        <?php }
        ?>
  </form>
    <?php } ?>
  </div>
  <?php
    if( $currentGameData['game-status']['status'] != "completed"
        && empty($currentGameData['ajax-request'])
        && !empty($currentGameData['game-data']) ) {
        if(!( $currentGameData['game-status']['allowed-new'] == true && empty($currentGameData['game-players']) ) ) { ?>
        <h3>Push Data</h3>
        <h4>Enter Throw score</h4>
        <input id="i0" type="text" name="game_data[value]" value="" autocomplete="off" />
        <hr />
        <?php } ?>
        <input class="ui-button ui-state-default ui-corner-all" type="submit" value="Arunca" onclick="
               $.post('/games/show/<?php echo $currentGameData['game']->getGameId(); ?>/1',
                    {   'game_data[value]' : $('input#i0').val(),
                        'game_data[player]': $('input[name=&#x22;game_data[player]&#x22;][match]').val()
                    },
                    function(text){
                        $('div#ajax-space').html(text);
                        $('input#i0').val('');
                        $('input#i0').focus();
               },'text');
               " />
        <hr />
        <li class="ui-button ui-widget ui-state-default ui-corner-all" title="icon back">
           <a class="ui-icon ui-icon-circle-arrow-w" href="<?php echo base_url(); ?>"> back </a>
        </li>
        <li class="ui-button ui-widget ui-state-default ui-corner-all" title="icon script">
            <a class="ui-icon ui-icon-script" href="<?php echo base_url(); ?>games/lists/<?php echo htmlspecialchars($item['id']); ?>"> lista </a>
        </li>
  <?php }

} else { ?>
</div>
<?php } ?>
