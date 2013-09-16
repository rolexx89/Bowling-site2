<?php header("Content-type: text/html;charset=utf-8"); ?>
<!DOCTYPE html>
<html>
    <head>
        <META http-equiv="Content-Type" CONTENT="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Bowling</title>
        <link rel="icon" href="/stylesheets/images/favicon.png" sizes="16x16 32x32" type="image/png">
        <link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />
        <link href="/scripts/jquery-ui-1.10.3.custom/css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
        <script src="/scripts/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
        <script src="/scripts/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.js"></script>
    </head>
    <body>

        <center class="wall" >
            <div id="wall">
                <div id="container">
                    <div id="header">
                        <div class="header">
                            Bowling
                        </div>
                        <nav>
                            <a class="ui-button ui-state-default ui-corner-all" href="<?php echo base_url(); ?>users/all">Users</a>
                            <a class="ui-button ui-state-default ui-corner-all" href="<?php echo base_url(); ?>games/newgame/select">New-Game</a>
                            <a class="ui-button ui-state-default ui-corner-all" href="<?php echo base_url(); ?>games/lists/">List-Games</a>
                            <a class="ui-button ui-state-default ui-corner-all" href="<?php echo base_url(); ?>games/lists/quick-search">Search Games</a>
                        </nav>
                    </div>
                    <div id="body">
