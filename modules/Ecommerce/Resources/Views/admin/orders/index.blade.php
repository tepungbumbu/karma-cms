@extends('admin.layouts.master')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Orders</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ Karma\Ecommerce\Services\EcommerceHelper::formatPrice($order->total_amount) }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }}-lt">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ Karma\Ecommerce\Services\EcommerceHelper::formatDate($order->created_at) }}</td>
                            <td>
                                <a href="{{ route('admin.ecommerce.orders.show', $order->id) }}">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
