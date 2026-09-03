import { HitungTagihan } from '../hitung-tagihan';

export function formTagihan(initialValues = {}) {
    const calculator = new HitungTagihan();
    const nominalPengajuan = String(initialValues.nominalPengajuan || '');
    const pendapatanPerBulan = String(initialValues.pendapatanPerBulan || '');

    return {
        nominalPengajuan: nominalPengajuan.replace(/\D/g, ''),
        nominalPengajuanDisplay: formatThousands(nominalPengajuan),
        pendapatanPerBulan: pendapatanPerBulan.replace(/\D/g, ''),
        pendapatanPerBulanDisplay: formatThousands(pendapatanPerBulan),
        tenor: '',
        estimasiTagihan: 0,

        updateNominal(value) {
            this.nominalPengajuan = value.replace(/\D/g, '');
            this.nominalPengajuanDisplay = formatThousands(this.nominalPengajuan);
            this.calculateInstallment();
        },

        updatePendapatan(value) {
            this.pendapatanPerBulan = value.replace(/\D/g, '');
            this.pendapatanPerBulanDisplay = formatThousands(this.pendapatanPerBulan);
        },

        calculateInstallment() {
            this.estimasiTagihan = calculator.calculate(
                this.nominalPengajuan,
                this.tenor
            );
        },

        formatRupiah(value) {
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

function formatThousands(value) {
    const digits = String(value).replace(/\D/g, '');

    return digits ? new Intl.NumberFormat('id-ID').format(Number(digits)) : '';
}