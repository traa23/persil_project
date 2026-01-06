<?php
namespace App\Helpers;

class IconHelper
{
    /**
     * Get FontAwesome icon based on jenis penggunaan
     */
    public static function getIconByJenisPenggunaan($jenisPenggunaan)
    {
        if (! $jenisPenggunaan) {
            return 'fas fa-question-circle';
        }

        $nama = strtolower($jenisPenggunaan);

        $iconMap = [
            // Tempat tinggal/Rumah
            'rumah'               => 'fas fa-home',
            'rumah tinggal'       => 'fas fa-home',
            'perumahan'           => 'fas fa-home',
            'kos'                 => 'fas fa-building',

            // Tempat usaha
            'toko'                => 'fas fa-shop',
            'ruko'                => 'fas fa-shop',
            'warung'              => 'fas fa-utensils',
            'restoran'            => 'fas fa-utensils',
            'kafe'                => 'fas fa-coffee',
            'cafe'                => 'fas fa-coffee',
            'kantor'              => 'fas fa-briefcase',
            'pabrik'              => 'fas fa-industry',
            'gudang'              => 'fas fa-warehouse',
            'bengkel'             => 'fas fa-tools',
            'showroom'            => 'fas fa-car',

            // Pertanian
            'sawah'               => 'fas fa-leaf',
            'kebun'               => 'fas fa-leaf',
            'ladang'              => 'fas fa-leaf',
            'pertanian'           => 'fas fa-leaf',
            'lahan pertanian'     => 'fas fa-leaf',
            'kolam ikan'          => 'fas fa-water',
            'tambak'              => 'fas fa-water',

            // Lapangan olahraga
            'lapangan'            => 'fas fa-futbol',
            'lapangan olahraga'   => 'fas fa-futbol',
            'gelanggang'          => 'fas fa-futbol',
            'lapangan sepak bola' => 'fas fa-futbol',

            // Taman
            'taman'               => 'fas fa-tree',
            'taman bermain'       => 'fas fa-tree',
            'taman hiburan'       => 'fas fa-tree',

            // Tempat ibadah
            'masjid'              => 'fas fa-mosque',
            'gereja'              => 'fas fa-gopuram',
            'kelenteng'           => 'fas fa-gopuram',
            'vihara'              => 'fas fa-gopuram',
            'mushola'             => 'fas fa-mosque',

            // Pendidikan
            'sekolah'             => 'fas fa-school',
            'kampus'              => 'fas fa-university',
            'universitas'         => 'fas fa-university',
            'pesantren'           => 'fas fa-school',

            // Tempat hiburan
            'bioskop'             => 'fas fa-film',
            'mall'                => 'fas fa-store',
            'pasar'               => 'fas fa-store',
            'supermarket'         => 'fas fa-store',

            // Kesehatan
            'rumah sakit'         => 'fas fa-hospital',
            'klinik'              => 'fas fa-hospital',
            'puskesmas'           => 'fas fa-hospital',
            'farmasi'             => 'fas fa-hospital',

            // Perdagangan
            'perdagangan'         => 'fas fa-shopping-cart',
            'tempat usaha'        => 'fas fa-briefcase',

            // Lahan kosong
            'tanah kosong'        => 'fas fa-square',
            'lahan kosong'        => 'fas fa-square',
            'kosong'              => 'fas fa-square',

            // Parkir
            'parkir'              => 'fas fa-square',
            'tempat parkir'       => 'fas fa-square',

            // Hotel
            'hotel'               => 'fas fa-hotel',
            'penginapan'          => 'fas fa-hotel',

            // Garasi
            'garasi'              => 'fas fa-car',
        ];

        // Cari exact match terlebih dahulu
        if (isset($iconMap[$nama])) {
            return $iconMap[$nama];
        }

        // Cari partial match
        foreach ($iconMap as $key => $icon) {
            if (strpos($nama, $key) !== false || strpos($key, $nama) !== false) {
                return $icon;
            }
        }

        // Default icon
        return 'fas fa-map-pin';
    }

    /**
     * Get color class based on jenis penggunaan
     */
    public static function getColorByJenisPenggunaan($jenisPenggunaan)
    {
        if (! $jenisPenggunaan) {
            return 'bg-gray-100';
        }

        $nama = strtolower($jenisPenggunaan);

        $colorMap = [
            'rumah'         => 'bg-blue-100',
            'rumah tinggal' => 'bg-blue-100',
            'toko'          => 'bg-purple-100',
            'ruko'          => 'bg-purple-100',
            'warung'        => 'bg-orange-100',
            'restoran'      => 'bg-orange-100',
            'kafe'          => 'bg-yellow-100',
            'cafe'          => 'bg-yellow-100',
            'kantor'        => 'bg-indigo-100',
            'pabrik'        => 'bg-gray-100',
            'gudang'        => 'bg-gray-100',
            'sawah'         => 'bg-green-100',
            'kebun'         => 'bg-green-100',
            'ladang'        => 'bg-green-100',
            'lapangan'      => 'bg-red-100',
            'taman'         => 'bg-green-100',
            'masjid'        => 'bg-emerald-100',
            'sekolah'       => 'bg-cyan-100',
            'kampus'        => 'bg-cyan-100',
            'bioskop'       => 'bg-pink-100',
            'mall'          => 'bg-purple-100',
            'pasar'         => 'bg-amber-100',
            'rumah sakit'   => 'bg-red-100',
            'klinik'        => 'bg-red-100',
            'puskesmas'     => 'bg-red-100',
            'hotel'         => 'bg-rose-100',
        ];

        // Cari exact match
        if (isset($colorMap[$nama])) {
            return $colorMap[$nama];
        }

        // Cari partial match
        foreach ($colorMap as $key => $color) {
            if (strpos($nama, $key) !== false) {
                return $color;
            }
        }

        // Default color
        return 'bg-gray-100';
    }

    /**
     * Get icon color class based on jenis penggunaan
     */
    public static function getIconColorByJenisPenggunaan($jenisPenggunaan)
    {
        if (! $jenisPenggunaan) {
            return 'text-gray-400';
        }

        $nama = strtolower($jenisPenggunaan);

        $colorMap = [
            'rumah'         => 'text-blue-600',
            'rumah tinggal' => 'text-blue-600',
            'toko'          => 'text-purple-600',
            'ruko'          => 'text-purple-600',
            'warung'        => 'text-orange-600',
            'restoran'      => 'text-orange-600',
            'kafe'          => 'text-yellow-600',
            'cafe'          => 'text-yellow-600',
            'kantor'        => 'text-indigo-600',
            'pabrik'        => 'text-gray-600',
            'gudang'        => 'text-gray-600',
            'sawah'         => 'text-green-600',
            'kebun'         => 'text-green-600',
            'ladang'        => 'text-green-600',
            'lapangan'      => 'text-red-600',
            'taman'         => 'text-green-600',
            'masjid'        => 'text-emerald-600',
            'sekolah'       => 'text-cyan-600',
            'kampus'        => 'text-cyan-600',
            'bioskop'       => 'text-pink-600',
            'mall'          => 'text-purple-600',
            'pasar'         => 'text-amber-600',
            'rumah sakit'   => 'text-red-600',
            'klinik'        => 'text-red-600',
            'puskesmas'     => 'text-red-600',
            'hotel'         => 'text-rose-600',
        ];

        // Cari exact match
        if (isset($colorMap[$nama])) {
            return $colorMap[$nama];
        }

        // Cari partial match
        foreach ($colorMap as $key => $color) {
            if (strpos($nama, $key) !== false) {
                return $color;
            }
        }

        // Default color
        return 'text-gray-400';
    }

    /**
     * Get route prefix based on user role
     * Returns 'admin' untuk admin dan super_admin
     * Ini digunakan untuk view agar route names bekerja untuk kedua role
     */
    public static function getRoutePrefix()
    {
        if (! auth()->check()) {
            return 'admin';
        }

        $role = auth()->user()->role;

        // OLD CODE (DEPRECATED - untuk referensi):
        // return $role === 'super_admin' ? 'super-admin' : 'admin';
        // Tapi dengan route naming convention yang ada, kita perlu gunakan 'admin' untuk super-admin juga
        // atau ubah views untuk menggunakan conditional route names

        // Sekarang: gunakan logic yang sesuai dengan view
        // Jika super_admin, kembalikan 'admin' karena views masih hardcoded 'admin.'
        // dan routes super_admin punya name prefix 'super-admin.' tapi di super-admin.peta.create dst
        return $role === 'super_admin' ? 'super-admin' : 'admin';
    }
}
