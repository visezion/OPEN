<?php

namespace Workdo\Churchly\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\ChurchMember;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ChurchMemberDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dataTable = new EloquentDataTable($query);

        $dataTable->addIndexColumn()
            ->editColumn('member_id', function ($member) {
                $url = route('members.show', \Crypt::encrypt($member->id));
                return '<a href="' . $url . '" class="btn btn-outline-primary">#' . $member->member_id . '</a>';
            })
            ->editColumn('name', fn($member) => e($member->name ?? '-'))
            ->editColumn('email', fn($member) => e($member->email ?? '-'))
            ->editColumn('branch_id', fn($member) => $member->branch_name ?? '-')

            // ✅ Departments
            ->addColumn('departments', function ($member) {
                return $member->departments->pluck('name')->implode(', ') ?: '-';
            })

            // ✅ Designations from pivot
           ->addColumn('designations', function ($member) {
                return $member->departments
                    ->map(function ($d) {
                        if ($d->pivot && $d->pivot->designation_id) {
                            return \Workdo\Churchly\Entities\ChurchDesignation::find($d->pivot->designation_id)?->name;
                        }
                        return null;
                    })
                    ->filter()
                    ->implode(', ') ?: '-';
            })


            ->editColumn('church_doj', fn($member) => $member->church_doj ? $member->church_doj->format('d M Y') : '-');

        // ✅ Actions
        if (
            \Laratrust::hasPermission('church_member show') ||
            \Laratrust::hasPermission('church_member edit') ||
            \Laratrust::hasPermission('church_member delete')
        ) {
            $dataTable->addColumn('action', fn ($member) =>
                view('churchly::members.button', compact('member'))->render()
            );
        }

        return $dataTable->rawColumns([
            'member_id',
            'name',
            'email',
            'branch_id',
            'departments',
            'designations',
            'church_doj',
            'action'
        ]);
    }

    public function query(ChurchMember $model, Request $request): QueryBuilder
    {
        $query = $model->newQuery()
            ->where('church_members.workspace', getActiveWorkSpace())
            ->leftJoin('church_branches', 'church_members.branch_id', '=', 'church_branches.id')
            ->select('church_members.*', 'church_branches.name as branch_name')
            ->with('departments'); // ✅ eager load

        if (!Auth::user()->can('church_member manage')) {
            $query->where('church_members.created_by', creatorId());
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('churchmembers-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->dom("
                <'dataTable-top'<'dataTable-dropdown'l><'dataTable-search'f>>
                <'dataTable-container'tr>
                <'dataTable-bottom'ip>
            ")
            ->buttons(['print', 'csv', 'excel', 'reset', 'reload']);
    }

    public function getColumns(): array
    {
        $columns = [
            Column::make('DT_RowIndex')->title(__('No'))->searchable(false)->orderable(false),
            Column::make('member_id')->title(__('Member ID')),
            Column::make('name')->title(__('Name')),
            Column::make('email')->title(__('Email')),
            Column::make('branch_id')->title(__('Branch')),
            Column::make('departments')->title(__('Departments'))->orderable(false)->searchable(false),
            Column::make('designations')->title(__('Designations'))->orderable(false)->searchable(false),
            Column::make('church_doj')->title(__('Date of Joining')),
        ];

        if (
            \Laratrust::hasPermission('church_member show') ||
            \Laratrust::hasPermission('church_member edit') ||
            \Laratrust::hasPermission('church_member delete')
        ) {
            $columns[] = Column::computed('action')
                ->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center');
        }

        return $columns;
    }

    protected function filename(): string
    {
        return 'ChurchMembers_' . now()->format('YmdHis');
    }
}
