<?php $this->headergetir(); ?>
<div class="col-xl-8 col-lg-12 col-md-12">
<?php foreach($this->icerik as $yazi){ ?>
    <article class="yazilistesi mb-4 shadow">
        <h1 class="yazibaslik p-2"><a href="<?php echo $this->sitelink.'/blog/'.$yazi['yaziurl'].'/' ?>"><?php echo $yazi['yaziadi'] ?></a></h1>
        <?php if($yazi['yazionecikarilmis'] != NULL){ ?>
        <div class="onecikarilmisgorsel p-2 my-1">
            <a href="<?php echo $this->sitelink.'/blog/'.$yazi['yaziurl'].'/' ?>"><img src="<?php echo $yazi['yazionecikarilmis']; ?>" class="rounded img-fluid mx-auto d-block" alt="<?php echo $yazi['yaziadi'] ?>"></a>
        </div>
        <?php } ?>
        <div class="yazibilgileri p-2">
            <div class="nav">
                <ul class="nav">
                    <li class="nav-item yazibilgi yaziyazar"><?php echo $this->kullanicilar[$yazi['yaziyazar']]; ?></li>
                    <li class="nav-item yazibilgi yazikategori"><?php echo $this->kategoriler[$yazi['yazikategori']]; ?></li>
                    <li class="nav-item yazibilgi yazitarih"><?php echo date("d/m/Y",strtotime($yazi['yazitarih'])); ?></li>
                    <li class="nav-item yazibilgi yazisaat"><?php echo date("H:i",strtotime($yazi['yazitarih'])); ?></li>
                </ul>
            </div>
        </div>
        <div class="yaziozet p-2 my-1">
            <?php echo strip_tags(substr($yazi['yaziicerik'],0,350))."..."; ?>
        </div>
    </article>
<?php } ?>
    <div class="sayfalama">
        <div class="sonrakisayfa mx-1 float-right">
            <?php if($this->sonrakisayfa != false){echo '<a href="'.$this->sonrakisayfa.'" title="Sonraki Sayfa">Sonraki</a>';} ?>
        </div>
        <div class="oncekisayfa mx-1 float-right">
            <?php if($this->oncekisayfa != false){echo '<a href="'.$this->oncekisayfa.'" title="Önceki Sayfa">Önceki</a>';} ?>
        </div>
    </div>
</div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>