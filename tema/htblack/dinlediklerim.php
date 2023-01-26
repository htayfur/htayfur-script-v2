<?php $this->headergetir(); ?>
    <div id="solkisim">
        <div class="dinlediklerimkismi">
            <h1 class="sayfabaslik">Dinlediklerim</h1>
            <div class="dinlemealani">
                Şarkıyı dinlemek için şarkının üzerine tıklayın.
            </div>
            <?php foreach($this->icerik as $sarki){ ?>
                <div class="dinlediklerim">
                    <span><?php echo $sarki['sarkiadi']; ?><span class="gizlimuzikkodu"><?php echo $sarki['sarkikodu']; ?></span></span>
                </div>
            <?php } ?>
        </div>
        <div class="altbosluk"></div>
    </div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>