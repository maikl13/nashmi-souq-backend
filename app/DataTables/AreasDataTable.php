<?php

namespace App\DataTables;

use App\Models\Area;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AreasDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = request()->state ? $query->where('state_id', request()->state->id) : $query;

        return datatables()
            ->eloquent($query)
            ->addColumn('state', function ($record) {
                return $record->state->name;
            })
            ->addColumn('listings', function ($record) {
                return $record->listings()->count();
            })
            ->addColumn('action', 'admin.areas.partials.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Area  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Area $model)
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
            Column::make('state')->title('المدينة'),
            Column::make('listings')->title('عدد الاعلانات'),
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
        return 'Areas_'.date('YmdHis');
    }
}
