<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer AmirulPay ke OVO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="img/amirulpaytoovo.png" type="image/png">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Transfer Saldo AmirulPay ke OVO</h2>
        <form id="transferForm" action="process_transfer.php" method="post">
            <div class="form-group">
                <label for="amount">Jumlah:</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="phone">Nomor Telepon OVO:</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Transfer</button>
        </form>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#transferForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah pengiriman default

                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: form.serialize(),
                    success: function(response) {
                        // Tampilkan notifikasi sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Transfer saldo berhasil dilakukan.'
                        });
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan notifikasi gagal
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Transfer saldo gagal. Coba lagi nanti.'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
