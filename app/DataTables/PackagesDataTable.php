<?php

namespace App\DataTables;

use App\Models\Package;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PackagesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        if (isset(request()->columns[7]['search']['value']) && $status = request()->columns[7]['search']['value']) {
            $query = $query->where('packages.status', $status);
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('package_data', 'store.partials.package-row')->setRowId(function ($package) {
            return $package->id;
            })
            ->rawColumns(['package_data']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\package  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(package $model)
    {
        return $model->newQuery()->where('packages.store_id', auth()->user()->id)
            ->leftJoin('orders', 'orders.id', '=', 'packages.order_id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('package_items', 'package_items.package_id', '=', 'packages.id')
            ->selectRaw('`packages`.*, `users`.`name` as `users.name`, `orders`.`buyer_name` as `orders.buyer_name`, GROUP_CONCAT(`package_items`.`title`) as `package_items.title`')
            ->groupBy('packages.id');
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
            Column::make('id')->hidden('true'),
            Column::make('uid')->hidden('true'),
            Column::make('users.name')->hidden('true'),
            Column::make('package_items.title')->hidden('true'),
            Column::make('package_items.title')->hidden('true'),
            Column::make('orders.buyer_name')->title('اسم المشتري')->hidden('true'),
            Column::make('package_data')->title('الطلب'),
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
        return 'packages_'.date('YmdHis');
    }
}
