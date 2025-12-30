document.addEventListener("DOMContentLoaded", function () {
    const editItemModal = document.getElementById("editItemModal");

    // Event listener yang dipicu saat modal akan ditampilkan
    editItemModal.addEventListener("show.bs.modal", function (event) {
        // Tombol yang memicu modal
        const button = event.relatedTarget;

        // Ambil data dari atribut data-item-*
        const itemName = button.getAttribute("data-item-name");
        const itemPrice = button.getAttribute("data-item-price");
        const updateUrl = button.getAttribute("data-update-url");

        // Dapatkan elemen-elemen Form
        const modalTitle = editItemModal.querySelector(".modal-title");
        const form = editItemModal.querySelector("#editItemForm");
        const inputName = editItemModal.querySelector("#edit_itemName");
        const inputPrice = editItemModal.querySelector("#edit_itemPrice");

        // Reset status validasi saat modal dibuka
        form.querySelectorAll(".is-invalid").forEach((el) =>
            el.classList.remove("is-invalid")
        );
        form.querySelectorAll(".invalid-feedback").forEach((el) => el.remove());

        // Isi data ke dalam modal
        modalTitle.textContent = `Edit Item: ${itemName}`;
        form.action = updateUrl; // Set action URL untuk PUT ke items.update
        inputName.value = itemName;
        inputPrice.value = itemPrice;
    });

    function konfirmasiHapus(formId) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Anda tidak akan dapat mengembalikannya!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengkonfirmasi, kirim formulir yang sesuai
                const form = document.getElementById(formId);
                if (form) {
                    form.submit();
                }

                // CATATAN PENTING:
                // SweetAlert "Deleted!" biasanya ditampilkan setelah server
                // berhasil memproses penghapusan dan mengarahkan kembali (redirect).
                // Menampilkannya di sini akan membuat pengguna melihatnya, tetapi
                // penghapusan belum tentu selesai.

                /*
            Swal.fire({
                title: "Terhapus!",
                text: "File Anda telah dihapus.",
                icon: "success",
            });
            */
            }
        });
    }
});
