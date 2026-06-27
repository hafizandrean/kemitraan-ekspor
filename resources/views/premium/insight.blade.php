<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-exportani-text tracking-tight">Insight Pasar Ekspor</h2>
            <p class="mt-1 text-sm text-exportani-secondaryText">Analisis tren harga dan pergerakan komoditas ekspor secara real-time.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
        <div class="rounded-2xl border border-exportani-border bg-white p-6 shadow-sm mb-8">
            <p class="text-sm text-exportani-primary font-semibold">Fitur Premium</p>
            <h3 class="text-xl font-bold text-exportani-text mt-2">Harga Komoditas Ekspor Terkini</h3>
            
            <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($commodities as $commodity)
                    <div class="rounded-2xl border border-exportani-border bg-exportani-background p-5 flex flex-col justify-between hover:bg-white hover:shadow-sm transition duration-150">
                        <div>
                            <p class="text-xs text-exportani-secondaryText font-semibold uppercase tracking-wider">{{ $commodity->name }}</p>
                            @if($commodity->latestPrice)
                                <p class="text-xl font-extrabold text-exportani-text mt-1 flex items-center gap-2">
                                    Rp {{ number_format($commodity->latestPrice->price, 0, ',', '.') }} 
                                    <span class="text-xs text-exportani-secondaryText font-normal">/ {{ $commodity->unit }}</span>
                                    
                                    @if(isset($commodity->trend_direction) && $commodity->trend_direction !== 'neutral')
                                        <span class="inline-flex items-center rounded-full px-1.5 py-0.5 text-xs font-medium {{ $commodity->trend_direction === 'up' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            @if($commodity->trend_direction === 'up')
                                                <svg class="mr-1 h-3 w-3 flex-shrink-0 self-center text-green-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd" />
                                                </svg>
                                                +{{ $commodity->trend_percentage }}%
                                            @else
                                                <svg class="mr-1 h-3 w-3 flex-shrink-0 self-center text-red-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $commodity->trend_percentage }}%
                                            @endif
                                        </span>
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Terakhir update: {{ $commodity->latestPrice->recorded_date->format('d M Y') }}</p>
                            @else
                                <p class="text-sm text-gray-500 mt-2">Belum ada data harga</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada data komoditas.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-exportani-border bg-white p-6 shadow-sm">
            <h3 class="text-xl font-bold text-exportani-text mb-4">Tren Harga Historis</h3>
            <div class="w-full">
                <canvas id="priceChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Tambahkan library Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('priceChart').getContext('2d');
            const chartData = @json($chartData);
            
            // Mengumpulkan dan mengurutkan semua tanggal untuk sumbu X
            let allLabels = [];
            chartData.forEach(dataset => {
                dataset.data.forEach(point => {
                    if (!allLabels.includes(point.x)) {
                        allLabels.push(point.x);
                    }
                });
            });
            allLabels.sort();

            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: allLabels,
                    // Kita modifikasi sedikit dataset-nya di sini
                    datasets: chartData.map(dataset => ({
                        ...dataset,
                        pointRadius: 4,          // Memunculkan titik di setiap data
                        pointHoverRadius: 6,     // Titik membesar saat di-hover
                        hitRadius: 15,           // MEMPERBESAR AREA SENSITIF KURSOR (Ini kunci agar gampang di-hover!)
                        tension: 0.2             // Sedikit melengkungkan garis agar terlihat lebih natural
                    }))
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false, // Menampilkan garis vertikal dan tooltip walau kursor tidak pas di titiknya
                    },
                    plugins: {
                        // Mengaktifkan dan mempercantik tampilan Tooltip
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(17, 24, 39, 0.9)', // Warna gelap modern
                            padding: 12,
                            usePointStyle: true,
                            callbacks: {
                                // Format angka otomatis menjadi mata uang Rupiah
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { 
                                            style: 'currency', 
                                            currency: 'IDR', 
                                            minimumFractionDigits: 0 
                                        }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        },
                        legend: {
                            display: true,
                            position: 'top',
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Tanggal Pencatatan'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Harga'
                            },
                            beginAtZero: false // Diubah ke false agar grafik tidak terlalu 'gepeng' jika harga mencapai jutaan
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
