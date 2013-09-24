<?php
// start open buffer
ob_start();
// controlam ca datele jocului au fost primite in view
if (isset($currentGameData['game-status'])) {
    if ($currentGameData['game-status']['status'] == "completed") {
        ?>
        Game Status: completed
    <?php } else { ?>

        Game Status: <?php echo htmlspecialchars($currentGameData['game-status']['status']); ?>
        <br />
        Round: <?php echo htmlspecialchars($currentGameData['game-status']['round']); ?>
        <br />
    <?php
    }

    if ($currentGameData['game-data']) {
        ?>
        <input type="hidden" class="new-url-replace" value="/games/show/<?= $currentGameData['game']->getGameId(); ?>" />
        <div>   Name Games - <?php echo htmlspecialchars($currentGameData['gameInfo']['name']); ?> 
        </div>
        
        <a href="/games/exportdata/<?= $currentGameData['game']->getGameId(); ?>">export game in JSON</a>
        <a href="/games/exportdata/<?= $currentGameData['game']->getGameId(); ?>/xml">export game in XML</a>        
        <br />
        <div class="g">
            <?php
        }

        $userNext = false;
        if ($currentGameData['game-data-grouped']['users']) {
            ?>
            <div class="gamess">Game #<?= $currentGameData['game']->getGameId(); ?></div>

            <?php
            // coloanele roundurilor
            for ($i = 1; $i <= 10; $i++)
                echo "<div class='gamess'>{$i}</div>";
            ?>
            <div class="gamess">Total </div>
            <div class="gamess">Total Full </div>
        </div>
        <div class="g">
            <?php
            foreach ($currentGameData['game-data-grouped']['users'] as $user_id => $user) {
                ?>
                <div class="g">
                    <div class="gamess"><?= htmlspecialchars($user['user_data']['nick']); ?></div>
                    <?php
                    // afisam valorile pentru roundurile curente 1..10
                    for ($i = 1; $i <= 10; $i++) {
                        ?><div class="gamess"><?php
                        $k = 0;
                        // controlam daca userul are valori pentru roundul $i
                        if (isset($user['rounds'][$i])) {
                            // daca userul are valori pentru round-ul curent afisam valorile
                            // ... priveste functia actionSufix din controlerul games
                            $i_val = 0;
                            foreach ($user['rounds'][$i] as $r) {
                                $k += $r['value'];
                                $i_val += $r['value'];
                                if ($k == 10 && count($user['rounds'][$i]) > 1) {
                                    echo "&nbsp;x&nbsp;";
                                } else {
                                    if ($r['value'] > 0 && $r['value'] < 12)
                                        echo "&nbsp;" . $r['value'] . "&nbsp;";
                                    if ($r['value'] == 0)
                                        echo "&nbsp;-&nbsp;";
                                    if ($r['value'] == 12)
                                        echo "&nbsp;x&nbsp;";
                                }
                            }
                            $i_try = count($user['rounds'][$i]);
                            if ($userNext === false) {
                                if ($i == 10) {
                                    if ($i_try < 3 && $i_val < 24)
                                        $userNext = $user_id;
                                } else {
                                    if ($i_try < 2 && $i_val < 10)
                                        $userNext = $user_id;
                                }
                            }
                        } else {
                            if (
                                    $userNext === false &&
                                    $currentGameData['game-status']['round'] == $i &&
                                    ( $currentGameData['game-status']['allowed-new'] == false ||
                                    $currentGameData['countJoinedUsers'] == count($currentGameData['game-players'])
                                    )
                            )
                                $userNext = $user_id;
                            echo "&nbsp;";
                        }
                        ?></div><?php
                    }
                    ?>
                    <div class="gamess"><?= ($user['total']); ?></div>
                    <div class="gamess"><?= ( $currentGameData['game-status']['status'] == "completed" ? $user['total'] : "&nbsp;" ); ?></div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
    

    if ($currentGameData['game-status']['status'] != "completed") {
        ?>
        <form action="" charset="utf-8" method="post" style="border: 1px solid #c0c0c0; padding: 10px; margin: 10px;">
            <span> Select User</span>
            <?php
            if ($userNext === false)
                foreach ($currentGameData['all-users'] as $item_id => $item)
                    if (empty($currentGameData['game-data-grouped']['users'][$item_id]['rounds']) &&
                            in_array($item_id, $currentGameData['game-players'])
                    )
                        $userNext = $item_id;


            // afisam utilizatorii ce deja joaca
            foreach ($currentGameData['all-users'] as $item_id => $item)
                if (!empty($currentGameData['game-data-grouped']['users'][$item_id]['rounds']) ||
                        in_array($item_id, $currentGameData['game-players'])
                ) {
                    if ($userNext === false)
                        $userNext = $item_id;
                    ?>
                    <div style="padding-left: 30px;">   
                        <label class="ui-state-default" >
                            <input <?php echo ( $userNext == $item_id ? " checked=\"true\" match=\"this\" " : ""); ?> type="radio" name="game_data[player]" value="<?= $item_id; ?>">
                            <span>    
                                <?= htmlspecialchars($item['name']); ?>
                <?= htmlspecialchars($item['surname']); ?>
                                ( <?= htmlspecialchars($item['nick']); ?> )
                            </span>
                        </label>
                    </div>
                    <?php
                }
            ?></form><?php
    }
}
// geting buffer content info var $content_data
// Json Example
// header("Content-type: text/javascript; charset=utf-8",true);
// echo json_encode(array( 'html-output' => ob_get_clean() ));


$content_data = ob_get_clean();

header("Content-type: text/xml; charset=utf-8", true /* for overwrite same previous headers */);
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
?><!-- Bowling data for Ajax Request -->
<bowling-data>
    <html-output><?php echo htmlspecialchars($content_data); ?></html-output>
</bowling-data>
