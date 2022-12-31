<?php

namespace App\DataTables;

use App\Models\Brand;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BrandsDataTable extends DataTable
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
            ->addColumn('categories', 'admin.brands.partials.categories')
            ->addColumn('action', 'admin.brands.partials.action')->setRowId(function ($record) {
                return $record->id;
            })
            ->rawColumns(['action', 'categories']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Brand  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Brand $model)
    {
        if ($this->brand) {
            return $this->brand->children();
        }

        return $model->newQuery()->whereNull('brand_id');
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
        $columns = [];
        $columns[] = Column::make('id')->orderable(false);
        $columns[] = Column::make('name')->title('الاسم');
        $columns[] = Column::make('slug')->title('المعرف');
        if (! $this->brand) {
            $columns[] = Column::computed('categories')->width(200)->addClass('text-center')->searchable(false)->title('الأقسام');
        }
        $columns[] = Column::computed('action')->width(60)->addClass('text-center')->searchable(false)->title('⚙');

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Brands_'.date('YmdHis');
    }
}
