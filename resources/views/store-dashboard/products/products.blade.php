@extends('store-dashboard.layouts.store-dashboard')

@section('title', 'المنتجات')

@section('head')
	<style>
		.unit {
			padding: 15px;
			background-color: #f0f5f7;
		}
		.file-drop-zone {
			background-color: white;
		}
	</style>
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item active">المنتجات</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">المنتجات</h4>
			<div class="float-left">
				<a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#add-modal">
		            <i class="fa fa-plus"></i> إضافة منتج
		        </a>
	        </div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				{!! $dataTable->table(['class' => 'table table-bordered text-center text-nowrap'], true) !!}
			</div>
		</div>
	</div>
@endsection

@section('modals')
	@include('store-dashboard.products.partials.add-modal')
@endsection

@section('scripts')
	<script> $("[type=file]").first().fileinput(fileInputOptions); </script>
	{!! $dataTable->scripts() !!}
	<script> var records = 'products'; </script>
	<script src="/admin-assets/js/ajax/store-crud.js"></script>

    <script src="/assets/plugins/select2/dependent-select2.js"></script>
    <script src="/assets/plugins/select2/model-matcher.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.categories-select2').select2({ placeholder: "القسم الرئيسي ... *" });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var CategoriesSelect2Options = { placeholder: "القسم الرئيسي ... *" };
            var subCategoriesSelect2Options = { placeholder: "القسم الفرعي ..." };
            var subCategoriesApiUrl =  '/api/categories/:parentId:/sub-categories';
            $('.sub-categories-select2').select2(subCategoriesSelect2Options);
            var cascadLoadingSubCategories = new Select2Cascade($('.category-select'), $('.sub-category-select'), subCategoriesApiUrl, CategoriesSelect2Options, subCategoriesSelect2Options);
        });

		$(document).ready(function(){
			load_options();
		});

		$(document).on('change', '.category-select, .sub-category-select', function(){
			load_options();
		});

		function load_options() {
			var subCategorySlug = $('.sub-category-select').val();
			var categorySlug = $('.category-select').val();
			var categorySlug = subCategorySlug ? subCategorySlug : categorySlug;

			$.get({
				url: '/api/categories/'+categorySlug+'/options',
				success: function(data) {
					if (data) {
						$('.options-container').show();
						$('select.option-name').html(data);
					} else {
						$('.options-container').hide();
					}
				}
			})
		}
    </script>

	<script>
		var nextUnitId = 1;
		$(document).on('click', '.next', function(e){
			e.preventDefault();
			var current = $('.step.d-block').attr('data-step');
			var next = parseInt(current)+1;
			var active = $('.step[data-step='+next+']');
			if(active.length){
				$('.step.d-block').addClass('d-none').removeClass('d-block');
				active.addClass('d-block').removeClass('d-none');
				$('.previous').addClass('d-block').removeClass('d-none');
			}
			
			if(!$('.step[data-step='+(next+1)+']').length) {
				$('.next').addClass('d-none').removeClass('d-block');
				$('.submit').addClass('d-block').removeClass('d-none');
			}
		});
		$(document).on('click', '.previous', function(e){
			e.preventDefault();
			var current = $('.step.d-block').attr('data-step');
			var previous = parseInt(current)-1;
			var active = $('.step[data-step='+previous+']');
			$('.submit').addClass('d-none').removeClass('d-block');
			$('.next').addClass('d-block').removeClass('d-none');

			if(active.length){
				$('.step.d-block').addClass('d-none').removeClass('d-block');
				active.addClass('d-block').removeClass('d-none');
			}
			if(!$('.step[data-step='+(previous-1)+']').length) {
				$('.previous').addClass('d-none').removeClass('d-block');
			}
		});
		
		$(document).ready(function(){
			// addUnit();
			$('.units .unit .remove-unit').remove();
			$('.add-option').click();
		});

		$('.add-unit').click(addUnit);
		
		$(document).on('click', '.remove-unit', function(e){
			e.preventDefault();
			$(this).parents('.unit').remove();
			if($('.unit').length == 1) 
				$('.units-note').show();
		});

		function addUnit(){
			var unit = $(".unit.d-none").clone().removeClass('d-none');
			unit.appendTo(".units");
			unit.find("[type=file]").fileinput(fileInputOptions);
			$('.units-note').hide();
			var prefix = 'units['+nextUnitId+'][';
			var postfix = ']';
			$.each(unit.find('[name]'), function (i, v) { 
				var newName = $(v).attr('name') + postfix;
				if(newName.includes('[]')) newName = newName.replace('[]', '').concat('[]');
				$(v).attr('name', prefix + newName)
			});
			optionValueName = unit.find('.add-option').attr('data-option-value-name') + postfix
			optionName = unit.find('.add-option').attr('data-option-name') + postfix
			if(optionValueName.includes('[]')) optionValueName = optionValueName.replace('[]', '').concat('[]');
			if(optionName.includes('[]')) optionName = optionName.replace('[]', '').concat('[]');
			unit.find('.add-option').attr('data-option-value-name', prefix + optionValueName);
			unit.find('.add-option').attr('data-option-name', prefix + optionName);
			nextUnitId++;

			unit.find('[data-toggle=collapse]').attr('href', '#collapse'+nextUnitId).attr('aria-controls', '#collapse'+nextUnitId);
			unit.find('.collapse').attr('id', 'collapse'+nextUnitId);
		}
		
		$(document).on('click', '.add-option', function(e){
			e.preventDefault();
			var option = $(".option.d-none").clone().removeClass('d-none');
			option.insertBefore($(this));
			option.find('.option-value').attr('name', $(this).attr('data-option-value-name'));
			option.find('.option-name').attr('name', $(this).attr('data-option-name'));
		});
	</script>
	
	<script>
		$(document).on('change', '.option-name', function(){
			var option = $(this).val(),
				optionValue = $(this).parents('.option').find('.option-value');
			optionValue.find('option:selected').removeAttr('selected');
			optionValue.find('option:selected').prop('selected', false);
			optionValue.find('option:not(:first-child)').addClass('d-none');
            if(option)
                optionValue.find('option[data-option='+option+']').removeClass('d-none');
		});
	</script>

	<script>
		$(document).on('submit', 'form.add', function(){
			var active = $('.step[data-step=1]');
			$('.step.d-block').addClass('d-none').removeClass('d-block');
			active.addClass('d-block').removeClass('d-none');

			$('.submit').addClass('d-none').removeClass('d-block');
			$('.previous').addClass('d-none').removeClass('d-block');
			$('.next').addClass('d-block').removeClass('d-none');

			$('.unit:not(".d-none")').remove();
			$('.units-note').show();
			$('.option:not(".d-none")').remove();
			$('.add-option').click();
			nextUnitId = 1;
		});
	</script>
@endsection