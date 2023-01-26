<?php $this->headergetir(); ?>
    <div class="col-xl-8 col-lg-12 col-md-12">
            <article class="yazilistesi mb-4 shadow">
                <h1 class="yazibaslik p-2"><?php echo $yazi_adi; ?></h1>
                <?php if($yazi_onecikarilmis != NULL){ ?>
                <div class="onecikarilmisgorsel p-2 my-1">
                    <img class="rounded img-fluid mx-auto d-block" src="<?php echo $yazi_onecikarilmis; ?>" alt="<?php echo $yazi_adi; ?>">
                </div>
                <?php } ?>
                <div class="yazibilgileri p-2">
                    <div class="nav">
                        <ul class="nav">
                            <li class="nav-item yazibilgi yaziyazar"><?php echo $yazar_adsoyad; ?></li>
                            <li class="nav-item yazibilgi yazikategori"><a href="<?php echo $kategori_tam_url; ?>"><?php echo $kategori_adi; ?></a></li>
                            <li class="nav-item yazibilgi yazitarih"><?php echo $yazi_tarih; ?></li>
                            <li class="nav-item yazibilgi yazisaat"><?php echo $yazi_tarih_saat; ?></li>
                        </ul>
                    </div>
                </div>
                <div class="yaziicerik p-2 my-1">
                    <?php echo $yazi_icerik; ?>
                </div>
                <div class="yorumlar p-2">
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
            </article>
    </div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>