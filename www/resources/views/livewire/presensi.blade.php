<div>
    <div class="container mx-auto max-w-sm">
        <div class="card p-6 mt-3">
            {{-- Success Message --}}
            @if (!empty($successMessage))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ $successMessage }}
                </div>
            @endif

            @if ($jadwals === null)
                <div class="p-6 bg-yellow-50 border border-yellow-400 text-yellow-800 rounded-lg text-center">
                    <h2 class="text-xl font-bold mb-2">Jadwal Belum Tersedia</h2>
                    <p class="text-sm">Anda belum memiliki jadwal kantor/shift yang aktif. Silakan hubungi admin untuk mendaftarkan jadwal Anda.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">Informasi Pegawai</h2>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <p><strong>Nama Pegawai:</strong> {{ Auth::user()->name }}</p>
                            <p><strong>Kantor: </strong> {{ $jadwals->kantor->name }}</p>
                            <p><strong>Shift:</strong> ({{ $jadwals->shift->name }}) {{ $jadwals->shift->start_time }} - {{ $jadwals->shift->end_time }} WIB</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <h4 class="text-l font-bold mb-2">Jam Masuk</h4>
                                <p class="text-lg font-semibold">{{ $kehadiran_model ? $kehadiran_model->start_time : '-' }} WIB</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <h4 class="text-l font-bold mb-2">Jam Keluar</h4>
                                <p class="text-lg font-semibold">{{ $kehadiran_model && $kehadiran_model->end_time ? $kehadiran_model->end_time : '-' }} WIB</p>
                            </div>
                        </div>

                    </div>
                    <div>
                        <h2 class="text-2xl font-bold mb-2">Presensi</h2>
                        <div class="card overflow-hidden mb-4 border border-gray-200">
                                        <form id="presensiForm" class="row g-3" wire:submit.prevent="store">
                                            <div wire:ignore>
                                                <div id="map" class="h-96"></div>
                                            </div>
                                            <input type="hidden" wire:model="latitude">
                                            <input type="hidden" wire:model="longitude">
                                        </form>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <button type="button" onclick="tagLocation()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Tag Location</button>
                            @if($insideRadius)
                                <button type="submit" form="presensiForm" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    {{ $kehadiran_model ? 'Submit Jam Pulang' : 'Submit Jam Masuk' }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if ($jadwals !== null)
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        let map;
        let lat;
        let lng;
        const kantor = [{{ $jadwals->kantor->latitude }}, {{ $jadwals->kantor->longitude }}];
        const radius = {{ $jadwals->kantor->radius }};
        let component;
        let marker;
        function initializePresensiLivewire() {
            component = @this;
            map = L.map('map').setView([{{ $jadwals->kantor->latitude }}, {{ $jadwals->kantor->longitude }}], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            let marker;
            const circle = L.circle(kantor, {
                color:'red',
                fillColor:'#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);
        }

        document.addEventListener('livewire:load', initializePresensiLivewire);
        document.addEventListener('livewire:initialized', initializePresensiLivewire);

        function tagLocation(){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    lat = position.coords.latitude;
                    lng = position.coords.longitude;

                    if (marker) {
                        map.removeLayer(marker);
                    }

                    marker = L.marker([lat, lng]).addTo(map);
                    map.setView([lat, lng], 13);

                    if (isWithinRadius(lat, lng, kantor, radius)) {
                        component.set('insideRadius', true);
                        component.set('latitude', lat);
                        component.set('longitude', lng);
                    } else {
                        alert('Anda di luar radius');
                    }

                })
            } else {
                alert('Tidak bisa get location');
            }
        }

        function isWithinRadius(lat, lng, center, radius) {
            let distance = map.distance([lat, lng], center);
            return distance <= radius;
        }

    </script>
    @endif

</div>
