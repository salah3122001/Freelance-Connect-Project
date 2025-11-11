


<form action="{{ route('orders.store', $service->id) }}" method="POST">
    @csrf

    <label>Title</label>
    <input type="text" name="title" value="{{ $service->title }}" readonly>

    <label>Amount</label>
    <input type="number" name="amount" value="{{ $service->price }}" required>

    <label>Description (optional)</label>
    <textarea name="description"></textarea>

    <button type="submit">Create Order</button>
</form>
