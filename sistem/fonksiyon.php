<?php
error_reporting(E_ERROR);
/**
 * Created by PhpStorm.
 * User: HakanTayfur
 * Date: 25.08.2016
 * Time: 12:10
 */

class HtayfurScript{

    public $veritabani;
    public $parametre;
    public $genelayarlar;
    // Genel Ayarlar
    public $title;
    public $keywords;
    public $description;
    public $icerik;
    public $temaurl;
    public $sitelink;
    public $oncekisayfa = 0;
    public $sonrakisayfa = 0;
    public $kategoriler;
    public $kullanicilar;


    public function __construct(){
        $this->parametre();
        $this->veritabani();
        $this->genelayarfonksiyon();
        $this->kategorilervekullanicilar();
        $this->yonlendirme();
    }

    public function veritabani(){
        include "ayar.php";
        try{
            $this->veritabani = new PDO("mysql:host=".$veritabanisunucu.";dbname=".$veritabaniadi.";charset=UTF8",$veritabanikadi,$veritabanisifre);
            $this->veritabani->query("SET NAMES UTF8");
        }catch (PDOException $hata){
            print $hata->getMessage();
        }
    }

    public function genelayarfonksiyon(){
        $genelayarlarsorgu = $this->veritabani->prepare("SELECT * FROM genelayarlar");
        $genelayarlarcalis = $genelayarlarsorgu->execute();
        $genelayarlarbol = $genelayarlarsorgu->fetchAll(PDO::FETCH_ASSOC);

        foreach($genelayarlarbol as $veri){
            $this->genelayarlar[$veri['ht_anahtar']] = $veri['ht_deger'];
        }
        $this->temaurl = $this->genelayarlar['siteadresi']."/".$this->genelayarlar['temayolu'];
        $this->sitelink = $this->genelayarlar['siteadresi'];
    }

    public function parametre(){
        $p = $_GET['p'];
        $p = explode("/",$p);
        $p = array_filter($p);
        $this->parametre = $p;
    }

    public function yonlendirme(){
        if(($this->parametre[0] == NULL) || ($this->parametre[0] == "blog")){
                if(($this->parametre[1] == "kategori") || ($this->parametre[0] == NULL) || ($this->parametre[1] == "sayfa")){
                    $this->blog();
                }elseif($this->parametre[0] == "blog"){
                    $this->blogyazi();
                }
        }else{
            switch($this->parametre[0]){
                case "benkimim":
                    $this->benkimim();
                    break;
                case "yeteneklerim":
                    $this->yeteneklerim();
                    break;
                case "izlediklerim":
                    $this->izlediklerim();
                    break;
                case "dinlediklerim":
                    $this->dinlediklerim();
                    break;
                case "iletisim":
                    $this->iletisim();
                    break;
                case "htadmin":
                    $this->htadmin();
                    break;
                case "zamanlayici":
                    $this->zamanlayici();
                    break;
                case "iletisimkur":
                    $this->iletisimkur();
                    break;
                case "hesapla":
                    $this->hesapla();
                    break;
                default:
                    $this->hatasayfasi();
                    break;
            }
        }
    }

    public function blog(){
        if($this->parametre[1] == "kategori"){
            if(($this->parametre[3] == "sayfa") || ((is_numeric($this->parametre[4]) || ($this->parametre[4] == NULL)))){
                if($this->parametre[3] == NULL || $this->parametre[4] == "1"){
                    $baslangic = 0;
                    $kacadet = $this->genelayarlar['kacadetyazi'];

                    // Önceki Sonraki
                    $oncekibaslangic = 0;
                    $oncekikacadet = $this->genelayarlar['kacadetyazi'];
                    $sonrakibaslangic = 10;
                    $sonrakikacadet = $this->genelayarlar['kacadetyazi'];
                }elseif(is_numeric($this->parametre[4])){
                    $kacadet = $this->genelayarlar['kacadetyazi'];
                    $baslangic = ($this->parametre[4]*$this->genelayarlar['kacadetyazi'])-$kacadet;

                    // Önceki Sonraki
                    $oncekibaslangic = $baslangic-$this->genelayarlar['kacadetyazi'];
                    $oncekikacadet = $this->genelayarlar['kacadetyazi'];
                    $sonrakibaslangic = $baslangic+$this->genelayarlar['kacadetyazi'];
                    $sonrakikacadet = $this->genelayarlar['kacadetyazi'];
                }else{
                    $this->hatasayfasi();
                    exit;
                }
            }
            $kategorisorgu = $this->veritabani->prepare("SELECT * FROM kategoriler WHERE kategoriurl=:kategoriurl");
            $kategorisorgucalistir = $kategorisorgu->execute(array("kategoriurl"=>$this->parametre[2]));
            $kategoriparcala = $kategorisorgu->fetch(PDO::FETCH_ASSOC);
            $kategori_id = $kategoriparcala['id'];
            $kategori_adi = $kategoriparcala['kategoriadi'];
            $kategori_description = $kategoriparcala['kategoridescription'];
            $kategori_keywords = $kategoriparcala['kategorikeywords'];
            $kategori_url = $kategoriparcala['kategoriurl'];
            $yazisorgula = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yazikategori =:yazikategori AND yazidurum=:yazidurum ORDER BY yazitarih DESC LIMIT $baslangic,$kacadet");
            $yazisorgucalistir = $yazisorgula->execute(array("yazikategori"=>$kategori_id,"yazidurum"=>"yayinda"));
            $yazilar = $yazisorgula->fetchAll(PDO::FETCH_ASSOC);

            // Önceki sonraki kontrol

            if($baslangic != 0){
                $oncekiyazisorgula = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yazikategori=:yazikategori AND yazidurum=:yazidurum ORDER BY yazitarih DESC LIMIT $oncekibaslangic,$kacadet");
                $oncekiyazisorgucalistir = $oncekiyazisorgula->execute(array("yazikategori"=>$kategori_id,"yazidurum"=>"yayinda"));
                if($oncekiyazisorgula->rowCount() != 0){$oncekisayfasayi = $this->parametre[4]-1;$this->oncekisayfa = $this->genelayarlar['siteadresi']."/blog/kategori/".$kategori_url."/".$oncekisayfasayi."/sayfa/";}
            }

            $sonrakiyazisorgula = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yazikategori=:yazikategori AND yazidurum=:yazidurum ORDER BY yazitarih DESC  LIMIT $sonrakibaslangic,$kacadet");
            $sonrakiyazisorgucalistir = $sonrakiyazisorgula->execute(array("yazikategori"=>$kategori_id,"yazidurum"=>"yayinda"));
            if($sonrakiyazisorgula->rowCount() != 0){if($this->parametre[4] == NULL || $this->parametre[4] == "1"){$sonrakisayfasayi = 2;}else{$sonrakisayfasayi = $this->parametre[4]+1;}$this->sonrakisayfa = $this->genelayarlar['siteadresi']."/blog/kategori/".$kategori_url."/sayfa/".$sonrakisayfasayi."/";}

            // Genel Değişken tanımlama

            $this->title = (($this->parametre[4] == NULL) || ($this->parametre[4] == "1"))?$kategori_adi." - ".$this->genelayarlar['siteadi']:"Sayfa ".$this->parametre[4]." - ".$kategori_adi." - ".$this->genelayarlar['siteadi'];
            $this->description = $kategori_description;
            $this->keywords = $kategori_keywords;
            $this->icerik = $yazilar;

        }elseif($this->parametre[1] == "sayfa"){
            if(($this->parametre[2] == NULL) || ($this->parametre[2] == "1")){
                $baslangic = 0;
                $kacadet = $this->genelayarlar['kacadetyazi'];

                // Önceki Sonraki
                $oncekibaslangic = 0;
                $oncekikacadet = $this->genelayarlar['kacadetyazi'];
                $sonrakibaslangic = $this->genelayarlar['kacadetyazi'];
                $sonrakikacadet = $this->genelayarlar['kacadetyazi'];
            }elseif(is_numeric($this->parametre[2])){
                $kacadet = $this->genelayarlar['kacadetyazi'];
                $baslangic = ($this->parametre[2]*$this->genelayarlar['kacadetyazi'])-$kacadet;

                // Önceki Sonraki
                $oncekibaslangic = $baslangic-$this->genelayarlar['kacadetyazi'];
                $oncekikacadet = $this->genelayarlar['kacadetyazi'];
                $sonrakibaslangic = $baslangic+$this->genelayarlar['kacadetyazi'];
                $sonrakikacadet = $this->genelayarlar['kacadetyazi'];
            }else{
                $this->hatasayfasi();
                exit;
            }
            $yazisorgula = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yazidurum =:yazidurum ORDER BY yazitarih DESC LIMIT $baslangic,$kacadet");
            $yazisorgucalistir = $yazisorgula->execute(array("yazidurum"=>"yayinda"));
            $yazilar = $yazisorgula->fetchAll(PDO::FETCH_ASSOC);

            // Önceki sonraki kontrol

            if($baslangic != 0){
                $oncekiyazisorgula = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yazidurum=:yazidurum ORDER BY yazitarih DESC LIMIT $oncekibaslangic,$kacadet");
                $oncekiyazisorgucalistir = $oncekiyazisorgula->execute(array("yazidurum"=>"yayinda"));
                if($oncekiyazisorgula->rowCount() != 0){$oncekisayfasayi = $this->parametre[2]-1;$this->oncekisayfa = $this->genelayarlar['siteadresi']."/blog/sayfa/".$oncekisayfasayi."/";}
            }

            $sonrakiyazisorgula = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yazidurum=:yazidurum ORDER BY yazitarih DESC  LIMIT $sonrakibaslangic,$kacadet");
            $sonrakiyazisorgucalistir = $sonrakiyazisorgula->execute(array("yazidurum"=>"yayinda"));
            if($sonrakiyazisorgula->rowCount() != 0){if($this->parametre[2] == NULL || $this->parametre[2] == "1"){$sonrakisayfasayi = 2;}else{$sonrakisayfasayi = $this->parametre[2]+1;}$this->sonrakisayfa = $this->genelayarlar['siteadresi']."/blog/sayfa/".$sonrakisayfasayi."/";}


            // Genel Değişken tanımlama

            $this->title = (($this->parametre[2] == NULL) || ($this->parametre[2] == "1"))?$this->genelayarlar['siteadi']." - Kişisel Web Günlüğü":"Sayfa ".$this->parametre[2]." - ".$this->genelayarlar['siteadi'];
            $this->description = $this->genelayarlar['sitedescription'];
            $this->keywords = $this->genelayarlar['sitekeywords'];
            $this->icerik = $yazilar;

        }elseif($this->parametre[0] == NULL){
            $baslangic = 0;
            $kacadet = $this->genelayarlar['kacadetyazi'];

            $yazisorgula = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yazidurum=:yazidurum ORDER BY yazitarih DESC LIMIT $baslangic,$kacadet");
            $yazisorgucalistir = $yazisorgula->execute(array("yazidurum"=>"yayinda"));
            $yazilar = $yazisorgula->fetchAll(PDO::FETCH_ASSOC);

            // Sonraki sayfa varmı
            $sonrakibaslangic = $baslangic+$this->genelayarlar['kacadetyazi'];
            $sonrakikacadet = $this->genelayarlar['kacadetyazi'];
            $sonrakiyazisorgula = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yazidurum=:yazidurum ORDER BY yazitarih DESC  LIMIT $sonrakibaslangic,$kacadet");
            $sonrakiyazisorgucalistir = $sonrakiyazisorgula->execute(array("yazidurum"=>"yayinda"));
            if($sonrakiyazisorgula->rowCount() != 0){if($this->parametre[0] == NULL || $this->parametre[2] == 1){$sonrakisayfasayi = 2;}else{$sonrakisayfasayi = $this->parametre[2]+1;}$this->sonrakisayfa = $this->genelayarlar['siteadresi']."/blog/sayfa/".$sonrakisayfasayi."/";}

            // Genel Değişken Tanımlama

            $this->title = $this->genelayarlar['siteadi']." - Kişisel Web Günlüğü";
            $this->description = $this->genelayarlar['sitedescription'];
            $this->keywords = $this->genelayarlar['sitekeywords'];
            $this->icerik = $yazilar;

        }else{
            $this->hatasayfasi();
            exit;
        }

        include $this->genelayarlar['temayolu']."blog.php";
    }

    public function blogyazi(){
        $yaziurl = $this->parametre[1];
        $yazisorgula = $this->veritabani->prepare("SELECt * FROM yazilar WHERE yaziurl=:yaziurl AND yazidurum=:yazidurum");
        $yazisorgucalistir = $yazisorgula->execute(array("yaziurl"=>$yaziurl,"yazidurum"=>"yayinda"));
        if($yazisorgula->rowCount()==0){$this->hatasayfasi();exit;}
        $yaziparcala = $yazisorgula->fetch(PDO::FETCH_ASSOC);
        $yazi_id = $yaziparcala['id'];
        $yazi_adi = $yaziparcala['yaziadi'];
        $yazi_icerik = $yaziparcala['yaziicerik'];
        $yazi_keywords = $yaziparcala['yazikeywords'];
        $yazi_description = $yaziparcala['yazidescription'];
        $yazi_yazar_id = $yaziparcala['yaziyazar'];
        $yazi_tarih = date("d/m/Y",strtotime($yaziparcala['yazitarih']));
        $yazi_tarih_saat = date("H:i",strtotime($yaziparcala['yazitarih']));
        $yazi_url = $yaziparcala['yaziurl'];
        $yazi_onecikarilmis = $yaziparcala['yazionecikarilmis'];
        $yazi_kategori_id = $yaziparcala['yazikategori'];
        $yazi_tam_url = $this->genelayarlar['siteadresi']."/blog/".$yazi_url."/";

        // Yazar Bilgileri
        $yazarsorgu = $this->veritabani->prepare("SELECT * FROM kullanicilar WHERE id=:yazar_id");
        $yazarsorgucalistir = $yazarsorgu->execute(array("yazar_id"=>$yazi_yazar_id));
        $yazarsorgubol = $yazarsorgu->fetch(PDO::FETCH_ASSOC);
        $yazar_adsoyad = $yazarsorgubol['adsoyad'];

        // Kategori Bilgileri
        $kategorisorgu = $this->veritabani->prepare("SELECt * FROM kategoriler WHERE id=:kategori_id");
        $kategorisorgucalistir = $kategorisorgu->execute(array("kategori_id"=>$yazi_kategori_id));
        $kategorisorgubol = $kategorisorgu->fetch(PDO::FETCH_ASSOC);
        $kategori_adi = $kategorisorgubol['kategoriadi'];
        $kategori_url = $kategorisorgubol['kategoriurl'];
        $kategori_tam_url = $this->genelayarlar['siteadresi']."/blog/kategori/".$kategori_url."/";


        //Yazı içerik

        preg_match('@<form(.*?)<\/form>@',$yazi_icerik,$yazieslesme);
        $yazieslesme = $yazieslesme[0];
        if ($yazieslesme){
            $yazi_icerik = str_replace($yazieslesme,htmlentities($yazieslesme),$yazi_icerik);
        }

        //Genel Değişken Tanımlama

        $this->title = $yazi_adi." - ".$this->genelayarlar['siteadi'];
        $this->keywords = $yazi_keywords;
        $this->description = $yazi_description;

        include $this->genelayarlar['temayolu']."blogyazi.php";
    }

    public function benkimim(){
        $benkimimsorgu = $this->veritabani->prepare("SELECT * FROM sayfalar WHERE sayfa=:sayfa");
        $benkimimsorgucalistir = $benkimimsorgu->execute(array("sayfa"=>"benkimim"));
        $benkimimbol = $benkimimsorgu->fetch(PDO::FETCH_ASSOC);

        $baslik = $benkimimbol['anatitle'];
        $this->icerik = $benkimimbol['anaicerik'];

        //Genel Değişken Tanımlama

        $this->title = "Ben Kimim? - ".$this->genelayarlar['siteadi'];
        $this->keywords = $benkimimbol['anakeywords'];
        $this->description = $benkimimbol['anadescription'];

        include $this->genelayarlar['temayolu']."benkimim.php";
    }

    public function yeteneklerim(){
        $yeteneksorgu = $this->veritabani->prepare("SELECT * FROM yetenekler ORDER BY yetenekadi ASC");
        $yeteneksorgucalistir = $yeteneksorgu->execute();
        $yetenekbol = $yeteneksorgu->fetchAll(PDO::FETCH_ASSOC);

        $this->title = "Yeteneklerim - ".$this->genelayarlar['siteadi'];
        $this->description = "Sahip olduğum yetenekler ve seviyeleri hakkında bilgi alabileceğiniz web sayfası.";
        $this->keywords = "Hakan Tayfur,hakan tayfur yetenekler,hakan tayfur skills,hakan tayfur kabiliyet,hakan tayfur beceri";
        $this->icerik = $yetenekbol;

        include $this->genelayarlar['temayolu']."yeteneklerim.php";
    }

    public function izlediklerim(){
        if(($this->parametre[1]) == NULL || ($this->parametre[1] == "1")){
            $baslangic=0;
            $kacadet=9;
            $oncekibaslangic = 0;
            $sonrakibaslangic = $baslangic+$kacadet;
        }elseif(is_numeric($this->parametre[1])){
            $kacadet=9;
            $baslangic=($this->parametre[1]*$kacadet)-$kacadet;
            $oncekibaslangic = $baslangic-$kacadet;
            $sonrakibaslangic = $baslangic+$kacadet;
        }else{
            $this->hatasayfasi();
            exit;
        }

        $izlediklerimsorgu = $this->veritabani->prepare("SELECT * FROM izlediklerim ORDER BY filmyil DESC, id DESC LIMIT $baslangic,$kacadet");
        $izlediklerimsorgucalistir = $izlediklerimsorgu->execute();
        $izlediklerimbol = $izlediklerimsorgu->fetchAll(PDO::FETCH_ASSOC);


        // Önceki ve sonraki
        if($baslangic != 0){
            $oncekisayfasorgu = $this->veritabani->prepare("sELECT * FROM izlediklerim ORDER BY filmyil DESC,id DESC LIMIT $oncekibaslangic,$kacadet");
            $oncekisayfasorgucalistir = $oncekisayfasorgu->execute();
            if($oncekisayfasorgu->rowCount() != 0){$oncekisayfasayi = $this->parametre[1]-1;$this->oncekisayfa=$this->genelayarlar['siteadresi']."/izlediklerim/".$oncekisayfasayi."/";}
        }

        $sonrakisayfasorgu = $this->veritabani->prepare("SELECT * FROM izlediklerim ORDER BY filmyil DESC,id DESC LIMIT $sonrakibaslangic,$kacadet");
        $sonrakisayfasorgucalistir = $sonrakisayfasorgu->execute();
        if($sonrakisayfasorgu->rowCount() != 0){if($this->parametre[1] == NULL || $this->parametre[1]=="1"){$sonrakisayfasayi=2;}else{$sonrakisayfasayi=$this->parametre[1]+1;}$this->sonrakisayfa=$this->genelayarlar['siteadresi']."/izlediklerim/".$sonrakisayfasayi."/";}

        // Genel değişken tanımlama
        $this->title = ($this->parametre[1] == NULL || $this->parametre[1] == "1")?"İzlediklerim - ".$this->genelayarlar['siteadi']:"Sayfa ".$this->parametre[1]." - İzlediklerim - ".$this->genelayarlar['siteadi'];
        $this->description = "İzledigim ve tavsiye edebileceğim filmlerin listesi.";
        $this->keywords = "izlediklerim,öneri filmler,tavsiye filmler,öneri diziler,tavsiye diziler";
        $this->icerik = $izlediklerimbol;

        include $this->genelayarlar['temayolu']."izlediklerim.php";

    }

    public function dinlediklerim(){
        $dinlediklerimsorgu = $this->veritabani->prepare("SELECt * FROM dinlediklerim ORDER BY id DESC");
        $dinlediklerimsorgucalistir = $dinlediklerimsorgu->execute();
        $dinlediklerimbol = $dinlediklerimsorgu->fetchAll(PDO::FETCH_ASSOC);

        // Genel değişken tanımlama
        $this->title = "Dinlediklerim - ".$this->genelayarlar['siteadi'];
        $this->description = "Son zamanlarda dinlediğim ve dinlediğinizde sizlerinde hoşuna gidecek güncel şarkıların listesi.";
        $this->keywords = "dinlediklerim,öneri müzikler,öneri şarkılar,tavsiye müzikler,tavsiye yabancı şarkılar";
        $this->icerik = $dinlediklerimbol;

        include $this->genelayarlar['temayolu']."dinlediklerim.php";
    }

    public function iletisim(){

        //Genel Değişken Tanımlama
        $this->title = "İletişim - ".$this->genelayarlar['siteadi'];
        $this->description = "Her türlü soru ve sorunlarızı benimle iletişime geçerek paylaşabilirsiniz.";
        $this->keywords = "hakan tayfur mail,hakan tayfur iletişim,hakan tayfur facebook,hakan tayfur twitter,hakan tayfur iletişim bilgileri";

        include $this->genelayarlar['temayolu']."iletisim.php";

    }

    public function htadmin(){
        $this->sessionbasla();
        switch($this->parametre[1]){
            case "":
                $this->girissayfasi();
                break;
            case "genelayarlar":
                $this->panelgenelayarlar();
                break;
            case "yazilar":
                $this->panelyazilar();
                break;
            case "yaziekle":
                $this->panelyazilar();
                break;
            case "fotograflar":
                $this->panelfotograflar();
                break;
            case "kategoriler":
                $this->panelkategoriler();
                break;
            case "benkimim":
                $this->panelbenkimim();
                break;
            case "yeteneklerim":
                $this->panelyeteneklerim();
                break;
            case "izlediklerim":
                $this->panelizlediklerim();
                break;
            case "dinlediklerim":
                $this->paneldinlediklerim();
                break;
            case "fotografyukle":
                $this->panelfotografyukle();
                break;
            case "cikisyap":
                $this->panelcikisyap();
                break;
        }
        $this->sessionyenile();
    }

    public function sessionbasla(){
        session_start();
        ob_start();
    }
    public function sessionyenile(){
        ob_end_flush();
    }
    public function sessionkontrol(){
        if(!$_SESSION['yetki']){
            echo 'Bu sayfaya erişim hakkınız yok!';
            echo '<script>window.location = "http://"+window.location.hostname+"/htadmin/";</script>';
            exit;
        }
    }

    public function girissayfasi(){
        if($_POST){
            $kadi = $_POST['kadi'];
            $ksifre = $_POST['ksifre'];
            $kullanicisorgula = $this->veritabani->prepare("SELECT * FROM kullanicilar WHERE kadi = :kadi AND sifre = :sifre");
            $kullanicisorgulacalistir = $kullanicisorgula->execute(array('kadi'=>$kadi,'sifre'=>MD5($ksifre)));
            $kvarmi = $kullanicisorgula->rowCount();
            if($kvarmi == 0){echo 'Yanlış kullanıcı adı veya şifre!'.'<script>window.location = "http://"+window.location.hostname+"/htadmin/";</script>';}else{$kullanicibol = $kullanicisorgula->fetch(PDO::FETCH_ASSOC);$_SESSION['adsoyad']=$kullanicibol['adsoyad'];$_SESSION['id']=$kullanicibol['id'];$_SESSION['yetki']=$kullanicibol['yetki'];echo '<script>window.location = "http://"+window.location.hostname+"/htadmin/genelayarlar/";</script>';}

        }else{
            echo '<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HT Admin - Giriş</title>
    <style type="text/css">
        input{
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #BCBCBC;
            margin: 5px 0px;
        }
        input[type=submit]{
            background-color: #000000;
            color: #FFFFFF;
            padding: 10px;
        }
    </style>
</head>
<body>
<div style="width:100%;max-width: 300px;margin: 0 auto;">
    <form action="/htadmin/" method="POST">
        <input type="text" name="kadi" placeholder="Kullanıcı Adı"><br>
        <input type="password" name="ksifre" placeholder="Şifreniz"><br>
        <input type="submit" value="Giriş">
    </form>
</div>
</body>
</html>';
        }
    }
    public function panelgenelayarlar(){
        $this->sessionkontrol();
        if($_POST){
            $gelenayarlarsorgu = $this->veritabani->prepare("SELECT * FROM genelayarlar ORDER BY id ASC");
            $gelenayarlarsorgucalistir = $gelenayarlarsorgu->execute();
            $gelenayarlarbol = $gelenayarlarsorgu->fetchAll(PDO::FETCH_ASSOC);
            foreach($gelenayarlarbol as $gelenayarlar){
                $gelenayarguncellesorgu = $this->veritabani->prepare("UPDATE genelayarlar SET ht_deger = :htdeger WHERE ht_anahtar = :htanahtar");
                $gelenayarguncellecalistir = $gelenayarguncellesorgu->execute(array("htdeger"=>$_POST[$gelenayarlar['ht_anahtar']],"htanahtar"=>$gelenayarlar['ht_anahtar']));
                $this->icerik = "Ayarlar başarıyla güncellendi. İnanmıyorsan aha dayıya sor";
            }

        }else{
            $genelayarlarsorgu = $this->veritabani->prepare("SELECT * FROM genelayarlar ORDER BY id ASC");
            $genelayarlarsorgucalistir = $genelayarlarsorgu->execute();
            $genelsorgubol = $genelayarlarsorgu->fetchAll(PDO::FETCH_ASSOC);
            $genelayarlarkod = '<tr><td>Ayar Adı</td><td>Ayar Değer</td></tr>';
            foreach($genelsorgubol as $genelayarlar){
                $genelayarlarkod = $genelayarlarkod.'<tr>
                <td>'.$genelayarlar['ht_anahtar'].'</td>
                <td><textarea name="'.$genelayarlar['ht_anahtar'].'" class="genelayarlartextarea">'.$genelayarlar['ht_deger'].'</textarea></td>
                </tr>';
            }
            $this->icerik = '<div><table><form action="" method="POST">'.$genelayarlarkod.'<tr><td><input type="submit" value="Kaydet" class="kaydetbutonu" /></td></tr></form></div></table>';
        }

        include "panel.php";
    }

    public function panelfotograflar(){
        $this->sessionkontrol();
        if($_POST){
            $silsorgu = $this->veritabani->prepare("DELETE FROM fotograflar WHERE id = :id");
            $silsorgucalistir = $silsorgu->execute(array("id"=>$_POST['id']));
            unlink(str_replace($this->genelayarlar['siteadresi'],"",$_POST['fotolink']));
            $this->icerik = ($silsorgucalistir == 1)?"Fotoğraf başarıyla silindi!":"Fotoğraf silinirken bir sorun oluştu!";
        }else{
            $kacadet = 10;
            $baslangic = (($this->parametre[2] == NULL) || ($this->parametre[2] == "1"))?"0":($this->parametre[2]*10)-$kacadet;
            $fotograflarsorgu = $this->veritabani->prepare("SELECt * FROM fotograflar ORDER BY id DESC LIMIT $baslangic,$kacadet");
            $fotograflarsorgucalistir = $fotograflarsorgu->execute();
            $fotograflarbol = $fotograflarsorgu->fetchAll(PDO::FETCH_ASSOC);
            $fotografkodu = "<tr><td>Fotoğraf</td><td>ID</td><td>Yazı ID</td><td>Sil</td></tr>";
            foreach($fotograflarbol as $fotograf){
                $fotografkodu = $fotografkodu.'<tr><td><img src="'.$fotograf['fotolink'].'" class="fotograflar"></td><td>'.$fotograf['id'].'</td><td>'.$fotograf['yaziid'].'</td><td><form action="" method="POST"><input type="hidden" name="id" value="'.$fotograf['id'].'"><input type="hidden" name="fotolink" value="'.$fotograf['fotolink'].'"><input type="submit" value="Sil" class="kaydetbutonu"></form></td></tr>';
            }
            $onceki = (!$this->parametre[2])?0:$this->parametre[2]-1;$sonraki = (!$this->parametre[2])?2:$this->parametre[2]+1;
            $this->icerik = "<table>".$fotografkodu."</table><div class='oncekivesonraki'><a href='/htadmin/fotograflar/$onceki/'>Önceki</a></div><div class='oncekivesonraki'><a href='/htadmin/fotograflar/$sonraki/'>Sonraki</a></div>";
        }
        include "panel.php";
    }

    public function panelkategoriler(){
        $this->sessionkontrol();
        if($_POST['islem'] == "yeniekleform"){
            $this->icerik = '<div class="formdiv"><input type="text" name="kategoriadi" placeholder="Kategori Adı" class="genelinput"><br><textarea name="kategoridescription" placeholder="Kategori Description" class="geneltextarea"></textarea><br><textarea name="kategorikeywords" placeholder="Kategori Keywords" class="geneltextarea"></textarea><br><input type="hidden" name="islem" value="yeniekle"><input type="submit" value="Kategori Ekle" class="kaydetbutonu"></div>';
        }elseif($_POST['islem'] == "yeniekle"){
            $kategorieklesorgu = $this->veritabani->prepare("INSERT INTO kategoriler SET kategoriadi=:kategoriadi,kategoriurl=:kategoriurl,kategoridescription=:kategoridescription,kategorikeywords=:kategorikeywords");
            $kategorieklecalistir = $kategorieklesorgu->execute(array("kategoriadi"=>$_POST['kategoriadi'],"kategoriurl"=>$this->seolink($_POST['kategoriadi']),"kategoridescription"=>$_POST['kategoridescription'],"kategorikeywords"=>$_POST['kategorikeywords']));
            $this->icerik = ($kategorieklecalistir == 1)?"Kategori başarıyla eklendi!":"Kategori eklenirken bir sorun oluştu!";
        }elseif($_POST['islem'] == "guncelleform"){
            $kategorisorgula = $this->veritabani->prepare("SELECT * FROM kategoriler WHERE id=:kategori_id");
            $kategorisorgucalistir = $kategorisorgula->execute(array("kategori_id"=>$_POST['id']));
            $kategoribol = $kategorisorgula->fetch(PDO::FETCH_ASSOC);
            $this->icerik = '<div class="formdiv"><form action="" method="POST"><input type="hidden" name="id" value="'.$kategoribol['id'].'"><input type="hidden" name="islem" value="guncelle"><input type="text" name="kategoriadi" value="'.$kategoribol['kategoriadi'].'" class="genelinput"><br><textarea name="kategoridescription" class="geneltextarea">'.$kategoribol['kategoridescription'].'</textarea><br><textarea name="kategorikeywords" class="geneltextarea">'.$kategoribol['kategorikeywords'].'</textarea><br><input type="submit" value="Güncelle" class="kaydetbutonu"></form></div>';
        }elseif($_POST['islem'] == "guncelle"){
            $kategoriguncellesorgu = $this->veritabani->prepare("UPDATE kategoriler SET kategoriadi = :kategoriadi, kategoriurl = :kategoriurl, kategoridescription = :kategoridescription, kategorikeywords = :kategorikeywords WHERE id = :kategori_id");
            $kategoriguncellecalistir = $kategoriguncellesorgu->execute(array("kategoriadi"=>$_POST['kategoriadi'],"kategoriurl"=>$this->seolink($_POST['kategoriadi']),"kategoridescription"=>$_POST['kategoridescription'],"kategorikeywords"=>$_POST['kategorikeywords'],"kategori_id"=>$_POST['id']));
            $this->icerik = ($kategoriguncellecalistir == 1)?"Kategori başarıyla güncellendi!":"Kategori güncellenirken bir sorun oluştu!";
        }elseif($_POST['islem'] == "sil"){
            if($_POST['eminmisin'] == "evet"){
                $kategorisil = $this->veritabani->prepare("DELETE FROM kategoriler WHERE id = :kategori_id");
                $kategorisilcalistir = $kategorisil->execute(array("kategori_id"=>$_POST['id']));
                $this->icerik = ($kategorisilcalistir == 1)?"Kategori başarıyla silindi!":"Kategori silinirken bir sorun oluştu!";
            }else{
                $this->icerik = '<div class="formdiv">Kategoriyi silmek istediğinize emin misiniz?<br> <form action="" method="POST"><input type="hidden" name="eminmisin" value="evet"><input type="hidden" name="id" value="'.$_POST['id'].'"><input type="submit" value="Evet" class="kaydetbutonu"></form></div>';
            }
        }else{
            $kategorilersorgu = $this->veritabani->prepare("SELECT * FROM kategoriler ORDER BY id ASC");
            $kategorilersorgucalistir = $kategorilersorgu->execute();
            $kategorileribol = $kategorilersorgu->fetchAll(PDO::FETCH_ASSOC);
            $kategorikodu = "<tr><td>ID</td><td>Kategori Adı</td><td>Kategori URL</td><td>Description</td><td>Keywords</td><td>Güncelle</td><td>Sil</td><tr>";

            foreach($kategorileribol as $kategori){
                $kategorikodu = $kategorikodu.'<tr><td>'.$kategori['id'].'</td><td>'.$kategori['kategoriadi'].'</td><td>'.$kategori['kategoriurl'].'</td><td>'.$kategori['kategoridescription'].'</td><td>'.$kategori['kategorikeywords'].'</td><td><form action="" method="POST"><input name="islem" type="hidden" value="guncelleform" /><input name="id" type="hidden" value="'.$kategori['id'].'" /><input type="submit" value="Güncelle" class="kaydetbutonu" /></form></td><td><form action="" method="POST"><input name="islem" type="hidden" value="sil" /><input name="id" type="hidden" value="'.$kategori['id'].'" /><input type="submit" value="Sil" class="kaydetbutonu" /></form></td><tr>';
            }
            $this->icerik = '<table>'.$kategorikodu.'<tr><td><form action="" method="POST"><input name="islem" type="hidden" value="yeniekleform"><input type="submit" value="Yeni Ekle" class="kaydetbutonu"></form></td></tr></table>';
        }
        include "panel.php";
    }

    public function panelbenkimim(){
        $this->sessionkontrol();
        if($_POST){
            $benkimimguncellesorgu = $this->veritabani->prepare("UPDATE sayfalar SET anatitle = :anatitle, anakeywords = :anakeywords, anadescription = :anadescription, anaicerik = :anaicerik");
            $benkimimguncellecalistir = $benkimimguncellesorgu->execute(array("anatitle"=>$_POST['anatitle'],"anakeywords"=>$_POST['anakeywords'],"anadescription"=>$_POST['anadescription'],"anaicerik"=>$_POST['anaicerik']));
            $this->icerik = ($benkimimguncellecalistir == 1)?"Ben kimim bilgileri başarıyla güncellendi!":"Ben kimim bilgileri güncellenirken bir sorun oluştu!";
        }else{
            $benkimimsorgu = $this->veritabani->prepare("SELECT * FROM sayfalar WHERE sayfa = :benkimim");
            $benkimimsorgucalistir = $benkimimsorgu->execute(array("benkimim"=>"benkimim"));
            $benkimimbol = $benkimimsorgu->fetch(PDO::FETCH_ASSOC);
            $this->icerik = $this->editorayarlari().'<div class="formdiv"><form action="" method="POST"><input type="text" name="anatitle" value="'.$benkimimbol['anatitle'].'" class="genelinput"><br><input type="text" name="anakeywords" value="'.$benkimimbol['anakeywords'].'" class="genelinput"><br><input type="text" name="anadescription" value="'.$benkimimbol['anadescription'].'" class="genelinput"><br><textarea name="anaicerik" class="geneltextarea">'.$benkimimbol['anaicerik'].'</textarea><br><input type="submit" value="Güncelle" class="kaydetbutonu"></form></div>';
        }
        include "panel.php";
    }

    public function panelyeteneklerim(){
        $this->sessionkontrol();
        if($_POST['islem'] == "yetenekekleform"){
            $this->icerik = '<div class="formdiv"><form action="" method="POST"><input type="text" name="yetenekadi" placeholder="Yetenek Adı" class="genelinput"><br><input type="text" name="yetenekaciklama" placeholder="Yetenek Açıklama" class="genelinput"><br><input type="text" name="yetenekyuzde" placeholder="Yetenek Yüzdesi" class="genelinput"><br><input type="submit" value="Yetenek Ekle" class="kaydetbutonu"></form></div>';
        }elseif($_POST['islem'] == "yetenekekle"){
            $yetenekeklesorgu = $this->veritabani->prepare("INSERT INTO yetenekler SET yetenekadi=:yetenekadi,yetenekaciklama=:yetenekaciklama,yetenekyuzde=:yetenekyuzde");
            $yeteneksorgucalistir = $yetenekeklesorgu->execute(array("yetenekadi"=>$_POST['yetenekadi'],"yetenekaciklama"=>$_POST['yetenekaciklama'],"yetenekyuzde"=>$_POST['yetenekyuzde']));
            $this->icerik = ($yeteneksorgucalistir == 1)?"Yetenek ekleme işlemi başarıyla tamamlandı!":"Yetenek ekleme işlemi tamamlanırken bir sorun oluştu!";
        }elseif($_POST['islem'] == "yetenekguncelleform"){
            $yeteneksorgu = $this->veritabani->prepare("SELECT * FROM yetenekler WHERE id=:yetenek_id");
            $yeteneksorgucalistir = $yeteneksorgu->execute(array("yetenek_id"=>$_POST['id']));
            $yetenekbol = $yeteneksorgu->fetch(PDO::FETCH_ASSOC);
            $this->icerik = '<div class="formdiv"><form action="" method="POST"><input type="text" name="yetenekadi" value="'.$yetenekbol['yetenekadi'].'" class="genelinput"><br><input type="text" name="yetenekaciklama" value="'.$yetenekbol['yetenekaciklama'].'" class="genelinput"><br><input type="text" name="yetenekyuzde" value="'.$yetenekbol['yetenekyuzde'].'" class="genelinput"><br><input type="hidden" name="id" value="'.$yetenekbol['id'].'"><input type="hidden" name="islem" value="yetenekguncelle"><input type="submit" value="Güncelle" class="kaydetbutonu"></form></div>';
        }elseif($_POST['islem'] == "yetenekguncelle"){
            $yetenekguncellesorgu = $this->veritabani->prepare("UPDATE yetenekler SET yetenekadi=:yetenekadi,yetenekaciklama=:yetenekaciklama,yetenekyuzde=:yetenekyuzde WHERE id=:yetenek_id");
            $yetenekguncellesorgucalistir = $yetenekguncellesorgu->execute(array("yetenekadi"=>$_POST['yetenekadi'],"yetenekaciklama"=>$_POST['yetenekaciklama'],"yetenekyuzde"=>$_POST['yetenekyuzde'],"yetenek_id"=>$_POST['id']));
            $this->icerik = ($yetenekguncellesorgucalistir == 1)?"Yeteneğınız başarıyla güncellendi!":"Yetenek güncellenirken bir sorun oluştu!";
        }elseif($_POST['islem'] == "yeteneksil"){
            $yeteneksilsorgu = $this->veritabani->prepare("DELETE FROM yetenekler WHERE id=:yetenek_id");
            $yeteneksilsorgucalistir = $yeteneksilsorgu->execute(array("yetenek_id"=>$_POST['id']));
            $this->icerik = ($yeteneksilsorgucalistir == 1)?"Yetenek başarıyla silindi!":"Yetenek silinirken bir sorun oluştu!";
        }else{
            $yeteneksorgu = $this->veritabani->prepare("SELECT * FROM yetenekler ORDER BY yetenekadi ASC");
            $yeteneksorgucalistir = $yeteneksorgu->execute();
            $yeteneksorgubol = $yeteneksorgu->fetchAll(PDO::FETCH_ASSOC);
            $yetenekkodu = "<tr><td>ID</td><td>Yetenek Adı</td><td>Yetenek Açıklama</td><td>Yüzde</td><td>Güncelle</td><td>Sil</td></tr>";

            foreach($yeteneksorgubol as $yetenek){
                $yetenekkodu = $yetenekkodu."<tr><td>".$yetenek['id']."</td><td>".$yetenek['yetenekadi']."</td><td>".$yetenek['yetenekaciklama']."</td><td>".$yetenek['yetenekyuzde'].'</td><td><form action="" method="POST"><input type="hidden" name="islem" value="yetenekguncelleform" /><input type="hidden" name="id" value="'.$yetenek['id'].'" /><input type="submit" value="Güncelle" class="kaydetbutonu" /></form></td><td><form action="" method="POST"><input type="hidden" name="islem" value="yeteneksil" /><input type="hidden" name="id" value="'.$yetenek['id'].'" /><input type="submit" value="Sil" class="kaydetbutonu" /></form></td></tr>';
            }
            $this->icerik = '<table>'.$yetenekkodu.'<tr><td><form action="" method="POST"><input name="islem" type="hidden" value="yetenekekleform"><input type="submit" value="Yeni Ekle" class="kaydetbutonu"></form></td></tr></table>';
        }

        include "panel.php";
    }

    public function panelizlediklerim(){
        $this->sessionkontrol();
        if($_POST['islem'] == "izlediklerimekleform"){
            $this->icerik = '<div class="formdiv"><form action="" method="POST" enctype="multipart/form-data"><input type="text" name="filmadi" placeholder="Film Adı" class="genelinput"><br><input type="text" name="filmyil" placeholder="Film Yılı" class="genelinput"><br><input type="file" name="filmafis" class="genelinput"><br><input type="hidden" name="islem" value="izlediklerimekle"><input type="submit" value="Film Ekle" class="kaydetbutonu"></form></div>';
        }elseif($_POST['islem'] == "izlediklerimekle"){
            $filmafis = $_FILES['filmafis'];
            if($filmafis['error'] > 0){$this->icerik = "Film fotoğraf dosyası yüklenirken bir sorun oluştu!";
            }else{
                if(file_exists("uploads/izlediklerim/".$filmafis['name'])){unlink("uploads/izlediklerim/".$filmafis['name']);move_uploaded_file($filmafis['tmp_name'],"uploads/izlediklerim/".$filmafis['name']);}
                else{move_uploaded_file($filmafis['tmp_name'],"uploads/izlediklerim/".$filmafis['name']);}
                $this->resimboyutlandir("uploads/izlediklerim/".$filmafis['name'],null,225,318,false,"uploads/izlediklerim/".$filmafis['name'],true,false,100);
                $filmeklesorgu = $this->veritabani->prepare("INSERT INTO izlediklerim SET filmadi=:filmadi,filmafis=:filmafis,filmyil=:filmyil");
                $filmeklesorgucalistir = $filmeklesorgu->execute(array("filmadi"=>$_POST['filmadi'],"filmafis"=>"/uploads/izlediklerim/".$filmafis['name'],"filmyil"=>$_POST['filmyil']));
                $this->icerik = ($filmeklesorgucalistir == 1)?"Film başarıyla eklendi!":"Film eklenirken bir sorun oluştu!";
            }
        }elseif($_POST['islem'] == "izlediklerimguncelleform"){
            $izlediklerimsorgu = $this->veritabani->prepare("SELECT * FROM izlediklerim WHERE id=:izlediklerim_id");
            $izlediklerimsorgucalistir = $izlediklerimsorgu->execute(array("izlediklerim_id"=>$_POST['id']));
            $izlediklerim = $izlediklerimsorgu->fetch(PDO::FETCH_ASSOC);
            $this->icerik = '<div class="formdiv"><form action="" method="POST" enctype="multipart/form-data"><input type="text" name="filmadi" value="'.$izlediklerim['filmadi'].'" class="genelinput"><br><input type="text" name="filmyil" value="'.$izlediklerim['filmyil'].'" class="genelinput"><br><input type="file" name="filmafis" class="genelinput"><br><input type="hidden" name="islem" value="izlediklerimguncelle"><input type="hidden" name="id" value="'.$izlediklerim['id'].'"><input type="submit" value="Film Güncelle" class="kaydetbutonu"></form></div>';
        }elseif($_POST['islem'] == "izlediklerimguncelle"){
            if(empty($_FILES['filmafis']['name'])){
                $izlediklerimguncellesorgu = $this->veritabani->prepare("UPDATE izlediklerim SET filmadi=:filmadi,filmyil=:filmyil WHERE id=:izlediklerim_id");
                $izlediklerimguncellesorgucalistir = $izlediklerimguncellesorgu->execute(array("filmadi"=>$_POST['filmadi'],"filmyil"=>$_POST['filmyil'],"izlediklerim_id"=>$_POST['id']));
                $this->icerik = ($izlediklerimguncellesorgucalistir == 1)?"İzlediğim başarıyla güncellendi!":"İzlediğim güncellenirken bir sorun oluştu!";
            }else{
                if($_FILES['filmafis']['error'] > 0){$this->icerik = "Fotoğraf dosyası yüklenirken bir sorun oluştu!";
                }else{
                    if(file_exists("uploads/izlediklerim/".$_FILES['filmafis']['name'])){unlink("uploads/izlediklerim/".$_FILES['filmafis']['name']);move_uploaded_file($_FILES['filmafis']['tmp_name'],"uploads/izlediklerim/".$_FILES['filmafis']['name']);}
                    else{move_uploaded_file($_FILES['filmafis']['tmp_name'],"uploads/izlediklerim/".$_FILES['filmafis']['name']);}
                    $this->resimboyutlandir("uploads/izlediklerim/".$_FILES['filmafis']['name'],null,225,318,false,"uploads/izlediklerim/".$_FILES['filmafis']['name'],true,false,100);
                    $izlediklerimguncellesorgu = $this->veritabani->prepare("UPDATE izlediklerim SET filmadi=:filmadi,filmyil=:filmyil,filmafis=:filmafis WHERE id=:izlediklerim_id");
                    $izlediklerimguncellesorgucalistir = $izlediklerimguncellesorgu->execute(array("filmadi"=>$_POST['filmadi'],"filmyil"=>$_POST['filmyil'],"filmafis"=>"uploads/izlediklerim/".$_FILES['filmafis']['name'],"izlediklerim_id"=>$_POST['id']));
                    $this->icerik = ($izlediklerimguncellesorgucalistir == 1)?"İzlediğim başarıyla güncellendi!":"İzlediğim güncellenirken bir sorun oluştu!";
                }
            }
        }elseif($_POST['islem'] == "izlediklerimsil"){
            $izlediklerimsilsorgu = $this->veritabani->prepare("DELETE FROM izlediklerim WHERE id=:izlediklerim_id");
            $izlediklerimsilsorgucalistir = $izlediklerimsilsorgu->execute(array("izlediklerim_id"=>$_POST['id']));
            $this->icerik = ($izlediklerimsilsorgucalistir == 1)?"İzlediğim başarıyla silindi!":"İzlediğim silinirken bir sorun oluştu!";
            unlink(substr($_POST['filmafis'],1));
        }else{
            $kacadet = 20;
            $baslangic = (($this->parametre[2] == NULL) || ($this->parametre[2] == "1"))?"0":($this->parametre[2]*$kacadet)-$kacadet;
            $izlediklerimsorgu = $this->veritabani->prepare("SELECT * FROM izlediklerim ORDER BY id DESC LIMIT $baslangic,$kacadet");
            $izlediklerimsorgucalistir = $izlediklerimsorgu->execute();
            $izlediklerimbol = $izlediklerimsorgu->fetchAll(PDO::FETCH_ASSOC);
            $izlediklerimkodu = '<tr><td>ID</td><td>Film Adı</td><td>Film Afis</td><td>Film Yıl</td><td>Güncelle</td><td>Sil</td></tr>';
            foreach($izlediklerimbol as $izlediklerim){
                $izlediklerimkodu = $izlediklerimkodu.'<tr><td>'.$izlediklerim['id'].'</td><td>'.$izlediklerim['filmadi'].'</td><td>'.$izlediklerim['filmafis'].'</td><td>'.$izlediklerim['filmyil'].'</td><td><form action="" method="POST"><input type="hidden" name="islem" value="izlediklerimguncelleform"><input type="hidden" name="id" value="'.$izlediklerim['id'].'"><input type="submit" value="Güncelle" class="kaydetbutonu"></form></td><td><form action="" method="POST"><input type="hidden" name="islem" value="izlediklerimsil"><input type="hidden" name="id" value="'.$izlediklerim['id'].'"><input type="hidden" name="filmafis" value="'.$izlediklerim['filmafis'].'"><input type="submit" value="Sil" class="kaydetbutonu"></form></td></tr>';
            }
            $onceki = (($this->parametre[2] == NULL) || ($this->parametre[2] == "1"))?0:$this->parametre[2]-1; $sonraki = (($this->parametre[2] == NULL) || ($this->parametre[2] == "1"))?2:$this->parametre[2]+1;
            $this->icerik = '<table>'.$izlediklerimkodu.'<tr><td><form action="" method="POST"><input type="hidden" name="islem" value="izlediklerimekleform"><input type="submit" value="Yeni Ekle" class="kaydetbutonu"></form></td></tr></table>'."<div class='oncekivesonraki'><a href='/htadmin/izlediklerim/$onceki/'>Önceki</a></div><div class='oncekivesonraki'><a href='/htadmin/izlediklerim/$sonraki/'>Sonraki</a></div>";
        }
        include "panel.php";
    }

    public function paneldinlediklerim(){
        $this->sessionkontrol();
        if($_POST['islem'] == "dinlediklerimekleform"){
            $this->icerik = '<div class="formdiv"><form action="" method="POST"><input type="text" name="sarkiadi" placeholder="Şarkı Adı" class="genelinput"><br><input type="text" name="sarkikodu" placeholder="Şarkı Kodu" class="genelinput"><br><input type="hidden" name="islem" value="dinlediklerimekle"><input type="submit" value="Şarkı Ekle" class="kaydetbutonu"></form></div>';
        }elseif($_POST['islem'] == "dinlediklerimekle"){
            $dinlediklerimeklesorgu = $this->veritabani->prepare("INSERT INTO dinlediklerim SET sarkiadi=:sarkiadi,sarkikodu=:sarkikodu");
            $dinlediklerimeklesorgucalistir = $dinlediklerimeklesorgu->execute(array("sarkiadi"=>$_POST['sarkiadi'],"sarkikodu"=>$_POST['sarkikodu']));
            $this->icerik = ($dinlediklerimeklesorgucalistir == 1)?"Şarkı başarıyla eklendi!":"Şarkı eklenirken bir sorun oluştu!";
        }elseif($_POST['islem'] == "dinlediklerimsil"){
            $dinlediklerimsilsorgu = $this->veritabani->prepare("DELETE FROM dinlediklerim WHERE id=:dinlediklerim_id");
            $dinlediklerimsilsorgucalistir = $dinlediklerimsilsorgu->execute(array("dinlediklerim_id"=>$_POST['id']));
            $this->icerik = ($dinlediklerimsilsorgucalistir == 1)?"Şarkı başarıyla silindi!":"Şarkı silinirken bir sorun oluştu!";
        }else{
            $dinlediklerimsorgu = $this->veritabani->prepare("SELECT * FROM dinlediklerim ORDER BY id DESC");
            $dinlediklerimsorgucalistir = $dinlediklerimsorgu->execute();
            $dinlediklerimbol = $dinlediklerimsorgu->fetchAll(PDO::FETCH_ASSOC);
            $dinlediklerimkodu = '<tr><td>ID</td><td>Şarkı Adı</td><td>Şarkı Kodu</td><td>Sil</td></tr>';
            foreach($dinlediklerimbol as $dinlediklerim){
                $dinlediklerimkodu = $dinlediklerimkodu.'<tr><td>'.$dinlediklerim['id'].'</td><td>'.$dinlediklerim['sarkiadi'].'</td><td>'.$dinlediklerim['sarkikodu'].'</td><td><form action="" method="POST"><input type="hidden" name="id" value="'.$dinlediklerim['id'].'"><br><input type="hidden" name="islem" value="dinlediklerimsil"><input type="submit" value="Sil" class="kaydetbutonu"></form></td></tr>';
            }
            $this->icerik = '<table>'.$dinlediklerimkodu.'<tr><td><form action="" method="POST"><input type="hidden" name="islem" value="dinlediklerimekleform"><input type="submit" value="Yeni Ekle" class="kaydetbutonu"></form></td></tr></table>';
        }
        include "panel.php";
    }

    public function panelyazilar(){
        if($_POST['islem'] == "yeniyaziekleform"){
            $taslakvarmi = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yaziadi =:yaziadi AND yazidurum =:yazidurum ORDER BY id DESC");
            $taslakvarmisorgu = $taslakvarmi->execute(array("yaziadi"=>"(Otomatik Taslak)","yazidurum"=>"taslak"));
            $taslakvarmiymis = $taslakvarmi->rowCount();
            if($taslakvarmiymis > 0){$taslakbol = $taslakvarmi->fetch(PDO::FETCH_ASSOC);$taslakid = $taslakbol['id'];}else{$taslakekle = $this->veritabani->prepare("INSERT INTO yazilar SET yaziadi=:yaziadi,yaziicerik=:yaziicerik,yazikeywords=:yazikeywords,yazidescription=:yazidescription,yazidurum=:yazidurum,yaziurl=:yaziurl,yazitarih=:yazitarih,yaziyazar=:yaziyazar,yazionecikarilmis=:yazionecikarilmis,yazikategori=:yazikategori");$taslakeklecalistir = $taslakekle->execute(array("yaziadi"=>"(Otomatik Taslak)","yaziicerik"=>"","yazikeywords"=>"","yazidescription"=>"","yazidurum"=>"taslak","yaziurl"=>"","yazionecikarilmis"=>"","yazitarih"=>date("Y-m-d H:i:s"),"yaziyazar"=>$_SESSION['id'],"yazikategori"=>"1"));$taslakid = $this->veritabani->lastInsertId();}
            $kategoriler="";foreach($this->kategoriler as $kategorianahtar=>$kategorideger){
                $kategoriler = $kategoriler.'<option value="'.$kategorianahtar.'">'.$kategorideger.'</option>';
            }
            $this->icerik = $this->editorayarlari().'<div class="yaziekleguncelle">
    <div class="yazisolalan">
        <form action="/htadmin/yazilar/" method="POST" id="yaziformu" enctype="multipart/form-data">
            <input type="hidden" name="taslakid" value="'.$taslakid.'" >
            <input type="hidden" name="islem" value="yaziguncelle">
            <input type="text" name="yazibaslik" value="(Otomatik Taslak)" placeholder="Yazı Başlık" class="genelinput"><br>
            <input type="text" name="yazikeywords" value="" placeholder="Anahtar Kelimeler" class="genelinput"><br>
            <select name="yazidurum" class="genelinput">
                <option value="taslak">Taslak</option>
                <option value="yayinda">Yayınla</option>
            </select><br>
            <input type="file" name="yazionecikarilmis" class="genelinput"><br>
            <select name="yazikategori">
            '.$kategoriler.'
            </select><br>
            <textarea name="yaziicerik" class="yaziiceriktextarea"></textarea>
            <input type="submit" value="Yazıyı Ekle" class="kaydetbutonu">
        </form>
    </div>
    <div class="yazisagalan">
        <form action="/htadmin/fotografyukle/" method="POST" enctype="multipart/form-data" id="fotografyukle">
            <input type="file" name="fotograf" class="fotografyukleinput"><br>
            <input type="hidden" name="taslakid" value="'.$taslakid.'">
            <input type="submit" value="Fotoğraf Yükle" class="kaydetbutonu">
        </form>
        <div class="fotograflinki"></div>
    </div>
</div>';
        }elseif($_POST['islem'] == "yaziguncelleform"){
            $yazisorgula = $this->veritabani->prepare("SELECT * FROM yazilar WHERE id=:yazi_id");
            $yazisorgulacalistir = $yazisorgula->execute(array("yazi_id"=>$_POST['id']));
            $yazibol = $yazisorgula->fetch(PDO::FETCH_ASSOC);

            $kategoriler="";foreach($this->kategoriler as $kategorianahtar=>$kategorideger){
                if($yazibol['yazikategori'] == $kategorianahtar){
                    $kategoriler = $kategoriler.'<option selected value="'.$kategorianahtar.'">'.$kategorideger.'</option>';
                }else{
                    $kategoriler = $kategoriler.'<option value="'.$kategorianahtar.'">'.$kategorideger.'</option>';
                }
            }
            if($yazibol['yazidurum']=="taslak"){$durumtaslak = "selected";}else{$durumtaslak="";}
            if($yazibol['yazidurum']=="yayinda"){$durumyayinda = "selected";}else{$durumyayinda="";}
            $this->icerik = $this->editorayarlari().'<div class="yaziekleguncelle">
    <div class="yazisolalan">
        <form action="/htadmin/yazilar/" method="POST" id="yaziformu" enctype="multipart/form-data">
            <input type="hidden" name="taslakid" value="'.$yazibol['id'].'" >
            <input type="hidden" name="islem" value="yaziguncelle">
            <input type="text" name="yazibaslik" value="'.$yazibol['yaziadi'].'" placeholder="Yazı Başlık" class="genelinput"><br>
            <input type="text" name="yazikeywords" value="'.$yazibol['yazikeywords'].'" placeholder="Anahtar Kelimeler" class="genelinput"><br>
            <select name="yazidurum" class="genelinput">
                <option '.$durumtaslak.' value="taslak">Taslak</option>
                <option '.$durumyayinda.' value="yayinda">Yayınla</option>
            </select><br>
            <input type="file" name="yazionecikarilmis" class="genelinput"><br>
            <select name="yazikategori">
            '.$kategoriler.'
            </select><br>
            <textarea name="yaziicerik" class="yaziiceriktextarea">'.$yazibol['yaziicerik'].'</textarea>
            <input type="submit" value="Yazıyı Ekle" class="kaydetbutonu">
        </form>
    </div>
    <div class="yazisagalan">
        <form action="/htadmin/fotografyukle/" method="POST" enctype="multipart/form-data" id="fotografyukle">
            <input type="file" name="fotograf" class="fotografyukleinput"><br>
            <input type="hidden" name="taslakid" value="'.$yazibol['id'].'">
            <input type="submit" value="Fotoğraf Yükle" class="kaydetbutonu">
        </form>
        <div class="fotograflinki"></div>
    </div>
</div>';
        }elseif($_POST['islem'] == "yaziguncelle"){
            $taslak_id = $_POST['taslakid'];
            $yazi_adi = $_POST['yazibaslik'];
            $yazi_keywords = $_POST['yazikeywords'];
            $yazi_durum = $_POST['yazidurum'];
            $yazi_one_cikarilmis = $_FILES['yazionecikarilmis'];
            $yazi_kategori = $_POST['yazikategori'];
            $yazi_icerik = $_POST['yaziicerik'];
            $yazi_description = strip_tags(substr($yazi_icerik,0,160));
            $yazi_yazar = $_SESSION['id'];
            $yazi_tarih = date("Y-m-d H:i:s");
            $yazi_url = $this->seolink($yazi_adi);
            $yazi_one_cikarilmis_link = "";

            if(empty($yazi_one_cikarilmis['name'])){
                $yazi_one_cikarilmis_link ="";
            }else{
                if($yazi_one_cikarilmis['error'] > 0){
                }else{
                    if(file_exists("uploads/onecikarilmis/".$yazi_one_cikarilmis['name'])){
                        unlink("uploads/onecikarilmis/".$yazi_one_cikarilmis['name']);
                        move_uploaded_file($yazi_one_cikarilmis['tmp_name'],"uploads/onecikarilmis/".$yazi_one_cikarilmis['name']);
                    }else{
                        move_uploaded_file($yazi_one_cikarilmis['tmp_name'],"uploads/onecikarilmis/".$yazi_one_cikarilmis['name']);
                    }
                    $yazi_one_cikarilmis_link = $this->sitelink."/uploads/onecikarilmis/".$yazi_one_cikarilmis['name'];
                }
            }

            if($yazi_one_cikarilmis_link != ""){
                $yaziguncelle = $this->veritabani->prepare("UPDATE yazilar SET yaziadi=:yaziadi,yaziicerik=:yaziicerik,yazikeywords=:yazikeywords,yazidescription=:yazidescription,yaziyazar=:yaziyazar,yazitarih=:yazitarih,yazidurum=:yazidurum,yaziurl=:yaziurl,yazionecikarilmis=:yazionecikarilmis,yazikategori=:yazikategori WHERE id=:yazi_id");
                $yaziguncellecalistir = $yaziguncelle->execute(array("yaziadi"=>$yazi_adi,"yaziicerik"=>$yazi_icerik,"yazikeywords"=>$yazi_keywords,"yazidescription"=>$yazi_description,"yaziyazar"=>$yazi_yazar,"yazitarih"=>$yazi_tarih,"yazidurum"=>$yazi_durum,"yaziurl"=>$yazi_url,"yazionecikarilmis"=>$yazi_one_cikarilmis_link,"yazikategori"=>$yazi_kategori,"yazi_id"=>$taslak_id));
            }else{
                $yaziguncelle = $this->veritabani->prepare("UPDATE yazilar SET yaziadi=:yaziadi,yaziicerik=:yaziicerik,yazikeywords=:yazikeywords,yazidescription=:yazidescription,yaziyazar=:yaziyazar,yazitarih=:yazitarih,yazidurum=:yazidurum,yaziurl=:yaziurl,yazikategori=:yazikategori WHERE id=:yazi_id");
                $yaziguncellecalistir = $yaziguncelle->execute(array("yaziadi"=>$yazi_adi,"yaziicerik"=>$yazi_icerik,"yazikeywords"=>$yazi_keywords,"yazidescription"=>$yazi_description,"yaziyazar"=>$yazi_yazar,"yazitarih"=>$yazi_tarih,"yazidurum"=>$yazi_durum,"yaziurl"=>$yazi_url,"yazikategori"=>$yazi_kategori,"yazi_id"=>$taslak_id));
            }

        }elseif($_POST['islem'] == "yazisil"){
            $yazisilsorgu = $this->veritabani->prepare("UPDATE yazilar SET yazidurum=:yazidurum WHERE id=:yazi_id");
            $yazisilsorgucalistir = $yazisilsorgu->execute(array("yazidurum"=>"silindi","yazi_id"=>$_POST['id']));
            $this->icerik = ($yazisilsorgucalistir == 1)?"Yazı başarıyla silindi!":"Yazı silinirken bir sorun oluştu!";
        }else{
            $kacadet = 20;
            $baslangic = (($this->parametre[2] == NULL) || $this->parametre[2] == "1")?0:($this->parametre[2]*$kacadet)-$kacadet;
            $yazilarsorgu = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yazidurum NOT LIKE 'silindi' ORDER BY id DESC LIMIT $baslangic,$kacadet");
            $yazilarsorgucalistir = $yazilarsorgu->execute();
            $yazilarbol = $yazilarsorgu->fetchAll(PDO::FETCH_ASSOC);
            $yazilarkodu = '<tr><td>ID</td><td>Yazı Adı</td><td>Yazar</td><td>Tarih</td><td>Durum</td><td>Kategori</td><td>Güncelle</td><td>Sil</td></tr>';
            foreach($yazilarbol as $yazilar){
                $yazilarkodu = $yazilarkodu.'<tr><td>'.$yazilar['id'].'</td><td>'.$yazilar['yaziadi'].'</td><td>'.$this->kullanicilar[$yazilar['yaziyazar']].'</td><td>'.date("d/m/Y H:i",strtotime($yazilar['yazitarih'])).'</td><td>'.$yazilar['yazidurum'].'</td><td>'.$this->kategoriler[$yazilar['yazikategori']].'</td><td><form action="" method="POST"><input type="hidden" name="id" value="'.$yazilar['id'].'"><input type="hidden" name="islem" value="yaziguncelleform"><input type="submit" value="Güncelle" class="kaydetbutonu"></form></td><td><form action="" method="POST"><input type="hidden" name="id" value="'.$yazilar['id'].'"><input type="hidden" name="islem" value="yazisil"><input type="submit" value="Sil" class="kaydetbutonu"></form></td></tr>';
            }
            $onceki = (($this->parametre[2] == NULL) || ($this->parametre[2] == "1"))?0:$this->parametre[2]-1; $sonraki = (($this->parametre[2] == NULL) || ($this->parametre[2] == "1"))?2:$this->parametre[2]+1;
            $this->icerik = '<table>'.$yazilarkodu.'<tr><td><form action="" method="POST"><input type="hidden" name="islem" value="yeniyaziekleform"><input type="submit" value="Yeni Ekle" class="kaydetbutonu"></form></td></tr></table>'."<div class='oncekivesonraki'><a href='/htadmin/yazilar/$onceki/'>Önceki</a></div><div class='oncekivesonraki'><a href='/htadmin/yazilar/$sonraki/'>Sonraki</a></div>";
        }
        include "panel.php";
    }
    public function panelfotografyukle(){
        $this->sessionkontrol();
        $fotograf = $_FILES['fotograf'];
        $yaziid = $_POST['taslakid'];
        if($fotograf['error'] > 0){
            echo "Fotoğraf yüklenirken bir sorun oluştu!";
        }else{
            if(file_exists("uploads/imgs/".$fotograf['name'])){
                unlink("uploads/imgs/".$fotograf['name']);
                move_uploaded_file($fotograf['tmp_name'],"uploads/imgs/".$fotograf['name']);
            }else{
                move_uploaded_file($fotograf['tmp_name'],"uploads/imgs/".$fotograf['name']);
            }
            $fotograflinki = $this->sitelink."/uploads/imgs/".$fotograf['name'];
            $fotografeklesorgu = $this->veritabani->prepare("INSERT INTO fotograflar SET yaziid=:yaziid,fotolink=:fotolink");
            $fotografeklesorgucalistir = $fotografeklesorgu->execute(array("yaziid"=>$yaziid,"fotolink"=>$fotograflinki));
            echo "<div>".$fotograflinki."</div>";
        }
    }

    public function panelcikisyap(){
        $this->sessionkontrol();
        session_destroy();
        echo '<script>window.location = "http://"+window.location.hostname+"/htadmin/";</script>';
    }

    public function iletisimkur(){
        $iletisimisim = $_POST['isimsoyisim'];
        $iletisimmail = $_POST['iletisimadresi'];
        $iletisimkonu = $_POST['konu'];
        $iletisimmesaj = $_POST['mesajicerigi'];
        if(($iletisimisim != NULL) && ($iletisimmail != NULL) && ($iletisimkonu != NULL) && ($iletisimmesaj != NULL)){
            $this->mailgonder($iletisimmail,$iletisimisim,$iletisimkonu,$iletisimmesaj);
        }

    }

    public function hesapla(){
        if($_POST){
            $uzunluk = $_POST['uzunluk'];
            $en = $_POST['en'];
            $yukseklik = $_POST['yukseklik'];
            $kacadet = $_POST['kacadet'];
            $gram = $_POST['gram'];

            $sonuc = (2*$uzunluk*$en)+(2*$uzunluk*$yukseklik)+(2*$en*$yukseklik);

            $adetbasina = (($sonuc*$gram)/10000)/1000;
            $toplam = $adetbasina*$kacadet;

            echo 'Adet başına : '.$adetbasina.'<br>'.'Toplam: '.$toplam;

        }else{
            echo '<form action="" method="POST">
<label for="uzunluk">Uzunluk:</label>
<input type="text" name="uzunluk" placeholder="Santimetre Cinsinden">
<br>
<label for="en">En:</label>
<input type="text" name="en" placeholder="Santimetre Cinsinden">
<br>
<label for="yukseklik">Yükseklik:</label>
<input type="text" name="yukseklik" placeholder="Santimetre Cinsinden">
<br>
<label for="Kacadet">Kaç adet?</label>
<input type="text" name="kacadet" placeholder="Birim Adet">
<br>
<label for="gram">Kaç Gram?</label>
<input type="text" name="gram" placeholder="Örnek: 90">
<br>
<input type="submit" value="Hesapla">
</form>';
        }
    }

    public function mailgonder($gonderen,$gonderenadi,$konu,$icerik){
        include "class.smtp.php";
        include "class.phpmailer.php";

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'domain.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@domain.com';
        $mail->Password = 'password';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('noreply@domain.com', 'No Reply');
        $mail->addAddress('iletisim@domain.com', 'Ad Soyad');
        $mail->addReplyTo($gonderen,$gonderenadi);
        $mail->Subject = $konu;
        $mail->Body = $icerik;
        $mail->AltBody = $icerik;
        $mail->CharSet = 'UTF-8';

        if(!$mail->send()) {
            echo 'Mesajınız gönderilirken bir sorun oluştu.';
            echo 'Mail hatası: ' . $mail->ErrorInfo;
        } else {
            echo 'Mesajınız başarıyla gönderildi.';
        }

    }
    public function zamanlayici(){
        $ayarlar = $this->genelayarlar;
        $sitemapolustur = '<url>
		<loc>'.$ayarlar['siteadresi'].'</loc>
		<changefreq>always</changefreq>
		<priority>1.0</priority>
        </url>
        <url>
		<loc>'.$ayarlar['siteadresi'].'/benkimim/'.'</loc>
		<changefreq>weekly</changefreq>
		<priority>0.8</priority>
        </url>
        <url>
		<loc>'.$ayarlar['siteadresi'].'/yeteneklerim/'.'</loc>
		<changefreq>weekly</changefreq>
		<priority>0.8</priority>
        </url>
        <url>
		<loc>'.$ayarlar['siteadresi'].'/blog/'.'</loc>
		<changefreq>hourly</changefreq>
		<priority>0.9</priority>
        </url>
        <url>
		<loc>'.$ayarlar['siteadresi'].'/izlediklerim/'.'</loc>
		<changefreq>weekly</changefreq>
		<priority>0.8</priority>
        </url>
        <url>
		<loc>'.$ayarlar['siteadresi'].'/dinlediklerim/'.'</loc>
		<changefreq>weekly</changefreq>
		<priority>0.8</priority>
        </url>
        <url>
		<loc>'.$ayarlar['siteadresi'].'/iletisim/'.'</loc>
		<changefreq>weekly</changefreq>
		<priority>0.8</priority>
        </url>
        ';

        $yazisorgula = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yazidurum=:yazidurum ORDER BY yazitarih DESC");
        $yazisorgucalistir = $yazisorgula->execute(array("yazidurum"=>"yayinda"));
        $yazilariparcala = $yazisorgula->fetchAll(PDO::FETCH_ASSOC);

        foreach($yazilariparcala as $yazi){
            $sitemapolustur = $sitemapolustur.'<url>
            <loc>'.$ayarlar['siteadresi'].'/blog/'.$yazi['yaziurl'].'/'.'</loc>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
            </url>
            ';
        }

        $sitemapkodu = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
            xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">
          '.$sitemapolustur.'
        </urlset>';

        $sitemapac = fopen("sitemap.xml","w+");
        fwrite($sitemapac,$sitemapkodu);
        fclose($sitemapac);

    }
    public function seolink($metin){
        $ara = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
        $degistir = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
        $metin = strtolower(str_replace($ara, $degistir, $metin));
        $metin = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $metin);
        $metin = trim(preg_replace('/\s+/', ' ', $metin));
        $metin = str_replace(' ', '-', $metin);
        return $metin;
    }

    public function editorayarlari(){
        $editorayarlari = "<script>
    tinymce.init({ selector: \"textarea\",
    menubar:false,entity_encoding : \"raw\",
    plugins: \"link image preview code\",
    toolbar1: \"bold, italic, underline, strikethrough, alignleft, aligncenter, alignright, alignjustify, styleselect, code\",
    toolbar2: \"link image php html css yt preview\",
        setup: function (editor) {
            editor.addButton('php', {
                text: 'PHP',
                icon: false,
                onclick: function () {
                    editor.selection.setContent('<pre><code class=\"php\">' + editor.selection.getContent() + '</code></pre>');
                }
            });
            editor.addButton('html', {
                text: 'HTML',
                icon: false,
                onclick: function () {
                    editor.selection.setContent('<pre><code class=\"html\">' + editor.selection.getContent() + '</code></pre>');
                }
            });
            editor.addButton('css', {
                text: 'CSS',
                icon: false,
                onclick: function () {
                    editor.selection.setContent('<pre><code class=\"css\">' + editor.selection.getContent() + '</code></pre>');
                }
            });
            editor.addButton('yt', {
                text: 'YT',
                icon: false,
                onclick: function () {
                    editor.selection.setContent('<iframe style=\"width: 100%; height: 400px;\" src=\"https://www.youtube.com/embed/' + editor.selection.getContent() + '?feature=oembed\" frameborder=\"0\" allowfullscreen=\"\"></iframe>');
                }
            });
        }
    });</script>";
        return $editorayarlari;
    }
    public function resimboyutlandir($file,$string=null,$width=0,$height=0,$proportional=false,$output='file',$delete_original=true,$use_linux_commands=false,$quality=100) {

        if ( $height <= 0 && $width <= 0 ) return false;
        if ( $file === null && $string === null ) return false;
        # Setting defaults and meta
        $info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
        $image                        = '';
        $final_width                  = 0;
        $final_height                 = 0;
        list($width_old, $height_old) = $info;
        $cropHeight = $cropWidth = 0;
        # Calculating proportionality
        if ($proportional) {
            if      ($width  == 0)  $factor = $height/$height_old;
            elseif  ($height == 0)  $factor = $width/$width_old;
            else                    $factor = min( $width / $width_old, $height / $height_old );
            $final_width  = round( $width_old * $factor );
            $final_height = round( $height_old * $factor );
        }
        else {
            $final_width = ( $width <= 0 ) ? $width_old : $width;
            $final_height = ( $height <= 0 ) ? $height_old : $height;
            $widthX = $width_old / $width;
            $heightX = $height_old / $height;

            $x = min($widthX, $heightX);
            $cropWidth = ($width_old - $width * $x) / 2;
            $cropHeight = ($height_old - $height * $x) / 2;
        }
        # Loading image to memory according to type
        switch ( $info[2] ) {
            case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
            case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
            case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
            default: return false;
        }


        # This is the resizing/resampling/transparency-preserving magic
        $image_resized = imagecreatetruecolor( $final_width, $final_height );
        if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
            $transparency = imagecolortransparent($image);
            $palletsize = imagecolorstotal($image);
            if ($transparency >= 0 && $transparency < $palletsize) {
                $transparent_color  = imagecolorsforindex($image, $transparency);
                $transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                imagefill($image_resized, 0, 0, $transparency);
                imagecolortransparent($image_resized, $transparency);
            }
            elseif ($info[2] == IMAGETYPE_PNG) {
                imagealphablending($image_resized, false);
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                imagefill($image_resized, 0, 0, $color);
                imagesavealpha($image_resized, true);
            }
        }
        imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);


        # Taking care of original, if needed
        if ( $delete_original ) {
            if ( $use_linux_commands ) exec('rm '.$file);
            else @unlink($file);
        }
        # Preparing a method of providing result
        switch ( strtolower($output) ) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;
            case 'file':
                $output = $file;
                break;
            case 'return':
                return $image_resized;
                break;
            default:
                break;
        }

        # Writing image according to type to the output destination and image quality
        switch ( $info[2] ) {
            case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
            case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
            case IMAGETYPE_PNG:
                $quality = 9 - (int)((0.9*$quality)/10.0);
                imagepng($image_resized, $output, $quality);
                break;
            default: return false;
        }
        return true;
    }


    // Ufak Fonksiyonlar
    public function sidebarkategoriler(){
        $kategorisorgu = $this->veritabani->prepare("SELECT * FROM kategoriler ORDER BY kategoriadi ASC");
        $kategorisorgucalistir = $kategorisorgu->execute();
        $kategorileribol = $kategorisorgu->fetchAll(PDO::FETCH_ASSOC);
        $kategoriler = "";
        foreach($kategorileribol as $kategori){
            $kategoriler = $kategoriler.'<li class="list-group-item"><a href="'.$this->sitelink.'/blog/kategori/'.$kategori['kategoriurl'].'/" title="'.$kategori['kategoriadi'].'">'.$kategori['kategoriadi'].'</a></li>'."\n";
        }

        $sonkod = '<div class="bilesen mt-3 mb-3">
        <div class="bilesenbaslik bilesenkategori">
            Kategoriler
        </div>
        <div class="bilesenicerik">
            <ul class="list-group list-group-flush">
                '.$kategoriler.'
            </ul>
        </div>
    </div>';
        echo $sonkod;
    }

    public function sidebarsonyazilar(){
        $sonyazilarsorgu = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yazidurum=:yazidurum ORDER BY yazitarih DESC LIMIT 5");
        $sonyazilarsorgucalistir = $sonyazilarsorgu->execute(array("yazidurum"=>"yayinda"));
        $sonyazilaribol = $sonyazilarsorgu->fetchAll(PDO::FETCH_ASSOC);
        $sonyazilar = "";
        foreach($sonyazilaribol as $sonyazi){
            $sonyazilar = $sonyazilar.'<li class="list-group-item"><a href="'.$this->sitelink.'/blog/'.$sonyazi['yaziurl'].'/" title="'.$sonyazi['yaziadi'].'">'.$sonyazi['yaziadi'].'</a></li>'."\n";
        }

        $sonkod = '<div class="bilesen mt-3 mb-3">
        <div class="bilesenbaslik bilesenyazilar">
            Son Yazılar
        </div>
        <div class="bilesenicerik">
            <ul class="list-group list-group-flush">
                '.$sonyazilar.'
            </ul>
        </div>
    </div>';
        echo $sonkod;
    }

    public function slider(){
        $slidersorgu = $this->veritabani->prepare("SELECT * FROM yazilar WHERE yazidurum=:yazidurum ORDER BY yazitarih DESC LIMIT 5 ");
        $slidersorgucalistir = $slidersorgu->execute(array("yazidurum"=>"yayinda"));
        $slidersorgubol = $slidersorgu->fetchAll(PDO::FETCH_ASSOC);
        $sliderkodu = '';
        foreach($slidersorgubol as $slider){
            $sliderkodu = $sliderkodu.'<li><a href="'.$this->sitelink.'/blog/'.$slider['yaziurl'].'/" class="sliderlink">
                    <img src="'.$slider['yazionecikarilmis'].'" alt="'.$slider['yaziadi'].'">
                    <div class="slider"><span class="sliderbaslik">'.$slider['yaziadi'].'</span></div>
                </a></li>'."\n";
        }

        $sonkod = '<div id="slider">
            <ul>
                '.$sliderkodu.'
            </ul>
            <div class="temizle"></div>
        </div>
        <div class="temizle"></div>';

        echo $sonkod;
    }

    public function kategorilervekullanicilar(){
        $kategorisorgu = $this->veritabani->prepare("SELECT * FROM kategoriler ORDER BY id ASC");
        $kategorisorgucalisti = $kategorisorgu->execute();
        $kategoribol = $kategorisorgu->fetchAll(PDO::FETCH_ASSOC);
        foreach($kategoribol as $kategorim){
            $kategori[$kategorim['id']] = $kategorim['kategoriadi'];
        }
        $this->kategoriler = $kategori;

        $kullanicilarsorgu = $this->veritabani->prepare("SELECT * FROM kullanicilar ORDER BY id ASC");
        $kullanicisorgucalistir = $kullanicilarsorgu->execute();
        $kullanicilarbol = $kullanicilarsorgu->fetchAll(PDO::FETCH_ASSOC);
        foreach($kullanicilarbol as $kullanicim){
            $kullanici[$kullanicim['id']] = $kullanicim['adsoyad'];
        }
        $this->kullanicilar = $kullanici;
    }

    public function hatasayfasi(){

        $this->title = "Sayfa Bulunamadı - ".$this->genelayarlar['siteadi'];
        $this->keywords = "";
        $this->description = "";


        include $this->genelayarlar['temayolu']."hata.php";
    }

    public function headergetir(){
        include $this->genelayarlar['temayolu']."header.php";
    }

    public function footergetir(){
        include $this->genelayarlar['temayolu']."footer.php";
    }

    public function sidebargetir(){
        include $this->genelayarlar['temayolu']."sidebar.php";
    }

    public function __destruct(){
        $this->veritabani = null;
    }
}

?>