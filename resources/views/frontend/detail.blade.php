<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Rental - Popup Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .wallet-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px;
        }
        .wallet-option img {
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body>

<div class="container mt-5 text-center">
    <h2>Form Rental</h2>
    <button type="button" class="btn btn-primary" onclick="showModal()">
        Isi Data Rental
    </button>
</div>

<!-- Modal Form di Tengah -->
<div class="modal fade" id="rentalModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Form Pengisian Rental</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="proses_rental.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Alamat Serah Terima</label>
                        <input type="text" class="form-control" name="alamat_serah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Pengembalian</label>
                        <input type="text" class="form-control" name="alamat_kembali" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai Sewa</label>
                        <input type="date" class="form-control" name="tgl_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai Sewa</label>
                        <input type="date" class="form-control" name="tgl_selesai" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control" name="jam_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" class="form-control" name="jam_selesai" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Helm</label>
                        <input type="number" class="form-control" name="jumlah_helm" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rekening Asal</label>
                        <select class="form-select" name="rekening_asal" required>
                            <option value="" disabled selected>Pilih Rekening Asal</option>
                            <option value="Dana">💙 Dana</option>
                            <option value="OVO">🟣 OVO</option>
                            <option value="GoPay">🔵 GoPay</option>
                            <option value="ShopeePay">🟠 ShopeePay</option>
                            <option value="Bank Transfer">🏦 Bank Transfer</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap & JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showModal() {
        var myModal = new bootstrap.Modal(document.getElementById('rentalModal'));
        myModal.show();
    }
</script>

</body>
</html>
