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
            @empty($orders['done']['data'])
            <tr>
                <td colspan="5" class="text-center emptyRow">No done orders found.</td>
            </tr>
            @else
            @foreach ($orders['done']['data'] as $doneOrder)
            <tr>
                <th scope="row">{{ $doneOrder['id'] }}</th>
                <td>{{ $doneOrder['customer_name'] }}</td>
                <td>{{ $doneOrder['total_price'] }}</td>
                <td>
                    <span class="badge mainBadge" style="cursor: pointer;" onclick="getCartItems(`{{ $doneOrder['id'] }}`, 'showOrder');">Show Details</span>
                </td>
                <td>{{ $doneOrder['created_at'] }}</td>
            </tr>
            @endforeach
            @endempty
        </tbody>
    </table>
</div>

{{ preparePagination($orders['done']['totalPages'], $orders['done']['currentPage'], 'orders_done') }}