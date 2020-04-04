<?php

namespace App\DataTables;

use App\Models\Category;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoriesDataTable extends DataTable
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
            // ->addColumn('image', function ($record) {
            //     return '<a href="'.$record->category_image().'" data-fancybox="categories"><img src="'.$record->category_image().'" border="0" width="40" class="img-rounded" align="center"/></a>';
            // })
            ->addColumn('icon', function ($record) { return '<i class="'. $record->icon .'"></i>'; })
            ->addColumn('created_at', function($record){ return $record->created_at->diffForHumans(); })
            ->addColumn('action', 'admin.categories.partials.action')->setRowId(function ($record){return $record->id;})
            ->rawColumns(['image','icon','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
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
        return $this->builder()->parameters([
                        'responsive' => true,
                        'autoWidth' => false,
                        'pageLength' => 25,
                    ])
                    ->setTableId('data-table')
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
            Column::make('id'),
            // Column::make('image')->title('الصورة'),
            Column::make('icon')->title('الأيقونة'),
            Column::make('name')->title('الاسم'),
            Column::make('created_at')->title('تاريخ الاضافة'),
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
        return 'Categories_' . date('YmdHis');
    }
}
