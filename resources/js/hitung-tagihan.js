export class HitungTagihan {
    calculate(jumlahPinjaman, tenor) {
        jumlahPinjaman = Number(jumlahPinjaman);
        tenor = Number(tenor);

        if (!jumlahPinjaman || !tenor || tenor <= 0) {
            return 0;
        }

        return Math.ceil(jumlahPinjaman / tenor);
    }
}