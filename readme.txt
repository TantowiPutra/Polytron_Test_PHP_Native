*updated_at dan created_at menggunakan DATETIME
*primary key set menggunakan id
*field id menggunakan bigint dan atribute unsigned
*column pada datase harus menggunakan bahasa yang konsisten
*validasi kode bukti belum sesuai
*kode bukti terisi secara otomatis (ketika mengklik salah satu proses bukti)
*nama produk tidak perlu unique
*prog dibuat komplit (bukan inisial dari proses)
*ignore extra space pada akhir dan awal kata
*validasi panjang karakter yang di input menyesuaikan dengan ukuran varchar pada database
*bug number format tidak boleh negatif
*seluruh field secara default uppercase agar konsisten
*tabel Stok Produk Total berubah mengikuti filter yang diberikan
*jika salah input ataupun ketika sukses input, data pada form tidak hilang
*error message dibuat position fixed agar tidak merubah tampilan form
*tambahkan filter sesuai dengan kriteria soal
*tambahkan pagination

(Fixed) Bug insert data melewati validasi
(Fixed) Bug kode bukti tidak unique (tembus validasi)

ON PROGRESS:
format validasi tanggal dan input harus dalam dmY
tambahkan approvement apabila melakukan penambahan produk baru
nama produk terisi otomatis ketika melakukan seleksi pada kode item

IMPORTANT: 
*menampilkan error yang jelas
*query dibuat lebih efektif

list kata indo:
1. bukti
2. tgl_masuk
3. saldo

Pagination compontent (transaction history)
Note: Bisa menggunakan DataTables (library jQuery untuk pembuatan pagination)
