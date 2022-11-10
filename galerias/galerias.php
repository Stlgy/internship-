<?
	include("../../base.php");
	require_once("classe.php");
	$caminho = explode('/',__DIR__);
	$pasta = array_pop($caminho);
	$obj = new $pasta;
?>
<!DOCTYPE html>
<html>
<head lang="pt">
	<? include(MODPATH."includes/head.php"); ?>
</head>
<body class="with-side-menu control-panel control-panel-compact">

	<? include(MODPATH."includes/header.php"); ?>

	<? include(MODPATH."includes/side_menu.php"); ?>
	<?
		if (count($_POST) > 0) $obj->gravar();
		$registo = isset($_GET["id"]) ? $obj->obter((int)$_GET["id"],false) : array();
		//nos atributos abaixo deve-se colocar os elementos do class_utils para se poder ler as mensagens
	?>
	<form id="formregisto" method="post" data-msg="<?= $obj->mysqli_last_op_msg; ?>" data-msg-flag="<?= $obj->mysqli_last_op_flag; ?>">
		<div class="page-content">
		    <div class="container-fluid">
		        <div class="row">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xxl-9 col-lg-12 col-xl-8 col-md-8">
									<div class="box-typical box-typical-padding">
										<h5 class="m-t-md with-border"><?= _("Descrição"); ?></h5>
										<section class="tabs-section">
											<div class="tabs-section-nav tabs-section-nav-inline">
												<ul class="nav" role="tablist">
													<?
														$k = 1;
														foreach(IDIOMAS as $codigo => $idioma) {
															$cl = ($k == 1) ? 'active' : '';
															$k++;
													?>
													<li class="nav-item">
														<a class="nav-link <?= $cl; ?>" href="#tabs-<?= $codigo; ?>" role="tab" data-toggle="tab" aria-expanded="false"><?= $idioma[IDIOMA]; ?></a>
													</li>
													<?
														}
													?>
												</ul>
											</div>
											<!--.tabs-section-nav-->
											<div class="tab-content">
												<?
													$k = 1;
													foreach(IDIOMAS as $codigo => $idioma) {
														$cl = ($k == 1) ? 'in active show' : '';
														$k++;
												?>
												<div role="tabpanel" class="tab-pane fade <?= $cl; ?>" id="tabs-<?= $codigo; ?>" aria-expanded="false">
													<div class="form-group row">
														<label class="col-sm-2 form-control-label"><?= _("Título"); ?></label>
														<div class="col-sm-10">
															<p class="form-control-static"><input type="text" class="form-control" value="<?= @$registo["titulo"][$codigo]; ?>" id="titulo_<?= $codigo; ?>" name="titulo_<?= $codigo; ?>" placeholder="<?= _("Título"); ?>" required="required" aria-required="true"></p>
														</div>
													</div>
													<div class="clearfix"></div>
												</div>
												<? } ?>
											</div>
											<!--.tab-content-->
										</section>
									</div><!--.box-typical-->
									<!-- GALERIA -->
									<?
										if (isset($_GET["id"])) {
		    								$pasta = ltrim($obj->tabela,"_")."/".$_GET["id"];
		    							} else {
		    								$pasta = "temp/".uniqid();
		    							}
										$htm->gerar_galeria_fotos(800,600,$pasta,1);
									?>
									<? include(MODPATH."includes/seo_section.php"); ?>
								</div>
								<div class="col-xxl-3 col-lg-12 col-xl-4 col-md-4">
									<div class="box-typical box-typical-padding">
										<h5 class="m-t-md with-border"><?= _("Opções"); ?></h5>
										<div class="form-group">
											<div class="checkbox-toggle -large">
											<?
												$ch = (!isset($registo["flag_activo"]) || (isset($registo["flag_activo"]) && $registo["flag_activo"] == 1)) ? 'checked="checked"' : '';
											?>
												<input type="checkbox" name="flag_activo" id="flag_activo" value="1" <?= $ch; ?>>
												<label for="flag_activo"><?= _("Publicado(a)"); ?></label>
											</div>
										</div>
									</div><!--.box-typical-->
									<?
										$htm->gerar_single_image(500,500,null,$obj->tabela,@$_GET["id"]);
									?>
								</div>
							</div>
						</div>
		        </div><!--.row-->
				<div class="btSave">
					<button class="btn btn-rounded btn-success btn-lg"><i class="fa fa-save"></i></button>
				</div>
		    </div><!--.container-fluid-->
		</div><!--.page-content-->
	</form>
    <?
        include(MODPATH."includes/footer.php");
        include(MODPATH."includes/modais.php");
    ?>

    <!-- geral -->
    <script src="js/lib/jquery-tag-editor/jquery.caret.min.js"></script>
	<script src="js/lib/jquery-tag-editor/jquery.tag-editor.min.js"></script>
    <script src="js/lib/select2/select2.full.min.js"></script>
    <!-- só se houver galeria -->
    <script src="js/lib/match-height/jquery.matchHeight.min.js"></script>
    <script src="js/lib/html-sortable/html.sortable.js"></script>
    <script>
		$(function() {
			$('#formregisto').validate({
				rules : {
					seo_url : {
						required: true,
						remote: {
					    	url: "remote.php",
					        type: "post",
					        data: {
					          cmd : 'vrfSeoUrl',
					          tabela : '<?= $obj->tabela; ?>',
					          id : '<?= isset($_GET["id"]) ? $_GET["id"] : 0; ?>'
					        }
					      }
				    }
				},
				ignore: "",
				showErrors: function(event,validator) {
					this.defaultShowErrors();
					var erros = {};
					$('.error').each(function() {
						var isto = $(this),
							painel = isto.parents('.tab-pane').attr('id');
						erros[painel] = (erros[painel] == undefined) ? 1 : erros[painel] + 1;
					});
					$.each(erros,function(ind, val) {
						var parentTab = $('.tab-pane#'+ind).parents('.tabs-section'),
							tab = parentTab.find('.nav-link[href="#'+ind+'"]'),
							error_html = '<div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="font-icon font-icon-warning"></i>Aviso: Preencha os campos em falta!</div>';
						if (val > 1) {
							if (parentTab.hasClass("tabs-section-nav-icons")) {
								tab.append('<span class="label label-pill label-danger">'+(val - 1)+'</span>');
							}
							else {
								tab_text = tab.text().split(' ')
								tab.html(tab_text[0] + ' <span class="label label-pill label-danger">'+(val - 1)+'</span>');
							}
						}

						if (parentTab.parent().find('.alert.alert-danger').length == 0) $(parentTab).before(error_html);
					});
				},
				highlight: function(element, errorClass, validClass) {
					$(element).closest('.form-group').addClass(errorClass).removeClass(validClass);
				},
				unhighlight: function(element, errorClass, validClass) {
					var parentTab = $(element).parents('.tabs-section').find('.tabs-section-nav');

					$(element).closest('.form-group').addClass(validClass).removeClass(errorClass);
					var cena = $(element).parents('.tabs-section').find('.nav-link[href="#'+$(element).parents('.tab-pane').attr('id')+'"]');

					if (parentTab.hasClass("tabs-section-nav-icons")) {
						cena.find('.label').remove();
					}
					else {
						texto = cena.text().split(' ');
						cena.html(texto[0]);
					}
				},
                errorPlacement: function( error, element ) {
                    if ($(element).closest('.input-group').length) {
                        error.insertAfter( element.parent() );
                    }
                    else {
                        error.insertAfter( element);
                    }
                },
				messages: {
        			seo_url: "<?= _("Este endereço já existe. Por favor escolhar outro"); ?>"
    			}
			});
		});
	</script>
</body>
</html>
