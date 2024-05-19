<?php

namespace App\Utilities;

use Illuminate\Http\Request;

trait DataUtility
{
    public function getDetailData(Request $request, $modelClass, $start, $length, $search, $searchColumns = [], $format)
    {
        $query = $modelClass::query();

        if ($search && count($searchColumns) > 0) {
            $query->where(function ($query) use ($search, $searchColumns) {
                foreach ($searchColumns as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        }

        $totalRecords = $modelClass::count();

        $filteredRecords = $query->count();

        $data = $query->skip($start)->take($length)->get();

        $formattedData = [];
        foreach ($data as $item) {
            $formattedData[] = $this->formatData($item, $format);
        }

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $formattedData,
        ];

        return $response;
    }

    public function getData(Request $request, $modelClass, $start, $length, $search, $searchColumns = [], $format)
    {
        $query = $modelClass::query();

        if ($search && count($searchColumns) > 0) {
            $query->where(function ($query) use ($search, $searchColumns) {
                foreach ($searchColumns as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        }

        $data = $query->skip($start)->take($length)->get();

        $formattedData = [];
        foreach ($data as $item) {
            $formattedData[] = $this->formatData($item, $format);
        }

        $total = $modelClass::count();

        $response = [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $formattedData,
        ];

        return $response;
    }

    public function getDataWithOrder(Request $request, $modelClass, $start, $length, $search, $searchColumns = [], $format, $orderSet)
    {
        $query = $modelClass::query();

        if ($search && count($searchColumns) > 0) {
            $query->where(function ($query) use ($search, $searchColumns) {
                foreach ($searchColumns as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        }

        $query->orderBy($orderSet, 'asc');

        $data = $query->skip($start)->take($length)->get();

        $formattedData = [];
        foreach ($data as $item) {
            $formattedData[] = $this->formatData($item, $format);
        }

        $total = $modelClass::count();

        $response = [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $formattedData,
        ];

        return $response;
    }

    public function getDataWithCondition(Request $request, $modelClass, $condition, $start, $length, $search, $searchColumns = [], $format, $orderSet)
    {
        $query = $modelClass::where($condition);

        if ($search && count($searchColumns) > 0) {
            $query->where(function ($query) use ($search, $searchColumns) {
                foreach ($searchColumns as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        }

        $query->orderBy($orderSet, 'asc');

        $data = $query->skip($start)->take($length)->get();

        $formattedData = [];
        foreach ($data as $item) {
            $formattedData[] = $this->formatData($item, $format);
        }

        $total = $modelClass::where($condition)->count();

        $response = [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $formattedData,
        ];

        return $response;
    }

    public function getDataByYear(Request $request, $modelClass, $start, $length, $search, $searchColumns = [], $format, $selectedYear, $yearColumn)
    {
        $query = $modelClass::query();

        // Filter data berdasarkan tahun anggaran yang dipilih
        if ($selectedYear && $yearColumn) {
            $query->whereYear($yearColumn, $selectedYear);
        }
        /* if ($selectedYear) {
            $query->whereYear('start_date', $selectedYear);
        } */

        if ($search && count($searchColumns) > 0) {
            $query->where(function ($query) use ($search, $searchColumns) {
                foreach ($searchColumns as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        }

        $data = $query->skip($start)->take($length)->get();

        $formattedData = [];
        foreach ($data as $item) {
            $formattedData[] = $this->formatData($item, $format);
        }

        $total = $query->count();

        $response = [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $formattedData,
        ];

        return $response;
    }

    public function formatData($item, $format)
    {
        $formattedData = [];

        foreach ($format as $field => $formatFunction) {
            if (is_callable($formatFunction)) {
                $formattedData[$field] = $formatFunction($item);
            } else {
                $formattedData[$field] = $item->{$formatFunction};
            }
        }

        return $formattedData;
    }

    public function generateActionButtons($item, $editRoute, $deleteRoute)
    {
        return '
            <div class="btn-group mb-3 btn-group-sm" role="group">
                <a href="'.route($editRoute, $item->id).'" class="btn btn-sm btn-primary" data-nprogress><i class="fa fa-edit"></i></a>
                <form onsubmit="handleFormDelete(event)" action="'.route($deleteRoute, $item->id).'" method="POST" class="d-inline">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button class="btn btn-sm btn-danger" type="submit" data-nprogress><i class="fa fa-trash"></i></button>
                </form>
                
            </div>
        ';
    }

    public function complexButtons($item, $deleteRoute, $enkripRoute)
    {
        return '
            <div class="btn-group mb-3 btn-group-sm" role="group">
                <form onsubmit="handleFormDelete(event)" action="'.route($deleteRoute, $item->id).'" method="POST" class="d-inline">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button class="btn btn-flat btn-sm btn-danger" type="submit" data-nprogress><b class="fa fa-trash"></b></button>
                </form>
                <form action="'.route($enkripRoute, $item->id).'" method="POST" class="d-inline">
                    '.csrf_field().'
                    <button class="btn btn-flat btn-sm btn-primary" type="submit" data-nprogress><b class="fa fa-lock"></b></button>
                </form>
            </div>
        ';
    }

    public function delNEmailButtons($item, $deleteRoute, $emailRoute)
    {
        return '
            <div class="btn-group mb-3 btn-group-sm" role="group">
                <form onsubmit="handleFormDelete(event)" action="'.route($deleteRoute, $item->id).'" method="POST" class="d-inline">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button class="btn btn-flat btn-sm btn-danger" type="submit" data-nprogress><b class="fa fa-trash"></b></button>
                </form>
                <form action="'.route($emailRoute, $item->id).'" method="POST" class="d-inline">
                    '.csrf_field().'
                    <button class="btn btn-flat btn-sm btn-primary" type="submit" data-nprogress><b class="fa fa-envelope"></b></button>
                </form>
            </div>
        ';
    }

    public function simpleButtons($item, $deleteRoute)
    {
        return '
            <div class="btn-group mb-3 btn-group-sm" role="group">
                <form onsubmit="handleFormDelete(event)" action="'.route($deleteRoute, $item->id).'" method="POST" class="d-inline">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button class="btn btn-flat btn-sm btn-danger" type="submit" data-nprogress><b class="fa fa-trash"></b></button>
                </form>
            </div>
        ';
    }

    public function generateButtons($item, $deleteRoute, $exportRoute)
    {
        return '
            <div class="btn-group mb-3 btn-group-sm" role="group">
                <form onsubmit="handleFormDelete(event)" action="'.route($deleteRoute, $item->id).'" method="POST" class="d-inline">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button class="btn btn-flat btn-sm btn-danger" type="submit" data-nprogress>
                        <b class="fa fa-trash"></b>
                    </button>
                </form>
                &nbsp;
                <button class="btn btn-flat btn-sm btn-primary" onclick="window.location.href=\''.route($exportRoute, $item->id).'\'">
                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#feffff" d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm57.1 120H305c7.7 0 13.4 7.1 11.7 14.7l-38 168c-1.2 5.5-6.1 9.3-11.7 9.3h-38c-5.5 0-10.3-3.8-11.6-9.1-25.8-103.5-20.8-81.2-25.6-110.5h-.5c-1.1 14.3-2.4 17.4-25.6 110.5-1.3 5.3-6.1 9.1-11.6 9.1H117c-5.6 0-10.5-3.9-11.7-9.4l-37.8-168c-1.7-7.5 4-14.6 11.7-14.6h24.5c5.7 0 10.7 4 11.8 9.7 15.6 78 20.1 109.5 21 122.2 1.6-10.2 7.3-32.7 29.4-122.7 1.3-5.4 6.1-9.1 11.7-9.1h29.1c5.6 0 10.4 3.8 11.7 9.2 24 100.4 28.8 124 29.6 129.4-.2-11.2-2.6-17.8 21.6-129.2 1-5.6 5.9-9.5 11.5-9.5zM384 121.9v6.1H256V0h6.1c6.4 0 12.5 2.5 17 7l97.9 98c4.5 4.5 7 10.6 7 16.9z"/></svg>
                </button>
            </div>
        ';
    }

    public function buttonNoDel($item, $exportRoute)
    {
        return '
            <div class="btn-group role="group">
                <button class="btn btn-flat btn-sm btn-danger" onclick="window.location.href=\''.route($exportRoute, $item->id).'\'">
                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#feffff" d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm57.1 120H305c7.7 0 13.4 7.1 11.7 14.7l-38 168c-1.2 5.5-6.1 9.3-11.7 9.3h-38c-5.5 0-10.3-3.8-11.6-9.1-25.8-103.5-20.8-81.2-25.6-110.5h-.5c-1.1 14.3-2.4 17.4-25.6 110.5-1.3 5.3-6.1 9.1-11.6 9.1H117c-5.6 0-10.5-3.9-11.7-9.4l-37.8-168c-1.7-7.5 4-14.6 11.7-14.6h24.5c5.7 0 10.7 4 11.8 9.7 15.6 78 20.1 109.5 21 122.2 1.6-10.2 7.3-32.7 29.4-122.7 1.3-5.4 6.1-9.1 11.7-9.1h29.1c5.6 0 10.4 3.8 11.7 9.2 24 100.4 28.8 124 29.6 129.4-.2-11.2-2.6-17.8 21.6-129.2 1-5.6 5.9-9.5 11.5-9.5zM384 121.9v6.1H256V0h6.1c6.4 0 12.5 2.5 17 7l97.9 98c4.5 4.5 7 10.6 7 16.9z"/></svg>
                </button>
            </div>
        ';
    }

    public function moveButtons($item, $moveRoute)
    {
        return '
            <div class="btn-group mb-3 btn-group-sm" role="group">
                <form onsubmit="handleFormMove(event)" action="'.route($moveRoute, $item->id).'" method="POST" class="d-inline">
                    '.csrf_field().'
                    <button class="btn btn-flat btn-sm btn-primary" type="submit" data-nprogress><b class="fa fa-arrow-right"></b> Move</button>
                </form>
            </div>
        ';
    }

}
