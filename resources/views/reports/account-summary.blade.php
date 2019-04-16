@extends('reports.master-pdf')

@section('report.title', 'Account Summary')

@section('content')
    <p style="text-align: center; font-weight: 900;">{{ __('Outstanding Invoices & Credit Notes') }}</p>

    <div style="font-size: 10px; margin-bottom: 5px;">
        {{ __('The table below lists all unpaid invoices and credit notes, there is a delay of up to 24 hours in the accuracy of our data, please accept our apologies if you have paid an invoice that is listed below. If you have any queries about the data shown below please contact us.') }}
    </div>

    <table border="1" style="width: 100%; border-collapse: collapse;">
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
                <td style="text-align: right;">{{ $invoice_line->unall_curr_amount }}</td>
            </tr>
        @endforeach
    </table>
@endsection