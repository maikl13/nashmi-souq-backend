<?php

namespace App\DataTables;

use App\Models\Currency;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CurrenciesDataTable extends DataTable
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
            ->addColumn('action', 'admin.currencies.partials.action')
            ->rawColumns(['code', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Currency  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Currency $model)
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
            Column::make('name')->title('اسم العملة'),
            Column::make('code')->title('كود العملة'),
            Column::make('symbol')->title('رمز العملة'),
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
        return 'Currencies_'.date('YmdHis');
    }
}
