<?php
	header("Content-type: text/html;charset=utf-8");
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<META http-equiv="Content-Type" CONTENT="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>Bowling</title>
<LINK REL="shortcut icon" TYPE="image/x-icon" HREF="favicon.ico" >
<LINK REL="icon" TYPE="image/x-icon" HREF="favicon.ico" >
<link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
</head>
<body>
<div id="splash-layer" style="position:fixed;top:0;left:0;height:100%;width:100%;z-index: 100;background:#efefef;">
    <div style="position: absolute;top: 20%;left:0;height: 60%;width:100%;text-align: center;">
        <img src="/stylesheets/images/loading.jpg" style="height: 100%;width: auto;" />
    </div>
</div>
<script type="text/javascript">
    $('#splash-layer').fadeOut('slow');
</script>
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
                  </div>
                </div>
                <div id="body">
