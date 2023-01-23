<?php

namespace App\DataTables;

use App\Models\Transaction;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TransactionsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        if (isset(request()->columns[6]['search']['value']) && is_int((int) request()->columns[6]['search']['value'])) {
            $status = request()->columns[6]['search']['value'];
            $query = $status == Transaction::STATUS_PROCESSED ? $query->where('status', Transaction::STATUS_PROCESSED) : $query->where('status', Transaction::STATUS_PENDING);
        }

        if (isset(request()->columns[3]['search']['value']) && $type = request()->columns[3]['search']['value']) {
            $query = $query->where('type', $type);
        }

        if (isset(request()->columns[5]['search']['value']) && $payment_method = request()->columns[5]['search']['value']) {
            $query = $query->where('payment_method', $payment_method);
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('user', function ($record) {
                return $record->user->name;
            })
            ->addColumn('type', function ($record) {
                return $record->type();
            })
            ->addColumn('currency', function ($record) {
                return $record->currency->name;
            })
            ->addColumn('payment_method', function ($record) {
                return $record->get_payment_method();
            })
            ->addColumn('status', function ($record) {
                return $record->status();
            })
            ->addColumn('created_at', function ($record) {
                return $record->created_at->format('d-m-Y h:i:s');
            })
            ->addColumn('action', 'admin.transactions.partials.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Transaction  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaction $model)
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
            Column::make('uid')->title('كود العملية'),
            Column::make('user')->title('العضو'),
            Column::make('type')->title('النوع'),
            Column::make('amount')->title('القيمة'),
            Column::make('currency')->title('العملة'),
            Column::make('payment_method')->title('وسيلة الدفع'),
            Column::make('status')->title('الحالة'),
            Column::make('created_at')->title('تاريخ العملية'),
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
        return 'Transactions_'.date('YmdHis');
    }
}
