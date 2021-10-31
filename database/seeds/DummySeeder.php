<?php

use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori')->insert([
            ['nama' => 'Perlengkapan', 'active' => 1, 'keterangan' => 'Perlengkapan', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.734790', 'created_at' => '2021-05-07 13:28:59.734790'],
            ['nama' => 'Peralatan', 'active' => 1, 'keterangan' => 'Peralatan', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790'],
            ['nama' => 'Persediaan', 'active' => 1, 'keterangan' => 'Persediaan', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790'],
            ['nama' => 'Makanan', 'active' => 1, 'keterangan' => 'Makanan', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790'],
            ['nama' => 'Alas', 'active' => 1, 'keterangan' => 'Alas', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790'],
            ['nama' => 'Alat Masak', 'active' => 1, 'keterangan' => 'Alat Masak', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790'],
            ['nama' => 'Bahan Makanan', 'active' => 1, 'keterangan' => 'Bahan Makanan', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790'],
            ['nama' => 'Pakaian', 'active' => 1, 'keterangan' => 'Pakaian', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790'],
        ]);

        DB::table('satuan')->insert([
            ['nama' => 'Pcs', 'active' => 1, 'keterangan' => 'Pieces', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Pcs', 'active' => 1, 'keterangan' => 'Pieces', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Unit', 'active' => 1, 'keterangan' => 'Unit', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Buah', 'active' => 1, 'keterangan' => 'Buah', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Lembar', 'active' => 1, 'keterangan' => 'Lembar', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Keping', 'active' => 1, 'keterangan' => 'Keping', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Pasang', 'active' => 1, 'keterangan' => 'Pasang', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Pack', 'active' => 1, 'keterangan' => 'Pack', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Kg', 'active' => 1, 'keterangan' => 'Kg', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Liter', 'active' => 1, 'keterangan' => 'Liter', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        ]);

        DB::table('gudang')->insert([
            ['nama' => 'Gudang 000001', 'nomor' => 1, 'active' => 1, 'keterangan' => 'Gudang 000001', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Gudang 000002', 'nomor' => 2, 'active' => 1, 'keterangan' => 'Gudang 000002', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Gudang 000003', 'nomor' => 3, 'active' => 1, 'keterangan' => 'Gudang 000003', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Gudang 000004', 'nomor' => 4, 'active' => 1, 'keterangan' => 'Gudang 000004', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Gudang 000005', 'nomor' => 5, 'active' => 1, 'keterangan' => 'Gudang 000005', 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Gudang A', 'nomor' => 1001, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Gudang B', 'nomor' => 1002, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Gudang C', 'nomor' => 1003, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        ]);
        
        DB::table('rak')->insert([
            ['id_gudang' => 1, 'nama' => 'Rak 00001-001', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 1, 'nama' => 'Rak 00001-002', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 1, 'nama' => 'Rak 00001-003', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 1, 'nama' => 'Rak 00001-004', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],

            ['id_gudang' => 2, 'nama' => 'Rak 00002-001', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 2, 'nama' => 'Rak 00002-002', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],

            ['id_gudang' => 3, 'nama' => 'Rak 00003-001', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 3, 'nama' => 'Rak 00003-002', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],

            ['id_gudang' => 4, 'nama' => 'Rak 00004-001', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 4, 'nama' => 'Rak 00004-002', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],

            ['id_gudang' => 5, 'nama' => 'Rak 00005-001', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 5, 'nama' => 'Rak 00005-002', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],

            ['id_gudang' => 6, 'nama' => 'Rak 1', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 6, 'nama' => 'Rak 2', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 6, 'nama' => 'Rak 3', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],

            ['id_gudang' => 7, 'nama' => 'Rak 1', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 7, 'nama' => 'Rak 2', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 7, 'nama' => 'Rak 3', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],

            ['id_gudang' => 8, 'nama' => 'Rak 1', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 8, 'nama' => 'Rak 2', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_gudang' => 8, 'nama' => 'Rak 3', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        ]);

        DB::table('satuan_pemakai')->insert([
            ['nama' => 'Kala Hitam', 'pic' => null, 'nomor_telephone' => null, 'contact_person' => null, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Kumbang Malam', 'pic' => null, 'nomor_telephone' => null, 'contact_person' => null, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Mata Elang', 'pic' => null, 'nomor_telephone' => null, 'contact_person' => null, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Cakrawala Sunyi', 'pic' => null, 'nomor_telephone' => null, 'contact_person' => null, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Garuda Angkasa 1', 'pic' => null, 'nomor_telephone' => null, 'contact_person' => null, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Garuda Angkasa 2', 'pic' => null, 'nomor_telephone' => null, 'contact_person' => null, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Kodim 1', 'pic' => '-', 'nomor_telephone' => '', 'contact_person' => '-', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Kodim 2', 'pic' => '-', 'nomor_telephone' => '', 'contact_person' => '-', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Kodim 3', 'pic' => '-', 'nomor_telephone' => '', 'contact_person' => '-', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        ]);

        DB::table('rekanan')->insert([
            ['nama' => 'PT. Maju Sejahtera', 'pic' => null, 'contact_person' => null, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'PT. Cahaya Cemerlang', 'pic' => null, 'contact_person' => null, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'PT. Harapan Baru', 'pic' => null, 'contact_person' => null, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'John Deacon', 'pic' => null, 'contact_person' => null, 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Mitra A', 'pic' => '-', 'contact_person' => '-', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Mitra B', 'pic' => '-', 'contact_person' => '-', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Mitra C', 'pic' => '-', 'contact_person' => '-', 'active' => 1, 'keterangan' => null, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        ]);

        DB::table('barang')->insert([
            ['nama' => 'Kaus Kaki', 'kode_barang' => '12381728370001',  'kode_barcode' => '1122334401', 'active' => 1, 'keterangan' => null, 'id_kategori' => 5, 'id_satuan' => 6, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Pakaian Dinas Lapangan', 'kode_barang' => '12381728370002',  'kode_barcode' => '1122334402', 'active' => 1, 'keterangan' => null, 'id_kategori' => 1, 'id_satuan' => 2, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Kaus Olahraga', 'kode_barang' => '12381728370003',  'kode_barcode' => '1122334403', 'active' => 1, 'keterangan' => null, 'id_kategori' => 5, 'id_satuan' => 2, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Nesting', 'kode_barang' => '12381728370004',  'kode_barcode' => '1122334404', 'active' => 1, 'keterangan' => null, 'id_kategori' => 2, 'id_satuan' => 3, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Penyedap Rasa', 'kode_barang' => '12381728370005',  'kode_barcode' => '1122334405', 'active' => 1, 'keterangan' => null, 'id_kategori' => 4, 'id_satuan' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Gula Buatan', 'kode_barang' => '12381728370006',  'kode_barcode' => '1122334407', 'active' => 1, 'keterangan' => null, 'id_kategori' => 4, 'id_satuan' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Baju', 'kode_barang' => '12381728370007',  'kode_barcode' => '1122334407', 'active' => 1, 'keterangan' => null, 'id_kategori' => 6, 'id_satuan' => 7, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Rompi', 'kode_barang' => '12381728370008',  'kode_barcode' => '1122334408', 'active' => 1, 'keterangan' => null, 'id_kategori' => 3, 'id_satuan' => 8, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Bekal A1', 'kode_barang' => '12381728370009',  'kode_barcode' => '1122334409', 'active' => 1, 'keterangan' => null, 'id_kategori' => 8, 'id_satuan' => 9, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nama' => 'Bekal A2', 'kode_barang' => '12381728370010',  'kode_barcode' => '1122334410', 'active' => 1, 'keterangan' => null, 'id_kategori' => 8, 'id_satuan' => 10, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        ]);

        DB::table('penyimpanan')->insert([
            ['id_barang' => 1, 'id_rak' => 1, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 2, 'id_rak' => 2, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 3, 'id_rak' => 1, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 4, 'id_rak' => 2, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 5, 'id_rak' => 2, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 6, 'id_rak' => 2, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 7, 'id_rak' => 2, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 8, 'id_rak' => 3, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 9, 'id_rak' => 4, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 10, 'id_rak' => 4, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 10, 'id_rak' => 6, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 9, 'id_rak' => 15, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 8, 'id_rak' => 16, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 7, 'id_rak' => 17, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['id_barang' => 6, 'id_rak' => 18, 'active' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        ]);


        DB::table('barang_masuk')->insert([
            ['nomor_ba' => 'BA-00129', 'nomor_kontrak' => 'NULL', 'nomor_kph' => 'KPH/00001/2020/01/001', 'nomor_surat' => 'SRT/00001/2020/01/001', 'tahun_anggaran' => 2020, 'tanggal_input' => '2020-01-01 10:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 1, 'id_rekanan' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_ba' => 'BA-00129', 'nomor_kontrak' => 'NULL', 'nomor_kph' => 'KPH/00001/2020/01/002', 'nomor_surat' => 'SRT/00001/2020/01/002', 'tahun_anggaran' => 2020, 'tanggal_input' => '2020-01-11 10:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 1, 'id_rekanan' => 2, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_ba' => 'BA-00129', 'nomor_kontrak' => 'NULL', 'nomor_kph' => 'KPH/00001/2020/01/003', 'nomor_surat' => 'SRT/00001/2020/01/003', 'tahun_anggaran' => 2020, 'tanggal_input' => '2020-01-20 10:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 1, 'id_rekanan' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_ba' => 'BA-00129', 'nomor_kontrak' => 'NULL', 'nomor_kph' => 'KPH/00001/2020/02/001', 'nomor_surat' => 'SRT/00001/2020/02/001', 'tahun_anggaran' => 2020, 'tanggal_input' => '2020-02-11 10:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 1, 'id_rekanan' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_ba' => 'BA-00129', 'nomor_kontrak' => 'NULL', 'nomor_kph' => 'KPH/00002/2020/01/001', 'nomor_surat' => 'SRT/00002/2020/01/001', 'tahun_anggaran' => 2020, 'tanggal_input' => '2020-01-11 10:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 2, 'id_rekanan' => 3, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_ba' => 'BA-00129', 'nomor_kontrak' => 'NULL', 'nomor_kph' => 'KPH/00002/2020/01/002', 'nomor_surat' => 'SRT/00002/2020/01/002', 'tahun_anggaran' => 2020, 'tanggal_input' => '2020-01-11 10:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 2, 'id_rekanan' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_ba' => 'BA-00129', 'nomor_kontrak' => 'NULL', 'nomor_kph' => 'KPH/00001/2020/03/001', 'nomor_surat' => 'SRT/00001/2020/03/001', 'tahun_anggaran' => 2020, 'tanggal_input' => '2020-01-20 10:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 1, 'id_rekanan' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_ba' => 'BA A1', 'nomor_kontrak' => 'KONTRAK A1', 'nomor_kph' => 'KPH A1', 'nomor_surat' => 'A1', 'tahun_anggaran' => 2021, 'tanggal_input' => '2020-05-15 10:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 6, 'id_rekanan' => 5, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_ba' => 'BA A2', 'nomor_kontrak' => 'KONTRAK A2', 'nomor_kph' => 'KPH A2', 'nomor_surat' => 'A2', 'tahun_anggaran' => 2021, 'tanggal_input' => '2020-05-16 10:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 7, 'id_rekanan' => 6, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_ba' => 'BA-A3', 'nomor_kontrak' => 'KONTRAK A3', 'nomor_kph' => 'KPH A3', 'nomor_surat' => 'A3', 'tahun_anggaran' => 2021, 'tanggal_input' => '2020-05-15 10:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 8, 'id_rekanan' => 7, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_ba' => 'BA-00129', 'nomor_kontrak' => 'KONTRAK A4', 'nomor_kph' => 'KPH A4', 'nomor_surat' => 'A4', 'tahun_anggaran' => 2021, 'tanggal_input' => '2020-05-15 10:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 8, 'id_rekanan' => 7, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            
        ]);

   
        DB::table('detail_barang_masuk')->insert([
            ['id_barang_masuk' => 1, 'harga' => 2000, 'jumlah' => 8784, 'keterangan' => null, 'id_barang' => 1],
            ['id_barang_masuk' => 1, 'harga' => 2000, 'jumlah' => 777, 'keterangan' => null, 'id_barang' => 1],
            ['id_barang_masuk' => 2, 'harga' => 3000, 'jumlah' => 232, 'keterangan' => null, 'id_barang' => 2],
            ['id_barang_masuk' => 2, 'harga' => 2000, 'jumlah' => 774, 'keterangan' => null, 'id_barang' => 3],
            ['id_barang_masuk' => 3, 'harga' => 3500, 'jumlah' => 5, 'keterangan' => null, 'id_barang' => 4],
            ['id_barang_masuk' => 3, 'harga' => 3500, 'jumlah' => 6551, 'keterangan' => null, 'id_barang' => 5],
            ['id_barang_masuk' => 4, 'harga' => 2000, 'jumlah' => 646, 'keterangan' => null, 'id_barang' => 6],
            ['id_barang_masuk' => 4, 'harga' => 2000, 'jumlah' => 400, 'keterangan' => null, 'id_barang' => 7],
            ['id_barang_masuk' => 5, 'harga' => 2000, 'jumlah' => 100, 'keterangan' => null, 'id_barang' => 8],
            ['id_barang_masuk' => 5, 'harga' => 2000, 'jumlah' => 332, 'keterangan' => null, 'id_barang' => 9],
            ['id_barang_masuk' => 6, 'harga' => 102, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 10],
            ['id_barang_masuk' => 6, 'harga' => 103, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 1],
            ['id_barang_masuk' => 7, 'harga' => 104, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 2],
            ['id_barang_masuk' => 7, 'harga' => 105, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 3],
            ['id_barang_masuk' => 8, 'harga' => 106, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 7],
            ['id_barang_masuk' => 8, 'harga' => 107, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 8],
            ['id_barang_masuk' => 11, 'harga' => 108, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 9],
            ['id_barang_masuk' => 11, 'harga' => 109, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 10],
        ]);

        DB::table('barang_keluar')->insert([
            ['nomor_surat' => 'SRT-K/00001/2020/01/001', 'nomor_nota_dinas' => 'NULL', 'tanggal_input' => '2020-01-23 17:25:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 1, 'id_satuan_pemakai' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_surat' => 'SRT-K/00001/2020/02/001', 'nomor_nota_dinas' => 'NULL', 'tanggal_input' => '2020-02-14 10:34:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 1, 'id_satuan_pemakai' => 2, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_surat' => 'SRT-K/00001/2020/02/002', 'nomor_nota_dinas' => 'NULL', 'tanggal_input' => '2020-02-21 10:34:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 1, 'id_satuan_pemakai' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_surat' => '1232343401', 'nomor_nota_dinas' => 'Nota Dinas A1', 'tanggal_input' => '2021-05-14 00:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 6, 'id_satuan_pemakai' => 7, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_surat' => '1232343409', 'nomor_nota_dinas' => 'Nota Dinas A2', 'tanggal_input' => '2021-05-13 00:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 7, 'id_satuan_pemakai' => 8, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_surat' => '1232343404', 'nomor_nota_dinas' => 'Nota Dinas A3', 'tanggal_input' => '2021-05-13 00:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 8, 'id_satuan_pemakai' => 9, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_surat' => '1232343402', 'nomor_nota_dinas' => 'Nota Dinas A4', 'tanggal_input' => '2021-05-12 00:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 8, 'id_satuan_pemakai' => 9, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_surat' => '8989898998', 'nomor_nota_dinas' => 'Nota Dinas A5', 'tanggal_input' => '2021-05-14 00:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 8, 'id_satuan_pemakai' => 9, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
            ['nomor_surat' => '8989898999', 'nomor_nota_dinas' => 'Nota Dinas A6', 'tanggal_input' => '2021-05-15 00:00:00.000000', 'active' => 1, 'keterangan' => null, 'id_gudang' => 8, 'id_satuan_pemakai' => 9, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        ]);



        // DB::table('detail_barang_keluar')->insert([
        //     ['id_barang_keluar' => 1, 'tahun_anggaran' => 2020, 'harga' => 2000, 'jumlah' => 405, 'keterangan' => null, 'id_barang' => 1],
        //     ['id_barang_keluar' => 1, 'tahun_anggaran' => 2020, 'harga' => 2000, 'jumlah' => 139, 'keterangan' => null, 'id_barang' => 3],
        //     ['id_barang_keluar' => 2, 'tahun_anggaran' => 2020, 'harga' => 3000, 'jumlah' => 112, 'keterangan' => null, 'id_barang' => 2],
        //     ['id_barang_keluar' => 2, 'tahun_anggaran' => 2020, 'harga' => 3500, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 5],
        //     ['id_barang_keluar' => 3, 'tahun_anggaran' => 2020, 'harga' => 3500, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 4],
        //     ['id_barang_keluar' => 3, 'tahun_anggaran' => 2020, 'harga' => 2000, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 9],
        //     ['id_barang_keluar' => 4, 'tahun_anggaran' => 2020, 'harga' => 2000, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 6],
        //     ['id_barang_keluar' => 4, 'tahun_anggaran' => 2020, 'harga' => 2000, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 7],
        //     ['id_barang_keluar' => 5, 'tahun_anggaran' => 2020, 'harga' => 2000, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 8],
        //     ['id_barang_keluar' => 5, 'tahun_anggaran' => 2021, 'harga' => 108, 'jumlah' => 2, 'keterangan' => null, 'id_barang' => 9],
        //     ['id_barang_keluar' => 6, 'tahun_anggaran' => 2021, 'harga' => 109, 'jumlah' => 1, 'keterangan' => null, 'id_barang' => 10],
        //     ['id_barang_keluar' => 7, 'tahun_anggaran' => 2021, 'harga' => 109, 'jumlah' => 1, 'keterangan' => null, 'id_barang' => 10],
        // ]);
        

        // DB::table('stock_opname')->insert([
        //     ['nomor_stock_opname' => 'SO-00001/01/001', 'tanggal_pelaksanaan' => '2020-01-31', 'active' => 1, 'id_gudang' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        //     ['nomor_stock_opname' => 'SO-00001/02/001', 'tanggal_pelaksanaan' => '2020-02-29', 'active' => 1, 'id_gudang' => 1, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        //     ['nomor_stock_opname' => '17879801', 'tanggal_pelaksanaan' => '2021-05-15', 'active' => 1, 'id_gudang' => 6, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        //     ['nomor_stock_opname' => '17879802', 'tanggal_pelaksanaan' => '2021-04-15', 'active' => 1, 'id_gudang' => 7, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        //     ['nomor_stock_opname' => '17879803', 'tanggal_pelaksanaan' => '2021-05-15', 'active' => 1, 'id_gudang' => 8, 'updated_by' => 1, 'updated_at' => '2021-05-07 13:28:59.823336', 'created_at' => '2021-05-07 13:28:59.734790' ],
        // ]);
            

        // DB::table('detail_stock_opname')->insert([
        //     ['id_stock_opname' => 1, 'id_barang' => 1, 'tahun_anggaran' => '2020', 'harga' => 2000, 'jumlah' => 9900],
        //     ['id_stock_opname' => 2, 'id_barang' => 8, 'tahun_anggaran' => '2020', 'harga' => 2000, 'jumlah' => 10230],
        //     ['id_stock_opname' => 1, 'id_barang' => 2, 'tahun_anggaran' => '2020', 'harga' => 3000, 'jumlah' => 900],
        //     ['id_stock_opname' => 2, 'id_barang' => 7, 'tahun_anggaran' => '2020', 'harga' => 3500, 'jumlah' => 10000],
        //     ['id_stock_opname' => 3, 'id_barang' => 3, 'tahun_anggaran' => '2021', 'harga' => 102, 'jumlah' => 4],
        //     ['id_stock_opname' => 4, 'id_barang' => 4, 'tahun_anggaran' => '2021', 'harga' => 109, 'jumlah' => 2],
        //     ['id_stock_opname' => 4, 'id_barang' => 5, 'tahun_anggaran' => '2021', 'harga' => 108, 'jumlah' => 2],
        //     ['id_stock_opname' => 3, 'id_barang' => 6, 'tahun_anggaran' => '2021', 'harga' => 103, 'jumlah' => 2],
        // ]);
            

    }
}
