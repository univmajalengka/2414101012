<?php
// 1. Membuat fungsi hitungDiskon()
function hitungDiskon($totalBelanja)
{
    // 2. Logika Diskon
    if ($totalBelanja >= 100000) {
        $diskon = $totalBelanja * 0.10; // 10%
    } elseif ($totalBelanja >= 50000 && $totalBelanja < 100000) {
        $diskon = $totalBelanja * 0.05; // 5%
    } else {
        $diskon = 0; // Tidak ada diskon
    }

    // 3. Return nilai diskon dalam bentuk nominal
    return $diskon;
}

// 4. Eksekusi program
$totalBelanja = 120000;                   // Contoh nilai
$diskon = hitungDiskon($totalBelanja);    // Memanggil fungsi
$totalBayar = $totalBelanja - $diskon;    // Menghitung total bayar

// Menampilkan hasil
echo "=== PERHITUNGAN DISKON ===<br>";
echo "Total Belanja : Rp " . number_format($totalBelanja, 0, ',', '.') . "<br>";
echo "Diskon        : Rp " . number_format($diskon, 0, ',', '.') . "<br>";
echo "Total Bayar   : Rp " . number_format($totalBayar, 0, ',', '.') . "<br>";
?>