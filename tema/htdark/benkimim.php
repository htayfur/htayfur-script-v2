<?php $this->headergetir(); ?>
    <div class="col-xl-8 col-lg-12 col-md-12">
        <article class="yazilistesi mb-4 shadow">
            <h1 class="yazibaslik p-2"><?php echo $baslik; ?></h1>
            <div class="yaziicerik p-2 my-1">
                <?php echo $this->icerik; ?>
            </div>

        </article>
    </div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>