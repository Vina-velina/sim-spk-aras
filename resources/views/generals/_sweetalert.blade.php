<script>
    $(document).ready(function() {
        const success = $(".berhasil").data("berhasil");
        if (success) {
            swal({
                title: "Berhasil!",
                text: success,
                type: "success",
                buttons: {
                    confirm: {
                        text: "Tutup",
                        value: true,
                        visible: true,
                        className: "btn btn-success",
                        closeModal: true
                    }
                }
            });
        }
    });

    $(document).ready(function() {
        const gagal = $(".gagal").data("gagal");
        if (gagal) {
            swal({
                title: "Gagal!",
                text: gagal,
                type: "error",
                buttons: {
                    confirm: {
                        text: "Tutup",
                        value: true,
                        visible: true,
                        className: "btn btn-danger",
                        closeModal: true
                    }
                }
            });
        }
    });

    const alertGagal = (gagal) => {
        swal({
            title: "Gagal!",
            text: gagal,
            type: "error",
            buttons: {
                confirm: {
                    text: "Tutup",
                    value: true,
                    visible: true,
                    className: "btn btn-danger",
                    closeModal: true
                }
            }
        });
    }

    const alertSuccess = (success) => {
        swal({
            title: "Berhasil!",
            text: success,
            type: "success",
            buttons: {
                confirm: {
                    text: "Tutup",
                    value: true,
                    visible: true,
                    className: "btn btn-success",
                    closeModal: true
                }
            }
        });
    }

    const alertConfirm = (button) => {
        const id = $(button).data('id');
        swal({
                title: "Apakah Anda Yakin?",
                text: "Data akan terhapus secara permanen!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Hapus Data",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $('#delete-' + id).submit();
                } else {
                    swal("Data Aman", "Data Yang Dipilih Batal Dihapus", "error");
                }
            });
    }

    const alertConfirmPublish = () => {
        swal({
                title: "Apakah Anda Yakin?",
                text: "Data akan terpublish dan tidak dapat dibatalkan!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Publish Data",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $('#publish-button').submit();
                } else {
                    swal("Data Aman", "Data Yang Dipilih Batal Dipublish", "error");
                }
            });
    }
</script>
