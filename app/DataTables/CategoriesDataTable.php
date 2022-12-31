<?php

namespace App\DataTables;

use App\Models\Category;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoriesDataTable extends DataTable
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
            // ->addColumn('image', function ($record) {
            //     return '<a href="'.$record->category_image().'" data-fancybox="categories"><img src="'.$record->category_image().'" border="0" width="40" class="img-rounded" align="center"/></a>';
            // })
            ->addColumn('icon', function ($record) {
            return '<i class="'.$record->icon.'"></i>';
            })
            ->addColumn('created_at', function ($record) {
            return $record->created_at->diffForHumans();
            })
            ->addColumn('listings', function ($record) {
            return $record->listings()->count();
            })
            ->addColumn('action', 'admin.categories.partials.action')->setRowId(function ($record) {
            return $record->id;
            })
            ->rawColumns(['image', 'icon', 'action'])
            ->setRowClass(function ($record) {
                return $record->category_id ? 'child' : '';
            })->setRowAttr([
                'data-parent' => function ($record) {
                    return $record->category_id ? $record->parent->id : '';
                },
                'data-level' => function ($record) {
                    return $record->level();
                },
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Category  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
    {
        return $model->newQuery()->orderBy('tree');
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
            Column::make('id')->orderable(false),
            // Column::make('image')->title('الصورة'),
            Column::make('icon')->title('الأيقونة')->orderable(false),
            Column::make('name')->title('الاسم')->orderable(false),
            Column::make('created_at')->title('تاريخ الاضافة')->orderable(false),
            Column::make('listings')->title('عدد الاعلانات')->orderable(false),
            Column::computed('action')->orderable(false)
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
        return 'Categories_'.date('YmdHis');
    }
}
