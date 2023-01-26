<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $this->title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $this->description; ?>">
    <meta name="keywords" content="<?php echo $this->keywords; ?>">
    <link rel="stylesheet" href="<?php echo $this->temaurl; ?>css/stil.css">
    <script type="text/javascript" src="<?php echo $this->temaurl; ?>js/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->temaurl; ?>js/script.js"></script>
</head>
<body>

<div id="header">
    <div class="ortaladiv">
        <div class="logo"><a href="<?php echo $this->sitelink; ?>" title="Hakan Tayfur Logo"><img src="<?php echo $this->temaurl; ?>logo.png" alt="Hakan Tayfur Logo"></a></div>
        <div class="menuler">
            <div class="menu menumenu">Menüyü Aç</div>
            <ul>
                <li class="menu menuanasayfa"><a href="<?php echo $this->sitelink; ?>/">Anasayfa</a></li>
                <li class="menu menubenkimim"><a href="<?php echo $this->sitelink; ?>/benkimim/">Ben Kimim?</a></li>
                <li class="menu menuyeteneklerim"><a href="<?php echo $this->sitelink; ?>/yeteneklerim/">Yeteneklerim</a></li>
                <li class="menu menuizlediklerim"><a href="<?php echo $this->sitelink; ?>/izlediklerim/">İzlediklerim</a></li>
                <li class="menu menudinlediklerim"><a href="<?php echo $this->sitelink; ?>/dinlediklerim/">Dinlediklerim</a></li>
                <li class="menu menuiletisim"><a href="<?php echo $this->sitelink; ?>/iletisim/">İletişim</a></li>
            </ul>
        </div>
        <div class="altboslukiki"></div>
        <div class="temizle"></div>
    </div>
</div>
<div class="temizle"></div>
<div id="ortaalan">
    <div class="ortaladiv">