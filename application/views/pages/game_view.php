<link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />

<style type="text/css">
    * {
        margin  : 0;
        padding : 0;
    }
    #wall {
        background  : #222;
        min-height  : 100%;
        width       : 100%;
    }

    #wall #container {
        width   : 1000px;
        /*height    : 100%;*/
        margin  : 0 auto;
        padding : 10px;
        background  : #fff;
        text-align  : left;
    }

    html,body,body center.wall {
        height  : 100%;
    }

    div#body {
        min-height  : 360px;
        padding : 20px 10px;
    }

    table.list {
        min-width   : 540px;
        font-size   : 11px;
    }
    table.list td {
        margin  : 2px;
        border  : 1px solid #efefef;
        padding : 5px 10px;
    }
    table.list tr.mark td {
        background  : #dedede;
    }
</style>

<?php if(isset($currentGameData['game-status'])) {  // controlam ca datele jocului au fost primite in view

        if($currentGameData['game-status']['status'] == "completed" ) { ?>
            Game Status: completed
        <?php } else { ?>
            Game Status: <?php echo htmlspecialchars($currentGameData['game-status']['status']); ?>
            <br />
            Round: <?php echo htmlspecialchars($currentGameData['game-status']['round']); ?>
        <?php }

    if($currentGameData['game-data']) {
        ?>
        <hr />
        <hr />
        <h3>Game Table</h3>
        <?php
        if(!empty($currentGameData['game-data'])) {
            ?>
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
                                foreach ( $user['rounds'][$i] as $r ) {
                                    $k  += $r['value'];
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
                            } else {
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
            <?php
        }

    }
    if($currentGameData['game-status']['status'] != "completed" ) {
        ?>
        <hr />
        <hr />
        <h3>Push Data</h3>
        <form action="" charset="utf-8" method="post" style="border: 1px solid #c0c0c0; padding: 10px; margin: 10px;">
            <h4>Enter Throw score</h4>
            <input type="text" name="game_data[value]" value="">
            <hr />
            <h4>Select User</h4>
        <?php
            // afisam utilizatorii ce deja joaca
            foreach ( $currentGameData['game-data-grouped']['users'] as $item_id => $item ) {
                ?>
                <div>
                    <input type="radio" name="game_data[player]" value="<?=$item_id;?>">
                    <?=htmlspecialchars($item['user_data']['name']); ?>
                    <?=htmlspecialchars($item['user_data']['surname']); ?>
                    ( <?=htmlspecialchars($item['user_data']['nick']); ?> )
                </div>
            <?php }
             // afisam utilizatorii ce pot intra in joc
            if($currentGameData['game-status']['allowed-new'] == true) {
                ?><div style="padding-left: 30px;padding-top: 10px;">
                    <sub>While the first round is not finished in game can enter other players</sub>
                    <?php foreach ( $currentGameData['all-users'] as $item_id => $item )
                        if(!isset($currentGameData['game-data-grouped']['users'][$item_id])) { ?>
                        <div>
                            <input type="radio" name="game_data[player]" value="<?=$item_id;?>">
                            <?=htmlspecialchars($item['name']); ?>
                            <?=htmlspecialchars($item['surname']); ?>
                            ( <?=htmlspecialchars($item['nick']); ?> )
                        </div>
                    <?php }
                ?></div>
                <?php
            }
        ?>
            <hr />
            <input type="submit">
        </form>
        <?php
    }

    } ?>
