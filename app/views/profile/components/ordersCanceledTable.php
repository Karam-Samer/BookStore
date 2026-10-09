<div class="table-responsive">
    <table class="table mainTable table-striped table-hover align-middle">
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
                <td colspan="5" class="text-center emptyRow">No canceled orders found.</td>
            </tr>
            @else
            @foreach ($orders['canceled']['data'] as $canceledOrder)
            <tr>
                <th scope="row">{{ $canceledOrder['id'] }}</th>
                <td>{{ $canceledOrder['customer_name'] }}</td>
                <td>{{ $canceledOrder['total_price'] }}</td>
                <td>
                    <span class="badge mainBadge" style="cursor: pointer;" onclick="getCartItems(`{{ $canceledOrder['id'] }}`, 'showOrder');">Show Details</span>
                </td>
                <td>{{ $canceledOrder['created_at'] }}</td>
            </tr>
            @endforeach
            @endempty
        </tbody>
    </table>
</div>

{{ preparePagination($orders['canceled']['totalPages'], $orders['canceled']['currentPage'], 'orders_canceled') }}