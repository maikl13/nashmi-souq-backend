<?php

namespace App\DataTables;

use App\Models\Option;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OptionsDataTable extends DataTable
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
            ->addColumn('categories', 'admin.options.partials.categories')
            ->addColumn('action', 'admin.options.partials.action')
            ->rawColumns(['action', 'categories']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Option $model)
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
            Column::make('name')->title('الاسم'),
            Column::make('slug')->title('المعرف'),
            Column::computed('categories')->width(200)->addClass('text-center')->searchable(false)->title('الأقسام'),
            Column::computed('action')->width(60)->addClass('text-center')->searchable(false)->title('⚙'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Options_'.date('YmdHis');
    }
}
