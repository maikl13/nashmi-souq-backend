<?php

namespace App\DataTables;

use App\Models\Subscription;
use App\Models\Country;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubscriptionsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('period', function($record){
                return $record->period;
            })
            ->addColumn('start', function($record){
                return $record->start->format('Y-m-d');
            })
            ->addColumn('end', function($record){
                return $record->end->format('Y-m-d');
            })
            ->addColumn('type', function($record){
                return $record->type;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Subscription $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Subscription $model)
    {
        return auth()->user()->subscriptions();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()->parameters([ 'responsive' => true, 'autoWidth' => false, "bLengthChange" => false, 'pageLength' => 25 ])->setTableId('data-table')->columns($this->getColumns())->minifiedAjax()->dom('lfrtip')->orderBy(0, 'desc');
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
            Column::make('period')->title('المدة'),
            Column::make('start')->title('من'),
            Column::make('end')->title('الى'),
            Column::make('type')->title('نوع الاشتراك'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Subscriptions_' . date('YmdHis');
    }
}
