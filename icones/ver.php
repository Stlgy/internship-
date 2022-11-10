<?
	include("../../base.php");
	$registo = "icones";
?>
<!DOCTYPE html>
<html>
<head lang="pt">
	<? include(MODPATH."includes/head.php"); ?>
</head>
<body class="with-side-menu control-panel control-panel-compact">

	<? include(MODPATH."includes/header.php"); ?>

	<? include(MODPATH."includes/side_menu.php"); ?>

	<div class="page-content">
	    <div class="container-fluid">
	    	<div class="row">
	    		<div class="col-xl-12">
	    			<h2>Modulo para Icones e Texto</h2>
	    		</div>
	    	</div>
	        <div class="row">
	            <div class="col-xl-12">
	            	<section class="box-typical" id="tabela">
						<div class="box-typical-body">
	            			<div id="toolbar">
								<div class="bootstrap-table-header"><?= _('Registos'); ?></div>
								<button id="remove" class="btn btn-danger remove" disabled>
									<i class="font-icon font-icon-close-2"></i> <?= _('Apagar'); ?>
								</button>
								<a href="<?= dirname($_SERVER["REQUEST_URI"]); ?>/<?= $registo; ?>.php" class="btn btn-success addReg"><?= _('Adicionar'); ?></a>
							</div>
							<div class="table-responsive">
								<table id="table"
									   class="table table-striped"
									   data-toolbar="#toolbar"
									   data-search="true"
									   data-show-refresh="true"
									   data-show-toggle="true"
									   data-show-columns="true"
									   data-show-export="true"
									   data-minimum-count-columns="2"
									   data-show-pagination-switch="false"
									   data-pagination="false"
									   data-detail-view="false"
									   data-id-field="id"
									   data-page-list="[10, 25, 50, 100, 200]"
									   data-show-footer="false"
									   <?/*data-cookie="true"
	               					   data-cookie-id-table="saveId"
	               					   data-cookie-expire="2h"*/?>
									   data-locale="pt-PT"
									   data-url="<?= dirname($_SERVER["REQUEST_URI"]); ?>/remote.php?op=listar"
									   >
								</table>
							</div>
	           			</div><!--.box-typical-body-->
					</section>
	            </div><!--.col-->
	        </div><!--.row-->

	    </div><!--.container-fluid-->
	</div><!--.page-content-->

    <?
        include(MODPATH."includes/footer.php");
    ?>
    <script type="text/javascript">
        var $table,
            $remove,
            selections,
            $edit_url,
            $remote_delete_url,
            $remote_delete_op;

    	$(document).ready(function(){
			$table = $('#table'),
            $remove = $('#remove'),
            selections = [],
            $edit_url = "<?= dirname($_SERVER["REQUEST_URI"]); ?>/<?= $registo; ?>.php?id={{ID}}",
            $remote_delete_url = $table.data("url").replace("?op=listar","");
            $remote_delete_op = 'apagar';

			function refresca() {
				$table.bootstrapTable('refresh');
			}

			window.operateEvents = {
				'click .regOn': function (e, value, row, index) {
					$.post($remote_delete_url, { op: 'toggle', id: row.id, estado: '1'}, function(msg) {
					    if(msg == '1') refresca();
					});
				},
				'click .regOff': function (e, value, row, index) {
					$.post($remote_delete_url, { op: 'toggle', id: row.id, estado: '0'}, function(msg) {
					    if(msg == '1') refresca();
					});
				},
				'click .edit': function (e, value, row, index) {
					window.location.href = $edit_url.replace("{{ID}}",row.id);
				},
				'click .remove': function (e, value, row, index) {
                    apagarRegisto([row.id]);
				}
			}

			function operateFormatter(value, row, index) {
				var result = [];
				if(row.flag_activo == '1') {
					result.push('<a class="regOff" href="javascript:void(0)" title="Desativar">');
					result.push('<i class="glyphicon glyphicon-eye-open"></i>');
					result.push('</a>');
				} else {
					result.push('<a class="regOn" href="javascript:void(0)" title="Ativar">');
					result.push('<i class="glyphicon glyphicon-eye-close"></i>');
					result.push('</a>');
				}
				result.push('<a class="edit" href="javascript:void(0)" title="Editar">');
				result.push('<i class="glyphicon glyphicon-pencil"></i>');
				result.push('</a>');
				result.push('<a class="remove" href="javascript:void(0)" title="Apagar">');
				result.push('<i class="glyphicon glyphicon-remove"></i>');
				result.push('</a>');
				return result.join('');
			}

			function getIdSelections() {
				return $.map($table.bootstrapTable('getSelections'), function (row) {
					return row.id
				});
			}


			$table.bootstrapTable({
				iconsPrefix: 'font-icon',
				icons: {
					paginationSwitchDown:'font-icon-arrow-square-down',
					paginationSwitchUp: 'font-icon-arrow-square-down up',
					refresh: 'font-icon-refresh',
					toggle: 'font-icon-list-square',
					columns: 'font-icon-list-rotate',
					export: 'font-icon-download',
					detailOpen: 'font-icon-plus',
					detailClose: 'font-icon-minus-1'
				},
				reorderableRows: true,
				useRowAttrFunc: true,
				onReorderRow: function(ord) {
					//devolve um array ordenado dos registos
					var ids = [];
					$.each(ord,function(ind,val) {
						ids.push(val.id);
					});
					$.post($remote_delete_url,{op: 'reorder', ids: ids},function(data) {
						if (data == 0) console.log('A reordenação falhou.');
					});
				},
				paginationPreText: '<i class="font-icon font-icon-arrow-left"></i>',
				paginationNextText: '<i class="font-icon font-icon-arrow-right"></i>',
				columns: [
					[
						{
							field: 'state',
							checkbox: true,
							align: 'center',
							valign: 'middle'
						}, {
							title: 'Id',
							field: 'id',
							align: 'center',
							valign: 'middle',
							visible: false,
							sortable: false,
							width:'5%'
						}, {
							title: 'Título',
							field: 'titulo',
							align: 'center',
							valign: 'middle',
							visible: true,
							sortable: false
						}, {
							field: 'accoes',
							title: 'Operações',
							align: 'center',
							valign: 'middle',
							events: operateEvents,
							formatter: operateFormatter
						}
					]
				]
			});

			$table.on('check.bs.table uncheck.bs.table ' +
				'check-all.bs.table uncheck-all.bs.table', function () {
				$remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
				// save your data, here just save the current page
				selections = getIdSelections();
				// push or splice the selections if you want to save all data selections
			});

			$remove.click(function () {
                var ids = getIdSelections();
                apagarRegisto(ids);
			});

			$('#toolbar').find('select').change(function () {
				$table.bootstrapTable('refreshOptions', {
					exportDataType: $(this).val()
				});
			});
		});
    </script>
</body>
</html>
