<div style="max-width:600px;">
    <h2>Daftar Produk</h2>

    @foreach($products as $p)
        <div style="border:1px solid #ddd; padding:15px; margin-bottom:10px; border-radius:10px;">
            
            <b>{{ $p->nama_produk }}</b><br>
            Jumlah: {{ $p->jumlah }} <br>
            Lokasi: {{ $p->lokasi }}

            <br><br>

            <form method="POST" action="/apply/{{ $p->id }}">
                @csrf
                <button style="background:blue; color:white; border:none; padding:6px 10px; border-radius:5px;">
                    Ajukan Kerja Sama
                </button>
            </form>

        </div>
    @endforeach
</div>