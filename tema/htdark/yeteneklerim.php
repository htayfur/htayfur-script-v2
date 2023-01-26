<?php $this->headergetir(); ?>
    <div class="col-xl-8 col-lg-12 col-md-12">
        <div class="yazilistesi mb-4 shadow">
            <h1 class="yazibaslik p-2">Yeteneklerim</h1>
            <div class="yetenekicerik p-2 my-1">
                <div>
                    <?php foreach($this->icerik as $yetenek){ ?>
                        <div class="yetenek p-1 my-1">
                            <div class="yetenekadi"><?php echo $yetenek['yetenekadi'] ?></div>
                            <?php if($yetenek['yetenekaciklama']){?>
                                <div class="yetenekaciklama my-1">(<?php echo $yetenek['yetenekaciklama'] ?>)</div>
                            <?php } ?>
                            <div class="progress">
                                <div class="progress-bar bg-info progress-bar-striped progress-bar-animated font-weight-bold" role="progressbar" style="width: <?php echo str_replace('%','',$yetenek['yetenekyuzde']); ?>%" aria-valuenow="<?php str_replace('%','',$yetenek['yetenekyuzde']); ?>" aria-valuemin="0" aria-valuemax="100">%<?php echo str_replace('%','',$yetenek['yetenekyuzde']); ?></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>