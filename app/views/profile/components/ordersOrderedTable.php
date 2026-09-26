

<div class="table-responsive">
    <table class="table table-info table-striped table-hover align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Customer</th>
                <th scope="col">Total Price</th>
                <th scope="col">Details</th>
                <th scope="col">Created At</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            @empty($orders['ordered']['data'])
            <tr>
                <td colspan="6" class="text-center table-danger">No ordered orders found.</td>
            </tr>
            @else
            @foreach ($orders['ordered']['data'] as $orderedOrder)
            <tr>
                <th scope="row">{{ $orderedOrder['id'] }}</th>
                <td>{{ $orderedOrder['customer_name'] }}</td>
                <td>{{ $orderedOrder['total_price'] }}</td>
                <td>
                    <a href="#">See Details</a>
                </td>
                <td>{{ $orderedOrder['created_at'] }}</td>
                <td>
                    <button class="btn btn-sm btn-danger me-2">Cancel</button>
                    <button class="btn btn-sm btn-success">Done</button>
                </td>
            </tr>
            @endforeach
            @endempty
        </tbody>
    </table>
</div>

{{ preparePagination($orders['ordered']['totalPages'], $orders['ordered']['currentPage'], 'orders_ordered') }}