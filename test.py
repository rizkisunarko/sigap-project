# ==========================================
# PENJADWALAN SHIFT KARYAWAN
# TANPA LIBRARY
# LIBUR DINAMIS
# ==========================================

# ==========================================
# DATA KARYAWAN
# ==========================================

karyawan = {
    "A": "L",
    "B": "P",
    "C": "L",
    "D": "P",
    "E": "L",
    "F": "L",
    "G": "P",
    "H": "L",
    "I": "P",
    "J": "L"
}

# ==========================================
# DATA SHIFT
# ==========================================

shift_list = ["Pagi", "Siang", "Malam"]

# ==========================================
# JUMLAH HARI
# ==========================================

jumlah_hari = 30

# ==========================================
# MENYIMPAN TOTAL SHIFT
# ==========================================

jumlah_shift = {}

for nama in karyawan:
    jumlah_shift[nama] = 0

# ==========================================
# MENYIMPAN TOTAL LIBUR
# ==========================================

jumlah_libur = {}

for nama in karyawan:
    jumlah_libur[nama] = 0

# ==========================================
# MENYIMPAN DATA LIBUR
# ==========================================

hari_libur = {}

for nama in karyawan:
    hari_libur[nama] = []

# ==========================================
# MENYIMPAN JADWAL
# ==========================================

jadwal = {}

# ==========================================
# FUNGSI VALIDASI
# ==========================================

def cek_minimal_orang(shift_data):

    for shift in shift_list:

        if len(shift_data[shift]) < 2:
            return False

    return True


def cek_gender(shift_data):

    for shift in shift_list:

        ada_laki = False

        for nama in shift_data[shift]:

            if karyawan[nama] == "L":
                ada_laki = True

        if ada_laki == False:
            return False

    return True


def cek_double_shift(shift_data):

    sudah_kerja = []

    for shift in shift_list:

        for nama in shift_data[shift]:

            if nama in sudah_kerja:
                return False

            sudah_kerja.append(nama)

    return True


def validasi_jadwal(shift_data):

    if cek_minimal_orang(shift_data) == False:
        return False

    if cek_gender(shift_data) == False:
        return False

    if cek_double_shift(shift_data) == False:
        return False

    return True

# ==========================================
# MEMILIH KARYAWAN LIBUR
# ==========================================

def pilih_libur(hari):

    daftar_libur = []

    # ======================================
    # SORT BERDASARKAN LIBUR PALING SEDIKIT
    # ======================================

    kandidat = list(karyawan.keys())

    kandidat.sort(
        key=lambda x: jumlah_libur[x]
    )

    # ======================================
    # MAKSIMAL 2 ORANG LIBUR PER HARI
    # ======================================

    index = 0

    while len(daftar_libur) < 2:

        if index >= len(kandidat):
            break

        nama = kandidat[index]

        # maksimal 4 hari libur
        if jumlah_libur[nama] < 4:

            daftar_libur.append(nama)

            jumlah_libur[nama] += 1

            hari_libur[nama].append(hari)

        index += 1

    return daftar_libur

# ==========================================
# MEMBUAT JADWAL HARIAN
# ==========================================

def buat_jadwal_harian(hari):

    shift_data = {
        "Pagi": [],
        "Siang": [],
        "Malam": []
    }

    # ======================================
    # PILIH YANG LIBUR
    # ======================================

    libur_hari_ini = pilih_libur(hari)

    # ======================================
    # KARYAWAN AKTIF
    # ======================================

    karyawan_aktif = []

    for nama in karyawan:

        if nama not in libur_hari_ini:
            karyawan_aktif.append(nama)

    # ======================================
    # SORT BERDASARKAN SHIFT PALING SEDIKIT
    # ======================================

    karyawan_aktif.sort(
        key=lambda x: jumlah_shift[x]
    )

    index = 0

    # ======================================
    # ISI SHIFT
    # ======================================

    for shift in shift_list:

        while len(shift_data[shift]) < 2:

            nama = karyawan_aktif[index]

            # cek double shift
            sudah_kerja = False

            for s in shift_list:

                if nama in shift_data[s]:
                    sudah_kerja = True

            if sudah_kerja == False:

                shift_data[shift].append(nama)

                jumlah_shift[nama] += 1

            index += 1

    # ======================================
    # VALIDASI
    # ======================================

    if validasi_jadwal(shift_data):

        return shift_data

    else:

        return None

# ==========================================
# MEMBUAT JADWAL 1 BULAN
# ==========================================

for hari in range(1, jumlah_hari + 1):

    jadwal[hari] = buat_jadwal_harian(hari)

# ==========================================
# TAMPILKAN HASIL
# ==========================================

for hari in jadwal:

    print("\n================================")
    print("HARI", hari)
    print("================================")

    print("\nLIBUR:")

    for nama in hari_libur:

        if hari in hari_libur[nama]:
            print("-", nama)

    data = jadwal[hari]

    for shift in shift_list:

        print("\nShift", shift)

        for nama in data[shift]:

            print(
                "-",
                nama,
                "(" + karyawan[nama] + ")"
            )

# ==========================================
# TOTAL SHIFT
# ==========================================

print("\n================================")
print("TOTAL SHIFT")
print("================================")

for nama in jumlah_shift:

    print(
        nama,
        "=",
        jumlah_shift[nama]
    )

# ==========================================
# TOTAL LIBUR
# ==========================================

print("\n================================")
print("TOTAL LIBUR")
print("================================")

for nama in jumlah_libur:

    print(
        nama,
        "=",
        jumlah_libur[nama]
    )