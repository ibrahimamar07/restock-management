// Ambil elemen input file, img preview, dan tanda plus
const fileInput = document.getElementById("storePicInput");
const imagePreview = document.getElementById("storeImagePreview");
const plusSign = document.getElementById("plusSign");

// Tambahkan event listener untuk mendeteksi perubahan pada input file
fileInput.addEventListener("change", function (event) {
    const file = event.target.files[0];

    if (file) {
        // Buat FileReader baru
        const reader = new FileReader();

        // Ketika file selesai dimuat...
        reader.onload = function (e) {
            // Set src dari elemen <img> menjadi data URL dari gambar
            imagePreview.src = e.target.result;

            // Tampilkan gambar preview
            imagePreview.style.display = "block";

            // Sembunyikan tanda plus
            plusSign.style.display = "none";
        };

        // Baca file sebagai Data URL
        reader.readAsDataURL(file);
    } else {
        // Jika file dibatalkan/dihapus
        imagePreview.src = "#";
        imagePreview.style.display = "none";
        plusSign.style.display = "block";
    }
});
