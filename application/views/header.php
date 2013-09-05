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
<style type="text/css">
	* {
		margin	: 0;
		padding	: 0;
	}
	#wall {
		background	: #222;
		min-height	: 100%;
		width		: 100%;
	}

	#wall #container {
		width	: 1000px;
		/*height	: 100%;*/
		margin	: 0 auto;
		padding	: 10px;
		background	: #fff;
		text-align	: left;
	}

	html,body,body center.wall {
		height	: 100%;
	}

	div#body {
		min-height	: 360px;
		padding	: 20px 10px;
	}

	table.list {
		min-width	: 540px;
		font-size	: 11px;
	}
	table.list td {
		margin	: 2px;
		border	: 1px solid #efefef;
		padding	: 5px 10px;
	}
	table.list tr.mark td {
		background	: #dedede;
	}
</style>
</head>
<body>
<center class="wall" >
<div id="wall">
   <div id="container">
      <div id="header">
         <table style="width: 100%;">
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
                  <div class="nav" align="center" >
                        <a class="but-nav" href="<?php echo base_url(); ?>users/all">Users</a>
                        <a class="but-nav" href="<?php echo base_url(); ?>pages/filed">New-Users</a>
                        <a class="but-nav" href="<?php echo base_url(); ?>games/newgame">New-Game</a>
                        <a class="but-nav" href="<?php echo base_url(); ?>games/lists/">List-Games</a>
                  </div>
                </div>
                <div id="body">
