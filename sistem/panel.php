<?php if(!$_SESSION['yetki']){echo "Bu sayfaya erişim hakkınız yok!";exit;} ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HT Admin</title>
    <link rel="stylesheet" href="/sistem/jscss/panel.css">
    <script src="/sistem/jscss/jquery-3.1.0.min.js"></script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="/sistem/jscss/panel.js" type="text/javascript"></script>
</head>
<body class="body">

<div id="tamsayfa">
    <div class="solmenu">
        <ul>
            <li><a href="/htadmin/genelayarlar/">Genel Ayarlar</a></li>
            <li><a href="/htadmin/yazilar/">Yazılar</a></li>
            <li><a href="/htadmin/fotograflar/">Fotoğraflar</a></li>
            <li><a href="/htadmin/kategoriler/">Kategoriler</a></li>
            <li><a href="/htadmin/benkimim/">Ben Kimim?</a></li>
            <li><a href="/htadmin/yeteneklerim/">Yeteneklerim</a></li>
            <li><a href="/htadmin/izlediklerim/">İzlediklerim</a></li>
            <li><a href="/htadmin/dinlediklerim/">Dinlediklerim</a></li>
            <li><a href="/htadmin/cikisyap/">Çıkış Yap</a></li>
        </ul>
    </div>
    <div class="sagicerik">
        <?php echo $this->icerik; ?>
    </div>
</div>

</body>
</html>
<?php ?>