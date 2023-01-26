<?php $this->headergetir(); ?>
    <div class="col-xl-8 col-lg-12 col-md-12">
        <div class="yazilistesi mb-4 shadow">
            <h1 class="yazibaslik p-2">Dinlediklerim</h1>
            <div class="dinlediklerim p-2 my-1">
                <div class="dinlemealani">
                    Şarkıyı dinlemek için şarkının üzerine tıklayın.
                </div>
                <ul class="list-group my-2">
                    <?php foreach($this->icerik as $sarki){ ?>
                        <li class="list-group-item sarkiadi"><?php echo $sarki['sarkiadi']; ?><span class="gizlimuzikkodu d-none"><?php echo $sarki['sarkikodu']; ?></span></li>
                    <?php } ?>
                </ul>
            </div>

        </div>
    </div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>