<?
	include("../../base.php"); 
	require_once("classe.php");
	$obj = new blogs();
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
		if (count($_POST) > 0) $obj->SEOgravar();
		$registo = $obj->SEOobter();
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
										<h5 class="m-t-md with-border">Configurações de Módulo</h5>
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
													<? } ?>
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
														<label class="col-sm-2 form-control-label">Futuras Configs</label>
													</div>
													<div class="clearfix"></div>
												</div>
												<? } ?>
												<!--.tab-pane-->
											</div>
											<!--.tab-content-->
										</section>
									</div><!--.box-typical-->
								</div>
							</div>
							<? //include(MODPATH."includes/seo_section.php"); ?>
						</div>
		        </div><!--.row-->
				<div class="btSave">
					<button class="btn btn-rounded btn-success btn-lg" type="submit"><i class="fa fa-save"></i></button>
				</div>
		    </div><!--.container-fluid-->
		</div><!--.page-content-->
	</form>
    <?
        include(MODPATH."includes/footer.php");
        include(MODPATH."includes/modais.php");
    ?>
    <!-- geral -->
    <script src="js/lib/bootstrap-maxlength/bootstrap-maxlength.js"></script>
	<script src="js/lib/bootstrap-maxlength/bootstrap-maxlength-init.js"></script>
    <script src="js/lib/jquery-tag-editor/jquery.caret.min.js"></script>
	<script src="js/lib/jquery-tag-editor/jquery.tag-editor.min.js"></script>
	<script src="js/lib/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="js/lib/select2/select2.full.min.js"></script>
	<script>
		$(function() {

		});
	</script>
</body>
</html>
