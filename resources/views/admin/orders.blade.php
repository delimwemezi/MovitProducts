<h1>Orders</h1>

<table border="1">
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Total</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    @foreach($orders as $order)
    <tr>
        <td>{{ $order->name }}</td>
        <td>{{ $order->phone }}</td>
        <td>{{ $order->address }}</td>
        <td>{{ $order->total }}</td>
        <td>{{ $order->status }}</td>

        <td>
            <!-- Update status -->
            <form action="/admin/order/{{ $order->id }}/status" method="POST">
                @csrf
                <select name="status">
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="delivered">Delivered</option>
                </select>
                <button type="submit">Update</button>
            </form>

            <form action="/admin/order/{{ $order->id }}/cancel" method="POST">
    @csrf
    <button type="submit" onclick="return confirm('Cancel this order?')">
        Cancel
    </button>
</form>
            
        </td>
    </tr>
    @endforeach
</table>
<a href="/admin/logout" class="logout-btn">🚪 Logout</a>