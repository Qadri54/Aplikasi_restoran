<!-- Halaman untuk debugging pembayaran -->

<form action="{{ route('payment.cekstatus') }}" method="post">
    @csrf
    <input type="hidden" value="ORDER-5e3b0a50-ab24-411e-a11a-04376e9d3665" name="order_id">
    <button type="submit">cek</button>
</form>