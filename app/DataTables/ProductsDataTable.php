<?php

namespace App\DataTables;

use App\Models\Product;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('image', function ($record) {
                return '<a href="'.$record->product_image().'?v='.uid().'" data-fancybox="categories"><img src="'.$record->product_image(['size' => 'xs']).'?v='.uid().'" border="0" width="200" class="img-rounded" align="center"/></a>';
            })
            ->addColumn('category', function ($record) {
                $c = $record->category->name;
                $c .= $record->sub_category ? '<br>'.$record->sub_category->name : '';

                return $c;
            })
            ->addColumn('options', 'store-dashboard.products.partials.options')
            ->addColumn('action', 'store-dashboard.products.partials.action')
            ->rawColumns(['options', 'action', 'category', 'image']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Product  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
    {
        return $model->newQuery(false);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()->parameters(['responsive' => true, 'autoWidth' => false, 'bLengthChange' => false, 'pageLength' => 25])->setTableId('data-table')->columns($this->getColumns())->minifiedAjax()->dom('lfrtip')->orderBy(0, 'desc');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('image')->title('الصورة'),
            Column::make('title')->title('العنوان'),
            Column::make('price')->title('السعر'),
            Column::make('category')->title('القسم'),
            Column::make('options')->title('صفات المنتج'),
            Column::make('views')->title('👁️'),
            Column::computed('action')
                  ->width(60)
                  ->addClass('text-center')
                  ->searchable(false)->title('⚙'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Products_'.date('YmdHis');
    }
}
