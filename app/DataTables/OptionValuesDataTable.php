<?php

namespace App\DataTables;

use App\Models\OptionValue;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OptionValuesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = request()->option ? $query->where('option_id', request()->option->id) : $query;

        return datatables()
            ->eloquent($query)
            ->addColumn('option', function ($record) {
                return $record->option->name;
            })
            ->addColumn('preview', 'admin.option_values.partials.preview')
            ->addColumn('action', 'admin.option_values.partials.action')
            ->rawColumns(['preview', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OptionValue $model)
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
            Column::computed('preview')->width(100)->addClass('text-center')->searchable(false)->title('معاينة'),
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
        return 'OptionValues_'.date('YmdHis');
    }
}
