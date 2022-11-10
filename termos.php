<? include("base.php"); ?>
<!DOCTYPE html>
<html>
<head lang="pt">
	<? include("includes/head.php"); ?>
</head>
<body>
    <div class="page-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div id="the-terms" class="box-typical box-typical-padding text-center">
                        <img class="img-fluid maxw150" src="img/avatar-sign.png"/>
                        <h2><?=_("Termos de utilização");?></h2>
                        <div class="row">
                            <div class="col-1"></div>
                            <section class="box-typical box-typical-dashboard panel panel-default scrollable col-10 p0">
                                <div id="termosecondicoes" class="box-typical-body panel-body text-justify">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin maximus magna eu ante porta auctor. Integer id nulla consectetur leo dignissim feugiat at ut sapien. Nulla suscipit efficitur nulla sit amet tempor. Quisque aliquam convallis nibh nec mollis. Ut pharetra, dui eget commodo bibendum, erat justo molestie sapien, in lobortis nisi turpis at nisl. Sed porta scelerisque eros vel venenatis. Mauris luctus justo dignissim velit sollicitudin, at tincidunt dui mattis. Etiam sit amet felis at nisi dignissim sodales. Fusce dui augue, dapibus vitae libero vel, ornare placerat leo. Cras a mi ut diam blandit congue. Nullam bibendum enim sed lacinia pretium. Vivamus nec felis libero. Proin ut interdum augue. Aenean sit amet accumsan orci, id iaculis tortor. Aenean sed risus nisl.</p>
                                    <p>Mauris auctor quis arcu quis efficitur. Integer tempus mauris vel egestas condimentum. Mauris convallis vitae risus sed porttitor. Nulla aliquet, ante id porta dictum, velit ligula laoreet lacus, sed posuere nulla dolor in lacus. Donec tempor at nisi non lacinia. Etiam volutpat lacus ac gravida malesuada. Vivamus augue urna, ultricies ut dignissim quis, pharetra pellentesque lorem.</p>
                                    <p>Nam pellentesque et turpis ac venenatis. Ut nibh metus, feugiat ut justo eu, faucibus congue justo. Phasellus rutrum elit vulputate magna eleifend luctus vitae non libero. Suspendisse potenti. Suspendisse imperdiet odio nisi, vel facilisis eros scelerisque vitae. Integer id dolor vitae augue tincidunt fringilla. Suspendisse sed cursus massa, sit amet interdum ante. Vivamus egestas est eu dictum eleifend. Quisque eu urna est. Quisque cursus, nisl ut euismod tempor, enim nibh convallis odio, eget commodo leo tellus ut ex.</p>
                                    <p>Praesent malesuada ipsum sed gravida finibus. Maecenas eu rutrum sapien, eget volutpat magna. Vivamus turpis erat, euismod et facilisis sed, aliquet id dui. Vestibulum sed purus quam. Nulla facilisi. Phasellus commodo tellus eu elementum interdum. Aliquam tristique, ipsum quis tempor finibus, orci elit tincidunt erat, sit amet bibendum velit augue sit amet massa. Etiam dignissim est a magna ultricies rhoncus. Donec egestas urna quis eros malesuada mollis. Praesent porta mi vel condimentum interdum. Fusce fermentum ante sapien, vitae dictum felis sagittis quis. Donec molestie enim in neque efficitur, sed hendrerit dolor aliquam. Quisque luctus et eros in faucibus. Fusce dictum diam in arcu malesuada dignissim. Phasellus ac nulla vel nunc pellentesque luctus eget at ex. Donec sit amet leo ultricies, commodo enim sed, mattis ipsum.</p>
                                    <p>Integer aliquet eleifend mauris et vehicula. Nullam eu vulputate sapien, nec posuere augue. Proin pharetra dui nibh, eu gravida mauris tempor ac. Curabitur blandit, risus faucibus vehicula tincidunt, augue felis ultrices diam, sit amet pellentesque augue metus at elit. Ut fringilla lobortis congue. Nulla blandit, nibh vehicula ultrices blandit, sem ante consectetur sem, ac condimentum tellus risus eget massa. Donec vitae turpis id odio viverra feugiat. Nunc eget erat nec enim efficitur ultrices rhoncus id ipsum. In hac habitasse platea dictumst. Fusce vitae urna tortor.</p>
                                </div>
                            </section>
                        </div>
                        <button type="button" id="acceptBtn" class="btn btn-rounded btn-inline"><?="Li e compreeendi os termos de uso";?></button>
                        <a href="?lg=1" class="btn btn-rounded btn-inline btn-danger"><?="Voltar";?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? include("includes/footer.php"); ?>
    <script>
        $(function(){
            var alturatotal = window.innerHeight;
            var alturabox = $("#the-terms").height();
            $("#the-terms").css("margin-top",(((alturatotal - alturabox) / 2) - 30));

            $("#acceptBtn").on("click",function(e){
                e.preventDefault();

                $.post("remote",{"cmd":"acceptTerms"},function(data){
                    if(data == 1){
                        window.location.reload();
                    }
                });
            });
        });
    </script>
    <?
        $sys->fs_clean_temp();
    ?>
</body>
</html>
