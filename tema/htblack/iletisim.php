<?php $this->headergetir(); ?>
    <div id="solkisim">
        <div class="iletisimkismi">
            <h1 class="sayfabaslik">İletişim</h1>
            <div class="iletisim">
                Bana aşağıdaki iletişim formunu doldurarak ulaşabilirsiniz. Kutuların hepsinin doldurulması zorunludur.
                <form action="/iletisimkur/" method="POST" id="iletisimformu">
                    <input type="text" name="isimsoyisim" placeholder="Ad Soyad"><br>
                    <input type="text" name="iletisimadresi" placeholder="Mail Adresiniz"><br>
                    <input type="text" name="konu" placeholder="Konu"><br>
                    <textarea name="mesajicerigi" title="Soru ve önerilerinizi buradan paylaşabilirsiniz." placeholder="Mesajınız..."></textarea><br>
                    <div class="guvenliksorusu"><span class="gsorua"><?php echo rand(0,25); ?></span>+<span class="gsorub"><?php echo rand(0,25); ?></span> sonucu kaçtır?</div>
                    <input type="text" name="guvenliksorusucevap" id="güvenliksorusucevap" placeholder="Sonuç?"><br>
                    <input type="submit" value="Gönder" id="iletisimgonder">
                </form>
                <div class="uyarimesaji"></div>
            </div>
        </div>
        <div class="altbosluk"></div>
    </div>
<?php $this->sidebargetir(); ?>
<?php $this->footergetir(); ?>