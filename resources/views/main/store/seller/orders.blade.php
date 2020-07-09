@extends('main.layouts.main')

@section('title', 'الطلبات')

@section('breadcrumb')
	<li class="breadcrumb-item active">الطلبات</li>
@endsection

@section('head')
	<style>
		/*#orders-table_length, #orders-table_filter { display: inline !important; }*/
		#orders-table_length { display: none !important; }
		#orders-table_filter { float: right !important; }
		#orders-table_filter input {width: 75%; text-align: right; display: inline;}
		.dataTable tfoot,.dataTable thead { display: none; }
		.dataTable td, .dataTable {padding: 0; border: none;}
		.dataTable tr:first-child {margin-top: 15px !important; display: table;}
		.dataTables_wrapper, table, tbody, tr, td {width: 100% !important; }
		/*.dataTables_wrapper * {max-width: 100% !important; }*/
		.dataTables_empty {padding: 80px 15px !important; margin-top: 15px; background: #ffffff9e;text-align: center;color: #555;}
		@media screen and (max-width: 767px) {
			.section-padding-equal-70 {padding: 0 !important;}
		}
		div.dataTables_wrapper div.dataTables_processing {
		        font-size: 0;
		    background-image: url(/assets/images/preloader.gif);
		    background-color: #fff;
		    background-size: 100%;
		    width: 50px;
		    height: 50px;
		    top: 50%;
		    left: 50%;
		    -webkit-transform: translate(-50%, -50%);
		    -ms-transform: translate(-50%, -50%);
		    transform: translate(-50%, -50%);
		    position: absolute;
		}
		td.dataTables_empty:before {
		    /*content: url(/assets/images/empty.png);*/
		    /*display: block;*/
		    content: '';
		    background: url(/assets/images/empty.png) no-repeat center;
		    background-size: contain;
		    height: 150px;
		    display: block;
		    margin-bottom: 12px;
		}
	</style>
@endsection

@section('content')
    <!--=====================================-->
    <!--=        Inner Banner Start         =-->
    <!--=====================================-->
    <section class="inner-page-banner" data-bg-image="/assets/images/banner/banner1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-area">
                        <h1>الطلبات</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li>الطلبات</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="single-product-wrap-layout1 section-padding-equal-70 bg-accent">
		<div class="container">
			<div class="row card">
				<div class="card-body" style="background: #f2f2f2;">
					<div class="e-table">
						<div class="table-responsive table-lg">

							<select class="status-filter form-control float-left border-0 form-control-sm d-inline h-auto w-auto p-1 mr-2">
								<option value="">الكل</option>
								<option value="{{ App\Models\Order::STATUS_PENDING }}">قيد المراجعة</option>
								<option value="{{ App\Models\Order::STATUS_APPROVED }}">مقبول</option>
								<option value="{{ App\Models\Order::STATUS_SOFT_REJECTED }}">مرفوض مؤقتا</option>
								<option value="{{ App\Models\Order::STATUS_HARD_REJECTED }}">مرفوض نهائيا</option>
								<option value="{{ App\Models\Order::STATUS_DELIVERABLE }}">مرحلة التجهيز</option>
								<option value="{{ App\Models\Order::STATUS_PREPARED }}">مرحلة التسليم</option>
								<option value="{{ App\Models\Order::STATUS_CANCELLED }}">ملغي</option>
								<option value="{{ App\Models\Order::STATUS_DELIVERED }}">تم التسليم</option>
							</select>
							{!! $dataTable->table(['class' => 'table'], true) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<!--DataTables js-->
	<script src="/admin-assets/plugins/Datatable/js/jquery.dataTables.js"></script>
	<script src="/admin-assets/plugins/Datatable/js/dataTables.bootstrap4.js"></script>
	<script>
		(function ($, DataTable) {
		    // Datatable global configuration
		    $.extend(true, DataTable.defaults, {
		        language: {
		            "sProcessing": "جاري البحث",
		            // "sLengthMenu": "Mostrar _MENU_ registros",
		            "sZeroRecords": "لا توجد نتائج!",
		            "sEmptyTable": "لا توجد نتائج",
		            // "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
		            // "sInfoEmpty": "لا يوجد طلبات",
		            // "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
		            "sInfoPostFix": "",
		            "sSearch": "البحث: ",
		            "sUrl": "",
		            "sInfoThousands": ",",
		            // "sLoadingRecords": "جاري التحميل",
		            "oPaginate": {
		                "sFirst": "الأولى",
		                "sLast": "الأخيرة",
		                "sNext": ">>",
		                "sPrevious": "<<"
		            },
		            // "oAria": {
		            //     "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
		            //     "sSortDescending": ": Activar para ordenar la columna de manera descendente"
		            // }
		        }
		    });

		})(jQuery, jQuery.fn.dataTable);
	</script>
	{!! $dataTable->scripts() !!}
	<script>
		$(document).on("change", '.status-filter',function(e){
			var status;
			if($(this).val() == 0){
				status = '';
			} else {
				status = $(this).val();
			}
			window.LaravelDataTables["orders-table"].column(6).search( status ).draw()
		});

	</script>
@endsection