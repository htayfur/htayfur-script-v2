<?php $this->headergetir(); ?>
<div id="solkisim">
    <?php // $this->slider(); ?>
    <div id="yazialani">
        <?php foreach($this->icerik as $yazi){ ?>
        <div class="yazi">
            <div class="yazibaslik"><a href="<?php echo $this->sitelink.'/blog/'.$yazi['yaziurl'].'/' ?>"><?php echo $yazi['yaziadi'] ?></a></div>
            <div class="yazibilgi">
                <ul>
                    <li class="ybilgi ybilgiyazar"><?php echo $this->kullanicilar[$yazi['yaziyazar']]; ?></li>
                    <li class="ybilgi ybilgikategori"><?php echo $this->kategoriler[$yazi['yazikategori']]; ?></li>
                    <li class="ybilgi ybilgitarih"><?php echo date("d/m/Y",strtotime($yazi['yazitarih'])); ?></li>
                    <li class="ybilgi ybilgisaat"><?php echo date("H:i",strtotime($yazi['yazitarih'])); ?></li>
                </ul>
                <div class="temizle"></div>
            </div>
            <div class="onecikarilmis"><img src="<?php echo $yazi['yazionecikarilmis']; ?>" alt="<?php echo $yazi['yaziadi'] ?>"></div>
            <div class="yaziozet"><?php echo strip_tags(substr($yazi['yaziicerik'],0,335))."..."; ?></div>
            <div class="devaminioku"><a href="<?php echo $this->sitelink.'/blog/'.$yazi['yaziurl'].'/' ?>" title="<?php echo $yazi['yaziadi'] ?>">Devamını Oku</a></div>
            <div class="temizle"></div>
        </div>
        <?php } ?>
    </div>
    <div id="oncekivesonraki">
        <?php if($this->oncekisayfa != false){echo '<div class="oncekisayfa"><a href="'.$this->oncekisayfa.'" title="Önceki Sayfa">Önceki</a></div>';} ?>
        <?php if($this->sonrakisayfa != false){echo '<div class="sonrakisayfa"><a href="'.$this->sonrakisayfa.'" title="Sonraki Sayfa">Sonraki</a></div>';} ?>
        <div class="temizle"></div>
    </div>
</div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>