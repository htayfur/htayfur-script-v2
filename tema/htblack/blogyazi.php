<?php $this->headergetir(); ?>
<div id="solkisim">
    <div id="yazialani">
        <div class="yazi">
            <h1 class="yazibaslik"><?php echo $yazi_adi; ?></h1>
            <div class="yazibilgi">
                <ul>
                    <li class="ybilgi ybilgiyazar"><?php echo $yazar_adsoyad; ?></li>
                    <li class="ybilgi ybilgikategori"><a href="<?php echo $kategori_tam_url; ?>"><?php echo $kategori_adi; ?></a></li>
                    <li class="ybilgi ybilgitarih"><?php echo $yazi_tarih; ?></li>
                    <li class="ybilgi ybilgisaat"><?php echo $yazi_tarih_saat; ?></li>
                </ul>
                <div class="temizle"></div>
            </div>
            <div class="onecikarilmis"><img src="<?php echo $yazi_onecikarilmis; ?>" alt="<?php echo $yazi_adi; ?>"></div>
            <div class="yaziicerik">
                <?php echo $yazi_icerik; ?>
            </div>
            <div class="temizle"></div>
            <div class="yorumlar">
                <div id="disqus_thread"></div>
                <script>
                    var disqus_config = function () {
                        this.page.url = '<?php echo $yazi_tam_url; ?>';
                        this.page.identifier = '<?php echo "blog/".$yaziurl; ?>';
                        this.page.title = '<?php echo addslashes($yazi_adi); ?>';
                    };

                    (function() {
                        var d = document, s = d.createElement('script');
                        s.src = '//hakantayfur.disqus.com/embed.js';
                        s.setAttribute('data-timestamp', +new Date());
                        (d.head || d.body).appendChild(s);
                    })();
                </script>
            </div>
        </div>
    </div>
</div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>