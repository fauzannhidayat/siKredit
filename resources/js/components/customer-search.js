/**
 * customerSearch
 *
 * Tanggung jawab: HANYA mencari customer berdasarkan nama (live search,
 * partial match, bisa banyak hasil) dan memberi tahu bagian lain aplikasi
 * lewat custom event window saat user memilih salah satu hasil.
 *
 * Tidak tahu-menahu soal kalkulasi tagihan / format rupiah — itu tetap
 * jadi tanggung jawab formTagihan().
 */
export function customerSearch({ nama = '', searchUrl = '' } = {}) {
    return {
        nama,
        searchUrl,
        loading: false,
        results: [],
        showDropdown: false,
        selectedCustomerId: null,
        abortController: null,

        init() {
            // Kalau modal dibuka ulang dengan old('nama_lengkap') (habis validasi gagal),
            // jangan langsung buka dropdown — cukup biarkan nama terisi seperti biasa.
        },

        search() {
            const query = this.nama.trim();

            // Nama berubah manual -> anggap belum ada customer terpilih lagi,
            // sampai user pilih ulang dari dropdown.
            this.selectedCustomerId = null;

            if (query.length < 3) {
                this.results = [];
                this.showDropdown = false;
                return;
            }

            // Batalkan request sebelumnya kalau masih berjalan (hindari race condition
            // saat user mengetik cepat, mirip search bar google).
            if (this.abortController) {
                this.abortController.abort();
            }
            this.abortController = new AbortController();

            this.loading = true;

            fetch(`${this.searchUrl}?nama_lengkap=${encodeURIComponent(query)}`, {
                headers: { Accept: 'application/json' },
                signal: this.abortController.signal,
            })
                .then((res) => res.json())
                .then((customers) => {
                    this.loading = false;
                    this.results = Array.isArray(customers) ? customers : [];
                    this.showDropdown = this.results.length > 0;
                })
                .catch((error) => {
                    if (error.name !== 'AbortError') {
                        this.loading = false;
                    }
                });
        },

        selectCustomer(customer) {
            this.nama = customer.nama_lengkap;
            this.selectedCustomerId = customer.id;
            this.results = [];
            this.showDropdown = false;

            window.dispatchEvent(
                new CustomEvent('customer-found', {
                    detail: {
                        id: customer.id,
                        pendapatan_per_bulan: customer.pendapatan_per_bulan,
                    },
                })
            );
        },

        // Cuma untuk tampilan di daftar dropdown, bukan format resmi form.
        formatRupiahShort(value) {
            if (!value) {
                return 'Rp 0';
            }

            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0,
            }).format(value);
        },
    };
}