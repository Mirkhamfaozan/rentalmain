// Toggle visibilitas kata sandi
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');

    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});

document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    const confirmPassword = document.getElementById('password_confirmation');
    const icon = document.getElementById('toggleConfirmIcon');

    if (confirmPassword.type === 'password') {
        confirmPassword.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        confirmPassword.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});

// Toggle kolom rental berdasarkan pilihan peran
const roleUser = document.getElementById('roleUser');
const roleRental = document.getElementById('roleRental');
const rentalFields = document.getElementById('rentalFields');

function toggleRentalFields() {
    if (roleRental.checked) {
        rentalFields.style.display = 'block';
        // Buat kolom rental wajib (kecuali no_wa dan email_perusahaan)
        document.querySelectorAll('#rentalFields input').forEach(input => {
            if (input.name !== 'no_wa' && input.name !== 'email_perusahaan') {
                input.required = true;
            }
        });
    } else {
        rentalFields.style.display = 'none';
        // Hapus required dari kolom rental
        document.querySelectorAll('#rentalFields input').forEach(input => {
            input.required = false;
        });
    }
}

roleUser.addEventListener('change', toggleRentalFields);
roleRental.addEventListener('change', toggleRentalFields);

// Efek hover pada tombol kirim
const submitButton = document.querySelector('.btn-primary');
submitButton.addEventListener('mouseover', function() {
    this.style.transform = 'translateY(-2px)';
    this.style.boxShadow = '0 8px 25px rgba(102, 126, 234, 0.4)';
});

submitButton.addEventListener('mouseout', function() {
    this.style.transform = 'translateY(0)';
    this.style.boxShadow = 'none';
});

// Validasi sisi klien
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const email = document.getElementById('email').value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Validasi kecocokan kata sandi
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Kata sandi dan konfirmasi kata sandi tidak cocok!');
        return;
    }

    // Validasi panjang kata sandi (minimal 8 karakter)
    if (password.length < 8) {
        e.preventDefault();
        alert('Kata sandi harus memiliki minimal 8 karakter!');
        return;
    }

    // Validasi format email
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Masukkan alamat email yang valid!');
        return;
    }
});

// Inisialisasi kolom berdasarkan input sebelumnya
document.addEventListener('DOMContentLoaded', function() {
    toggleRentalFields();
});
