<?php

namespace App\DataTables;

use App\Models\Country;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CountriesDataTable extends DataTable
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
            ->addColumn('code', function ($record) {
                return '<img src="https://flagcdn.com/w40/'.$record->code.'.png"  width="24"/> <span class="text-uppercase">'.$record->code.'</span>';
                // return '<img src="https://www.countryflags.io/'.$record->code.'/flat/24.png" /> <span class="text-uppercase">'.$record->code.'</span>';
            })
            ->addColumn('currency', function ($record) {
                return $record->currency->name;
            })
            ->addColumn('listings', function ($record) {
                return $record->listings()->count();
            })
            ->addColumn('action', 'admin.countries.partials.action')
            ->rawColumns(['code', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Country  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Country $model)
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
            Column::make('code')->title('كود الدولة'),
            Column::make('name')->title('الاسم'),
            Column::make('slug')->title('المعرف'),
            Column::make('currency')->title('العملة'),
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
        return 'Countries_'.date('YmdHis');
    }
}
