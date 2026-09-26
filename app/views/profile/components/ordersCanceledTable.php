<div class="table-responsive">
    <table class="table table-info table-striped table-hover align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Customer</th>
                <th scope="col">Total Price</th>
                <th scope="col">Details</th>
                <th scope="col">Created At</th>
            </tr>
        </thead>
        <tbody>
            @empty($orders['canceled']['data'])
            <tr>
                <td colspan="5" class="text-center table-danger">No canceled orders found.</td>
            </tr>
            @else
            @foreach ($orders['canceled']['data'] as $canceledOrder)
            <tr>
                <th scope="row">{{ $canceledOrder['id'] }}</th>
                <td>{{ $canceledOrder['customer_name'] }}</td>
                <td>{{ $canceledOrder['total_price'] }}</td>
                <td>
                    <a href="#">See Details</a>
                </td>
                <td>{{ $canceledOrder['created_at'] }}</td>
            </tr>
            @endforeach
            @endempty
        </tbody>
    </table>
</div>

{{ preparePagination($orders['canceled']['totalPages'], $orders['canceled']['currentPage'], 'orders_canceled') }}