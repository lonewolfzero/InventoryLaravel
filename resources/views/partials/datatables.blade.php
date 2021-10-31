<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://raw.githubusercontent.com/openexchangerates/accounting.js/master/accounting.min.js"></script>
<script>
    var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    var d =  new Date();
    var dateTime = d.getDate() + ', ' + months[d.getMonth()] + ' ' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();

    $.extend( true, $.fn.dataTable.defaults, {
        pageLength: 10,
        scrollX: true,
        scrollCollapse: true,
        dom: '<"row" <"col-md-4" l> <"col-md-4 pt-3"B> <"col-md-4 right"f>>  <"bottom" rtip>',
        // dom: 'BlfB',//lBfrtip
        order: [[ 0, "desc" ]],
        buttons: [
            { extend: 'print',
                title: '',
                messageTop: function(){
                    if ( $('select#id_gudang').val() != '' ){
                        id_gudang = $('#id_gudang').val();
                        gudang = $('#id_gudang option[value="' + id_gudang + '"]').html();
                        html_gudang = `<tr> <td>Gudang</td> <td>: ${gudang}</td></tr>`;

                    }else {
                        html_gudang = ``;
                    }
                    
                    if ( $('#reportrange').length > 0 ){
                        let startDate =  new Date($('#reportrange').data('daterangepicker').startDate.format('YYYY-M-D'));
                        startDate= startDate.getDate() + ', ' + months[startDate.getMonth()] + ' ' + startDate.getFullYear();
                        let endDate =  new Date( $('#reportrange').data('daterangepicker').endDate.format('YYYY-M-D'));
                        endDate= endDate.getDate() + ', ' + months[endDate.getMonth()] + ' ' + endDate.getFullYear();
                        html_date = `<tr> <td>Tanggal </td> <td>: ${startDate} - ${endDate}</td></tr>`;
                    }else {
                        html_date = ``;
                    }

                    if ( document.title.split(' | ')[1] == 'Stock' || document.title.split(' | ')[1].includes('Laporan') ){
                        title = document.title.split(' | ')[1];
                        if ( title.includes('Stock') ){
                            title = 'Laporan Stock Materil Bekang';
                        }
                    }else {
                        title = '';
                    }

                    return `<div><h4>PUSAT PEMBEKALAN ANGKUTAN TNI AD <br> GUDANG PUSAT PEMBEKALAN ANGKUTAN - 1 </h4></div>
                    <div style="position: relative;">
                        <div style="position: relative; margin-left:40%;">
                            <br>
                            <h5>${title}</h5>
                            <table>
                                ${html_gudang}
                                ${html_date}
                            </table>
                            <br>
                        </div>
                    </div>`;
                    return '<h4>PUSAT PEMBEKALAN ANGKUTAN TNI AD <br> GUDANG PUSAT PEMBEKALAN ANGKUTAN - 1 </h4>';
                },
                messageBottom: function(){
                    return '</br> Tanggal Print : ' + dateTime;
                },
                exportOptions:
                    { columns: [':visible :not(:last-child)'] }
            },
            { extend: 'excel', 
                messageBottom: function(){
                    return 'Tanggal Print : ' + dateTime;
                },
                exportOptions:
                    { columns: [':visible :not(:last-child)'] }
            },
            { extend: 'csv', 
                messageBottom: function(){
                    return 'Tanggal Print : ' + dateTime;
                },
                exportOptions:
                { columns: [':visible :not(:last-child)'] }
            },
            { extend: 'copy',
                messageBottom: function(){
                    return 'Tanggal Print : ' + dateTime;
                },
                exportOptions:
                { columns: [':visible :not(:last-child)'] }
            },
        ],
        language: {
            processing: "Loading Data..."
        }, 
        columnDefs: [
            { 
                targets: [ 'actions' ], //first column / numbering column
                orderable: false, //set not orderable
            },
            { 
                targets: [ 'actions' ], //first column / numbering column
                searching: false, //set not orderable
            },
        ],
        "fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
        },
        "initComplete": function(settings, json) {
            $(this).find('button.destroy').on('click', function(e){
                var username = $(this).data('user');
                var name = $(this).data('name');
               
                if ( username != undefined ){
                    var html = `kamu ingin menghapus <b>${username}</b>.`;
                }else if ( name != undefined ){
                    var html = `kamu ingin menghapus <b>${name}</b>.`
                }

                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Kamu Yakin?',
                    icon: 'question',
                    html: html,
                    showCancelButton: true,
                    confirmButtonColor: '#D33',
                    cancelButtonColor: '#666',
                    confirmButtonText: 'Yaa, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.value) {
                        $(this).parent().submit();
                    }
                });

            });
        }
    } );
    $.fn.dataTable.ext.errMode = 'throw';

</script>