<div class="table-responsive">
    <table class="table mainTable table-striped table-hover align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Customer</th>
                <th scope="col">Total Price</th>
                <th scope="col">Details</th>
                <th scope="col">Created At</th>
                @auth("admin")
                <th scope="col">Options</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @empty($orders['ordered']['data'])
            <tr>
                <td colspan="6" class="text-center emptyRow">No ordered orders found.</td>
            </tr>
            @else
            @foreach ($orders['ordered']['data'] as $orderedOrder)
            <tr data-order-id="{{ $orderedOrder['id'] }}">
                <th scope="row">{{ $orderedOrder['id'] }}</th>
                <td>{{ $orderedOrder['customer_name'] }}</td>
                <td>{{ $orderedOrder['total_price'] }}</td>
                <td>
                    <span class="badge mainBadge" style="cursor: pointer;" onclick="getCartItems(`{{ $orderedOrder['id'] }}`, 'showOrder');">Show Details</span>
                </td>
                <td>{{ $orderedOrder['created_at'] }}</td>
                @auth("admin")
                <td class="buttons">
                    <button class="btn secondaryButton btn-sm mb-1 mb-xl-0 me-xl-2" onclick="cancelOrder(`{{ $orderedOrder['id'] }}`)">Cancel</button>
                    <button class="btn mainButton btn-sm" onclick="doneOrder(`{{ $orderedOrder['id'] }}`)">Done</button>
                </td>
                @endauth
            </tr>
            @endforeach
            @endempty
        </tbody>
    </table>
</div>

{{ preparePagination($orders['ordered']['totalPages'], $orders['ordered']['currentPage'], 'orders_ordered') }}




@auth("admin")
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Cancel Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="mb-3">
                        <label for="cancelReason" class="form-label">Cancel Reason</label>
                        <textarea class="form-control" id="cancelReason" rows="3"></textarea>
                    </div>
                    <button class="btn secondaryButton w-100 mt-2">Cancel Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth