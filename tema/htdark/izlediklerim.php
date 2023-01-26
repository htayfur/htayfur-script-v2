<?php $this->headergetir(); ?>
    <div class="col-xl-8 col-lg-12 col-md-12">
        <div class="yazilistesi mb-4 shadow">
            <h1 class="yazibaslik p-2">İzlediklerim</h1>
            <div class="izlediklerimicerik p-2 my-1">
                <?php foreach($this->icerik as $izledigim){ ?>
                    <div class="izlediklerim float-left my-2">
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
                <div class="clearfix"></div>
            </div>
            <div class="sayfalama">
                <div class="sonrakisayfa mx-1 float-right">
                    <?php if($this->sonrakisayfa != false){echo '<a href="'.$this->sonrakisayfa.'" title="Sonraki Sayfa">Sonraki</a>';} ?>
                </div>
                <div class="oncekisayfa mx-1 float-right">
                    <?php if($this->oncekisayfa != false){echo '<a href="'.$this->oncekisayfa.'" title="Önceki Sayfa">Önceki</a>';} ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>