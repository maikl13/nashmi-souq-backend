<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        if (isset(request()->columns[4]['search']['value']) && $role_id = request()->columns[4]['search']['value']) {
            $query = $role_id == 2 ? $query->whereIn('role_id', [2, 3]) : $query->where('role_id', $role_id);
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('action', 'admin.users.action')->setRowId(function ($user) {
                return $user->id;
            })
            ->addColumn('type', function ($user) {
            return $user->role();
            })
            ->addColumn('created_at', function ($user) {
            return $user->created_at->format('d, M Y');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\User  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
            Column::make('id')->searchable(false),
            Column::make('name')->title(__('Name')),
            Column::make('email')->title(__('Email')),
            Column::make('created_at')->searchable(false)->title(__('Registered At')),
            Column::make('type', 'role_id')->searchable(false)->title(__('Roles'))->class('role'),
            Column::computed('action')->searchable(false)->title('⚙'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_'.date('YmdHis');
    }
}
