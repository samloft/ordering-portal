@extends('layouts.master')

@section('title', 'Activity Logs')
@section('sub-title', 'View logs from the CMS')

@section('content')
    <div class="flex flex-col">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div
                class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                        <tr class="bg-white">
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                {{ $log->causer->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                    <span
                                        class="badge-action badge-{{ $log->description }}">
                                        {{ $log->description }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                {{ str_replace('App\Models\\', '', $log->subject_type) }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                {{ $log->created_at }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium text-indigo-600 hover:text-indigo-900">
                                <log-view :log="{{ json_encode($log->properties, true) }}"></log-view>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $logs->appends($_GET)->links('layout.pagination') }}
    </div>
@endsection
