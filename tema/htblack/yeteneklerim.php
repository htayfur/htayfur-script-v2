<?php $this->headergetir(); ?>
    <div id="solkisim">
        <div class="yeteneklerkismi">
            <h1 class="sayfabaslik">Yeteneklerim</h1>
            <div class="yetenekler">
                <?php foreach($this->icerik as $yetenek){ ?>
                    <div class="yetenek">
                        <div class="yetenekadi"><?php echo $yetenek['yetenekadi'] ?></div>
                        <?php if($yetenek['yetenekaciklama']){?>
                            <div class="yetenekaciklama">(<?php echo $yetenek['yetenekaciklama'] ?>)</div>
                        <?php } ?>
                        <div class="temizle"></div>
                        <div class="yetenekarkaplan">
                            <div class="yetenekyuzde">
                                <div class="yetenekorani"><?php echo $yetenek['yetenekyuzde'] ?></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>