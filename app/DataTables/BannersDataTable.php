<?php

namespace App\DataTables;

use App\Models\Banner;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BannersDataTable extends DataTable
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
            ->addColumn('type', function($record){ return $record->type(); })
            ->addColumn('image', function ($record) {
                return '<a href="'.$record->category_image().'" data-fancybox="bs"><img src="'.$record->category_image().'" border="0" width="160" class="img-rounded" align="center"/></a>';
            })
            ->addColumn('url', function($record){ return $record->url; })
            ->addColumn('period', function($record){ return $record->period; })
            ->addColumn('remainder', function($record){ 
                $h = $record->expires_at->diffInHours();
                $days = floor($h / 24);
                $hours = floor($h % 24);
                return $record->expired() ? "منتهي" : "<span dir='rtl'>".$days." يوم و ".$hours." ساعة</span>";
            })
            ->addColumn('created_at', function($record){ return $record->created_at->diffForHumans(); })
            ->addColumn('action', 'admin.banners.partials.action')
            ->rawColumns(['image','remainder','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Banner $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Banner $model)
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
            Column::make('type')->title('النوع'),
            Column::make('image')->title('الصورة'),
            Column::make('url')->title('الرابط'),
            Column::make('period')->title('المدة'),
            Column::make('created_at')->title('تاريخ الاضافة'),
            Column::make('remainder')->title('سينتهي خلال'),
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
        return 'Banners_' . date('YmdHis');
    }
}
