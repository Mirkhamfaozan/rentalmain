<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Sewa Helm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            max-width: 500px;
            margin: auto;
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card p-4">
            <h2 class="text-center mb-3">Form Sewa Helm</h2>

            <div id="alert" class="alert d-none"></div>

            <form id="sewaForm">
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai Sewa</label>
                    <input type="date" class="form-control" id="tanggal_mulai" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai Sewa</label>
                    <input type="date" class="form-control" id="tanggal_selesai" required>
                </div>

                <div class="mb-3">
                    <label for="jumlah_helm" class="form-label">Jumlah Helm</label>
                    <input type="number" class="form-control" id="jumlah_helm" min="1" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Sewa Sekarang</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('sewaForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const tanggalMulai = document.getElementById('tanggal_mulai').value;
            const tanggalSelesai = document.getElementById('tanggal_selesai').value;
            const jumlahHelm = document.getElementById('jumlah_helm').value;
            const alertBox = document.getElementById('alert');

            if (new Date(tanggalMulai) > new Date(tanggalSelesai)) {
                alertBox.className = 'alert alert-danger';
                alertBox.innerText = 'Tanggal selesai harus setelah tanggal mulai!';
                alertBox.classList.remove('d-none');
                return;
            }

            alertBox.className = 'alert alert-success';
            alertBox.innerText = 'Penyewaan berhasil!';
            alertBox.classList.remove('d-none');

            setTimeout(() => {
                alertBox.classList.add('d-none');
            }, 3000);

            document.getElementById('sewaForm').reset();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
