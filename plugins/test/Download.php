<?php
require __DIR__."/../../core/All_One.php";
require __DIR__."/../../config/prodect.php";
require_once __DIR__."/controller/WebService.php";
Security::checkAccess("test");


?>
<html>
<head>
    <?php getALLcss(); ?>
    <script>
        $(document).ready(function () {
            $("#download").click(function () {
                $(this).slideUp();
                getTotal();
            });
        });

        function progressbar() {
                var timer = setInterval(function () {
                    getcount();
                    var count = parseInt($("#current").html());
                    var tot =  parseInt($("#total_con").html());
                    var pro = parseInt((count/tot)*100);
                    console.log(count);
                    console.log(tot);
                    console.log(pro);
                    $("#prr").css("width",pro+"%");
                    if (pro==100){
                        clearInterval(timer);
                    }
                },1000);

        }

        function getcount() {
            $.ajax({
                type:"get",
                url:"controller/counter.php",
                success:function (msg) {
                    $("#current").html(msg);
                }
            });
        }

        function getTotal() {
            $.ajax({
                type:"get",
                url:"controller/updateFileld.php?action=total",
                success:function (msg) {
                    $("#total_con").html(msg.toString());

                    setTimeout(function () {
                        progressbar();
                        $.ajax({
                            type:"post",
                            url:"controller/ajaxMan.php?action=down",
                            success:function (msg) {
                                if (msg.trim()=="ok"){
                                    $(".progress-bar").removeClass("bg-info").addClass("bg-success");
                                }
                            }
                        });
                    },1000);

                }
            });
        }

    </script>
</head>
<body>
<div class="col-md-12">
    <div class="card" style="margin-top: 1%">
        <h5 class="card-header"><?= Languege::_("Download")?></h5>
        <div class="card-body">
            <div class="col-md-12">
                <div class="col-md-1" style="float: right">
                    <span id="current">0</span>
                    /
                    <span id="total_con">0</span>
                </div>
                <div class="progress">
                    <div id="prr" class="progress-bar bg-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="col-md-12">
                <button style="float: right" class="btn btn-info" id="download"><?= Languege::_("Download")?></button>
            </div>
        </div>
    </div>

</div>
</body>
</html>
