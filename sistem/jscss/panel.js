$(function(){
    function yaziyiguncelle(){
        var yaziformu = $("yaziformu");
        var actional = "http://"+window.location.hostname+$("#yaziformu").attr('action');
        var yaziguncelle = $.ajax({
            method: "POST",
            url: actional,
            data: new FormData(yaziformu),
            cache: false,
            processData: false,
            contentType: false,
            success: function (gelenveri){
                console.log(gelenveri);
            },
            error: function(gelenveri){
                console.log("error");
                console.log(gelenveri);
                alert("Yazı otomatik kaydedilirken bir sorun oluştu!");
            }
        });
    }
    $("#fotografyukle").submit(function(e){
        e.preventDefault();
        var actional = "http://"+window.location.hostname+$("#fotografyukle").attr('action');
        var fotografyukle = $.ajax({
            method: "POST",
            url: actional,
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            success: function (gelenveri) {
                $(".fotograflinki").append(gelenveri+"<br>");
                console.log(gelenveri);
            },
            error: function(gelenveri){
                console.log("error");
                console.log(gelenveri);
                alert("Fotoğraf yüklenirken bir sorun oluştu!!");
            }
        });
    });
    var yaziformvarmi = $("#yaziformu");
    if(yaziformvarmi != null){setInterval(yaziyiguncelle,180000)}
});