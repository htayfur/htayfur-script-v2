<?php $this->headergetir(); ?>
    <div class="col-xl-8 col-lg-12 col-md-12">
        <div class="yazilistesi mb-4 shadow">
            <h1 class="yazibaslik p-2">İletişim</h1>
            <div class="iletisim p-2 my-1">
                <div>
                    <form action="/iletisimkur/" method="POST" id="iletisimformu">
                        <div class="form-group">
                            <label for="isimsoyisim">Ad Soyad:</label>
                            <input type="text" name="isimsoyisim" class="form-control forminput" placeholder="Ad Soyad">
                        </div>
                        <div class="form-group">
                            <label for="iletisimadresi">E-mail:</label>
                            <input type="text" name="iletisimadresi" class="form-control forminput" placeholder="E-mail Adresiniz">
                        </div>
                        <div class="form-group">
                            <label for="konu">Konu:</label>
                            <input type="text" name="konu" class="form-control forminput" placeholder="Konu">
                        </div>
                        <div class="form-group">
                            <label for="mesajicerigi">Mesajınız:</label><br>
                            <textarea name="mesajicerigi" class="form-control formtextarea" placeholder="Mesajınız..."></textarea>
                        </div>
                        <div class="form-group">
                            <div class="guvenliksorusu"><span class="gsorua"><?php echo rand(0,25); ?></span>+<span class="gsorub"><?php echo rand(0,25); ?></span> sonucu kaçtır?</div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="guvenliksorusucevap" id="guvenliksorusucevap" class="form-control forminput" placeholder="Sonuç?">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Gönder" id="iletisimgonder" class="btn btn-primary">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>