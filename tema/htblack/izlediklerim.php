<?php $this->headergetir(); ?>
    <div id="solkisim">
        <div class="izlediklerimkismi">
            <h1 class="sayfabaslik">İzlediklerim</h1>
            <?php foreach($this->icerik as $izledigim){ ?>
            <div class="izlediklerim">
                <div class="izlediklerimafis">
                    <img src="<?php echo $this->sitelink.$izledigim['filmafis']; ?>" alt="<?php echo $izledigim['filmadi']; ?>">
                </div>
                <div class="izlediklerimfilm">
                    <?php echo $izledigim['filmadi']; ?>
                </div>
                <div class="izlediklerimyil">
                    <?php echo $izledigim['filmyil']; ?>
                </div>
            </div>
    <?php } ?>
            <div class="temizle"></div>
        </div>
        <div id="oncekivesonraki">
            <?php if($this->oncekisayfa != false){echo '<div class="oncekisayfa"><a href="'.$this->oncekisayfa.'" title="Önceki Sayfa">Önceki</a></div>';} ?>
            <?php if($this->sonrakisayfa != false){echo '<div class="sonrakisayfa"><a href="'.$this->sonrakisayfa.'" title="Sonraki Sayfa">Sonraki</a></div>';} ?>
            <div class="temizle"></div>
        </div>
    </div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>