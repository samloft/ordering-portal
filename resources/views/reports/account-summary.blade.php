@extends('layout.master-pdf')

@section('report.title', 'Account Summary')

@section('content')
    <p class="table-heading">{{ __('Outstanding Invoices & Credit Notes') }}</p>

    <div class="small-print">
        {{ __('The table below lists all unpaid invoices and credit notes, there is a delay of up to 24 hours in the accuracy of our data, please accept our apologies if you have paid an invoice that is listed below. If you have any queries about the data shown below please contact us.') }}
    </div>

    <table>
        <tr>
            <th>{{ __('Invoice No.') }}</th>
            <th>{{ __('Order No.') }}</th>
            <th>{{ __('Invoice Date') }}</th>
            <th>{{ __('Due Date') }}</th>
            <th>{{ __('Amount') }}</th>
        </tr>
        @foreach($invoice_lines as $invoice_line)
            <tr>
                <td>{{ $invoice_line->item_no }}</td>
                <td>{{ $invoice_line->reference }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice_line->dated)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice_line->due_date)->format('d-m-Y') }}</td>
                <td class="text-right">{{ $invoice_line->unall_curr_amount }}</td>
            </tr>
        @endforeach
    </table>

    <p class="table-heading">{{ __('Aged Credit') }}</p>

    <div class="small-print">
        {{ __('The table below gives a breakdown of outstanding balances on your account; please note there is delay of up to 24 hours in the accuracy of our data. If you have recently made a payment please allow up to 24 hours for the totals below to be effected. If you have any queries about the data shown below please contact us.') }}
    </div>

    <table>
        <tr>
            <th>{{ __('Total Outstanding') }}</th>
            <th>{{ __('Not Due') }}</th>
            <th>{{ __('Overdue up to 30 days') }}</th>
            <th>{{ __('Overdue up to 60 days') }}</th>
            <th>{{ __('Overdue over 60 days') }}</th>
        </tr>
        <tr>
            <td class="text-right">{{ isset($summary_lines['Total Outstanding']) ? $summary_lines['Total Outstanding'] : 0 }}</td>
            <td class="text-right">{{ isset($summary_lines['Not due']) ? $summary_lines['Not due'] : 0 }}</td>
            <td class="text-right">{{ isset($summary_lines['Overdue up to 30 day']) ? $summary_lines['Overdue up to 30 day'] : 0 }}</td>
            <td class="text-right">{{ isset($summary_lines['Overdue up to 60 days']) ? $summary_lines['Overdue up to 60 days'] : 0 }}</td>
            <td class="text-right">{{ isset($summary_lines['Over 60 days overdue']) ? $summary_lines['Over 60 days overdue'] : 0 }}</td>
        </tr>
    </table>
@endsection