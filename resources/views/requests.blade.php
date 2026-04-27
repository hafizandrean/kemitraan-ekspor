<div style="max-width:600px;">
    <h2>Permintaan Kerja Sama</h2>

    @foreach($requests as $r)
        <div style="border:1px solid #ddd; padding:15px; margin-bottom:15px; border-radius:10px; background:#f9f9f9;">
            
            <b>Produk:</b> {{ $r->product->nama_produk }} <br>
            <b>Eksportir:</b> {{ $r->eksportir->name }} <br>

            <b>Status:</b>
            @if($r->status == 'pending')
                <span style="color: orange;">Pending</span>
            @elseif($r->status == 'accepted')
                <span style="color: green;">Accepted</span>
            @else
                <span style="color: red;">Rejected</span>
            @endif

            <br><br>

            <form method="POST" action="/requests/{{ $r->id }}/accept" style="display:inline;">
                @csrf
                <button style="background:green; color:white; border:none; padding:6px 10px; border-radius:5px;">
                    Terima
                </button>
            </form>

            <form method="POST" action="/requests/{{ $r->id }}/reject" style="display:inline;">
                @csrf
                <button style="background:red; color:white; border:none; padding:6px 10px; border-radius:5px;">
                    Tolak
                </button>
            </form>

        </div>
    @endforeach
</div>