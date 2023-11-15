<?php

namespace App\DataTables;

use App\Models\Promotion;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PromotionsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()->eloquent($query)
            ->addColumn('image', function ($record) {
                return '<a href="'.$record->promotion_image().'" data-fancybox="promotions"><img src="'.$record->promotion_image().'" border="0" width="160" class="img-rounded" align="center"/></a>';
            })
            ->addColumn('url', function ($record) {
                return $record->url;
            })
            ->addColumn('created_at', function ($record) {
                return $record->created_at->diffForHumans();
            })
            ->addColumn('action', 'store-dashboard.promotions.partials.action')
            ->rawColumns(['image', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Promotion $model)
    {
        return $model->newQuery();
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
            Column::make('url')->title('الرابط'),
            Column::make('created_at')->title('تاريخ الاضافة'),
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
        return 'Promotions_'.date('YmdHis');
    }
}
