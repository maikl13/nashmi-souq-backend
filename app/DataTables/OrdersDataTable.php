<?php

namespace App\DataTables;

use App\Models\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        if(isset(request()->columns[6]['search']['value']) && $status = request()->columns[6]['search']['value']){
            $query = $query->where('orders.status', $status);
        }
        return datatables()
            ->eloquent($query)
            ->addColumn('order_data', 'main.store.partials.order-row')->setRowId(function ($order) {return $order->id;})
            ->rawColumns(['order_data']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        return $model->newQuery()->where('store_id', auth()->user()->id)
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('listings', 'orders.listing_id', '=', 'listings.id')
            ->select('orders.*', 'users.name as users.name', 'listings.title as listings.title');

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()->parameters([
                        'responsive' => true,
                        'autoWidth' => false,
                        'pageLength' => 10,
                    ])
                    ->setTableId('orders-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->orderBy(0, 'desc')
                    ->buttons(
                        Button::make('delete'),
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->hidden('true'),
            Column::make('uid')->hidden('true'),
            Column::make('users.name')->hidden('true'),
            Column::make('listings.title')->hidden('true'),
            Column::make('buyer_name')->title('اسم المشتري')->hidden('true'),
            Column::make('order_data')->title('الطلب'),
            Column::make('status')->hidden('true'),
            // Column::make('created_at')->searchable(false)->title('تاريخ الطلب'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Orders_' . date('YmdHis');
    }
}
