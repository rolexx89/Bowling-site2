<?php
	header("Content-type: text/html;charset=utf-8");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<META http-equiv="Content-Type" CONTENT="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>Bowling</title>
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
         <table style="width: 100%;"cellspacing="0">
              <tr valign="top" height="1">
                <td width="1">
                   <span>
                       <img src="/stylesheets/images/2.jpg" alt="bowling" width="120" height="120" />
                   </span>
                </td>
                <td>
                    <h1>Bowling</h1>
                </td>
               </tr>
          </table>
                  <div class="nav">
                        <a class="but-nav" href="<?php echo base_url(); ?>users/all">Users</a>
                        <a class="but-nav" href="<?php echo base_url(); ?>games/newgame">New-Game</a>
                        <a class="but-nav" href="<?php echo base_url(); ?>games/lists/">List-Games</a>
                        <a class="but-nav" href="<?php echo base_url(); ?>games/lists/quick-search">Search Games</a>
                  </div>
                </div>
                <div id="body">
