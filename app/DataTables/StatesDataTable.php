<?php

namespace App\DataTables;

use App\Models\State;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StatesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = request()->country ? $query->where('country_id', request()->country->id) : $query;

        return datatables()
            ->eloquent($query)
            ->addColumn('country', function ($record) {
                return $record->country->name;
            })
            ->addColumn('listings', function ($record) {
                return $record->listings()->count();
            })
            ->addColumn('action', 'admin.states.partials.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\State  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(State $model)
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
            Column::make('country')->title('الدولة'),
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
        return 'States_'.date('YmdHis');
    }
}
