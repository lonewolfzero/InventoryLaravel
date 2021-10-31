<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePLapbulProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE PROCEDURE p_lapbul(in p_id_gudang int,in  p_tahun int,
            in  p_bulan int)
        begin
            select row_number() over() nomor,
        sbb.nama_barang, sbb.satuan, 
        date_format(sbb.tanggal, '%Y-%m-%d') tanggal,
        sbb.jumlah_stock_awal,
        sbb.nomor_bukti_penerimaan,sbb.jumlah_penerimaan,
        sbb.nomor_bukti_pengeluaran,sbb.jumlah_pengeluaran,
        sbb.nomor_bukti_stock_opname,sbb.jumlah_stock_opname,
        sbb.persediaan_akhir_bulan,
        case sbb.prioritas when 5 then sbb.persediaan_akhir_bulan else sum(sbb.balance) over(partition by sbb.id_gudang,
            sbb.id_barang,
            sbb.tahun_anggaran,
            sbb.harga_satuan,
            sbb.nomor_stock_opname order by sbb.urut, sbb.tanggal, sbb.prioritas) end jumlah,
        sbb.harga_satuan,
        case sbb.prioritas when 5 then sbb.harga_satuan * sbb.persediaan_akhir_bulan else sbb.jumlah_harga end jumlah_harga, 
        sbb.tahun_anggaran, sbb.keterangan
        from
        (select cb.id_gudang, g2.nama nama_gudang, cb.id_barang, b2.nama nama_barang, s2.nama satuan, 
        concat(p_tahun,'-',p_bulan,'-',1,' 00:00:00') - interval 1 day tanggal,
        sum(cb.balance) jumlah_stock_awal, 
        null nomor_bukti_penerimaan,null jumlah_penerimaan,
        null nomor_bukti_pengeluaran,null jumlah_pengeluaran,
        null nomor_bukti_stock_opname,null jumlah_stock_opname,
        null persediaan_akhir_bulan,
        cb.harga harga_satuan,null jumlah_harga, cb.tahun_anggaran, null keterangan,
        (select dso.nomor_stock_opname from v_detail_stock_opname dso where dso.id_gudang = p_id_gudang 
        and dso.id_barang = cb.id_barang 
        and dso.tahun_anggaran = cb.tahun_anggaran and dso.harga = cb.harga 
        and dso.tanggal_pelaksanaan <= concat(p_tahun,'-',p_bulan,'-',1,' 00:00:01')
        and dso.next_date >= concat(p_tahun,'-',p_bulan,'-',1,' 00:00:01')) nomor_stock_opname,
        1 prioritas,1 urut, sum(cb.balance) balance
        from count_balance cb, (select distinct vl.id_gudang, vl.id_barang, vl.tahun_anggaran, vl.harga_satuan 
        from v_lapbul vl where vl.id_gudang = p_id_gudang 
        and extract(year from vl.tanggal) = p_tahun and 
        extract(month from vl.tanggal) = p_bulan) sb, gudang g2, barang b2, satuan s2 
        where sb.id_gudang = cb.id_gudang and sb.id_barang = cb.id_barang and cb.tahun_anggaran = sb.tahun_anggaran 
        and cb.harga =sb.harga_satuan and cb.id_gudang = g2.id and b2.id = cb.id_barang 
        and s2.id = b2.id_satuan
        and cb.tanggal < concat(p_tahun,'-',p_bulan,'-',1,' 00:00:01')
        group by cb.id_gudang, g2.nama, cb.id_barang, b2.nama, s2.nama, cb.tahun_anggaran,
        cb.harga
        union 
        select vl.id_gudang, vl.nama_gudang,vl.id_barang, vl.nama_barang, vl.satuan, vl.tanggal,
        vl.jumlah_stock_awal,vl.nomor_bukti_penerimaan , vl.jumlah_penerimaan,
        vl.nomor_bukti_pengeluaran, vl.jumlah_pengeluaran,
        vl.nomor_bukti_stock_opname, vl.jumlah_stock_opname,
        vl.persediaan_akhir_bulan,  vl.harga_satuan, vl.jumlah_harga, vl.tahun_anggaran, vl.keterangan, vl.nomor_stock_opname,
        vl.prioritas,2 urut, vl.balance
        from v_lapbul vl where vl.id_gudang = p_id_gudang 
        and extract(year from vl.tanggal) = p_tahun and 
        extract(month from vl.tanggal) = p_bulan
        union
        select cb.id_gudang, g2.nama nama_gudang, cb.id_barang, b2.nama nama_barang, s2.nama satuan, 
        last_day(concat(p_tahun,'-',p_bulan,'-',1,' 00:00:01')) + interval 1 day - interval 1 second tanggal,
        null jumlah_stock_awal, 
        null nomor_bukti_penerimaan,null jumlah_penerimaan,
        null nomor_bukti_pengeluaran,null jumlah_pengeluaran,
        null nomor_bukti_stock_opname,null jumlah_stock_opname,
        sum(cb.balance) persediaan_akhir_bulan,
        cb.harga harga_satuan,null jumlah_harga, cb.tahun_anggaran, null keterangan,
        (select dso.nomor_stock_opname from v_detail_stock_opname dso where dso.id_gudang = 1 and dso.id_barang = cb.id_barang 
        and dso.tahun_anggaran = cb.tahun_anggaran and dso.harga = cb.harga 
        and dso.tanggal_pelaksanaan <= (last_day(concat(p_tahun,'-',p_bulan,'-',1,' 00:00:01')) + interval 1 day - interval 1 second)
        and dso.next_date >=
        (last_day(concat(p_tahun,'-',p_bulan,'-',1,' 00:00:01')) + interval 1 day - interval 1 second)) nomor_stock_opname,
        5 prioritas, 3 urut, sum(cb.balance) balance
        from count_balance cb, (select distinct vl.id_gudang, vl.id_barang, vl.tahun_anggaran, vl.harga_satuan 
        from v_lapbul vl where vl.id_gudang = p_id_gudang 
        and extract(year from vl.tanggal) = p_tahun and 
        extract(month from vl.tanggal) = p_bulan) sb, gudang g2, barang b2, satuan s2 
        where sb.id_gudang = cb.id_gudang and sb.id_barang = cb.id_barang and cb.tahun_anggaran = sb.tahun_anggaran 
        and cb.harga =sb.harga_satuan and cb.id_gudang = g2.id 
        and b2.id = cb.id_barang and s2.id = b2.id_satuan
        and cb.tanggal < (last_day(concat(p_tahun,'-',p_bulan,'-',1,' 00:00:01')) + interval 1 day - interval 1 second)
        group by cb.id_gudang, g2.nama, cb.id_barang, b2.nama, s2.nama, cb.tahun_anggaran,
        cb.harga) sbb;
        END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP PROCEDURE IF EXISTS p_lapbul;");
    }
}
