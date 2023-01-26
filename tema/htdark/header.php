<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $this->title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $this->description; ?>">
    <meta name="keywords" content="<?php echo $this->keywords; ?>">
    <link rel="stylesheet" href="<?php echo $this->temaurl; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $this->temaurl; ?>css/stil.css">
    <script src="<?php echo $this->temaurl; ?>js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo $this->temaurl; ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $this->temaurl; ?>js/script.js"></script>
</head>
<body>
<div class="ustmenu">
    <nav class="navbar navbar-expand uapadding-3">
        <div class="container">
            <button class="navbar-toggler ml-auto ozeltoggler" type="button" data-toggle="collapse" data-target="#ustmenuResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="ustmenuResponsive">
                <ul class="nav navbar-nav">
                    <li class="nav-item menu menuicon sosyaltwitter"><a class="nav-link" href="https://twitter.com/hkntyfr">Twitter</a></li>
                    <li class="nav-item menu menuicon sosyalyoutube"><a class="nav-link" href="https://www.youtube.com/c/HTayfur">YouTube</a></li>
                    <li class="nav-item menu menuicon sosyallinkedin"><a class="nav-link" href="http://tr.linkedin.com/in/hakantayfur">Linkedin</a></li>
                    <li class="nav-item menu menuicon sosyalgoogle"><a class="nav-link" href="https://plus.google.com/+HakanTayfur/posts">Google+</a></li>
                    <li class="nav-item menu menuicon sosyalinstagram"><a class="nav-link" href="https://instagram.com/hkntyfr/">Instagram</a></li>
                    <li class="nav-item menu menuicon sosyalfacebook"><a class="nav-link" href="https://www.facebook.com/hkntyfr">Facebook</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="logo">
    <div class="container">
        <div class="row align-items-center justify-content-start">
            <div class="col mt-3 mb-3">
                <a href="/" title="Hakan Tayfur Anasayfa"><img src="<?php echo $this->temaurl; ?>images/logo.png" alt="Logo"></a>
                <span class="siteadi"><a href="/" title="Hakan Tayfur Anasayfa">Hakan Tayfur</a></span>
            </div>
        </div>
    </div>
</div>
<div class="altmenu">
    <nav class="navbar navbar-expand-md uapadding-3">
        <div class="container">
            <button class="navbar-toggler ml-auto ozeltoggler" type="button" data-toggle="collapse" data-target="#altmenuResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="altmenuResponsive">
                <ul class="nav navbar-nav">
                    <li class="nav-item menu menuicon menuanasayfa"><a class="nav-link" href="<?php echo $this->sitelink; ?>/">Anasayfa</a></li>
                    <li class="nav-item menu menuicon menubenkimim"><a class="nav-link" href="<?php echo $this->sitelink; ?>/benkimim/">Ben Kimim?</a></li>
                    <li class="nav-item menu menuicon menuyeteneklerim"><a class="nav-link" href="<?php echo $this->sitelink; ?>/yeteneklerim/">Yeteneklerim</a></li>
                    <li class="nav-item menu menuicon menuizlediklerim"><a class="nav-link" href="<?php echo $this->sitelink; ?>/izlediklerim/">İzlediklerim</a></li>
                    <li class="nav-item menu menuicon menudinlediklerim"><a class="nav-link" href="<?php echo $this->sitelink; ?>/dinlediklerim/">Dinlediklerim</a></li>
                    <li class="nav-item menu menuicon menuiletisim"><a class="nav-link" href="<?php echo $this->sitelink; ?>/iletisim/">İletişim</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="icerik mt-3 mb-3">
    <div class="container">
        <div class="row">