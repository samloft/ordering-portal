@extends('layout.master-pdf')

@section('report.title', 'Account Summary')

@section('content')
    <div>
        <div>
            <b>Account Code:</b> {{ Auth::user()->customer->code }}
        </div>
        <div>
            <b>Customer:</b> {{ Auth::user()->customer->name }}
        </div>
    </div>

    <div style="margin-top: 5px; margin-bottom: 5px;"><b>Outstanding Invoices & Credit Notes</b></div>

    <div class="small-print">
        The table below lists all unpaid invoices and credit notes, there is a delay of up to 24 hours in the accuracy
        of our data, please accept our apologies if you have paid an invoice that is listed below. If you have any
        queries about the data shown below please contact us.
    </div>

    <table>
        <thead>
        <tr>
            <th>Invoice No.</th>
            <th>Order No.</th>
            <th>Invoice Date</th>
            <th>Due Date</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach($lines as $line)
            <tr>
                <td>{{ $line['item_no'] }}</td>
                <td>{{ $line['reference'] }}</td>
                <td>{{ $line['dated'] }}</td>
                <td>{{ $line['due_date'] }}</td>
                <td class="text-right">{{ $line['amount'] }}</td>
            </tr>
        </tbody>
        @endforeach
    </table>

    <div style="margin-top: 5px; margin-bottom: 5px;"><b>Aged Credit</b></div>

    <div class="small-print">
        The table below gives a breakdown of outstanding balances on your account; please note there is delay of up to
        24 hours in the accuracy of our data. If you have recently made a payment please allow up to 24 hours for the
        totals below to be effected. If you have any queries about the data shown below please contact us.
    </div>

    <table>
        <thead>
        <tr>
            <th>Total Outstanding</th>
            <th>Not Due</th>
            <th>Overdue up to 30 days</th>
            <th>Overdue up to 60 days</th>
            <th>Overdue over 60 days</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-right">{{ $summary_line[0]['total-outstanding'] ?? 0 }}</td>
            <td class="text-right">{{ $summary_line[0]['not-due'] ?? 0 }}</td>
            <td class="text-right">{{ $summary_line[0]['overdue-up-to-30-day'] ?? 0 }}</td>
            <td class="text-right">{{ $summary_line[0]['overdue-up-to-60-days'] ?? 0 }}</td>
            <td class="text-right">{{ $summary_line[0]['over-60-days-overdue'] ?? 0 }}</td>
        </tr>
        </tbody>
    </table>
@endsection
