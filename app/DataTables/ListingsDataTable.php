<?php

namespace App\DataTables;

use App\Models\Listing;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ListingsDataTable extends DataTable
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
            ->addColumn('image', function ($record) {
                return '<a href="'.$record->listing_image().'" data-fancybox="categories"><img src="'.$record->listing_image().'" border="0" width="40" class="img-rounded" align="center"/></a>';
            })
            ->addColumn('type', function($record){ return $record->type(); })
            ->addColumn('category', function($record){ 
                $c = $record->category->name;
                $c .= $record->sub_category ? '<br>'. $record->sub_category->name : '';
                return $c; 
            })
            ->addColumn('area', function($record){ 
                $a = $record->state->country->name;
                $a .= '<br>'. $record->state->name;
                $a .= $record->area ? ' - '. $record->area->name : '';
                return $a; 
            })
            ->addColumn('action', 'admin.listings.partials.action')
            ->rawColumns(['action', 'category', 'area', 'image']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Listing $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Listing $model)
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
            Column::make('image')->title('الصورة'),
            Column::make('type')->title('النوع'),
            Column::make('title')->title('العنوان'),
            Column::make('category')->title('القسم'),
            Column::make('area')->title('المنطقة'),
            Column::make('views')->title('المشاهدات'),
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
        return 'Listings_' . date('YmdHis');
    }
}
