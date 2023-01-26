<?php $this->headergetir(); ?>
    <div id="solkisim">
        <div id="yazialani">
            <div class="yazi">
                <h1 class="sayfabaslik"><?php echo $baslik; ?></h1>
                <div class="yaziicerik">
                    <?php echo $this->icerik; ?>
                </div>
                <div class="temizle"></div>
            </div>
        </div>
    </div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>