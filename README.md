# VELORA - Smart Skincare Assistant

<p align="center">
  <img src="tech stack.jpeg" alt="Application Architecture" width="700">
</p>

## Tentang VELORA

**Velora** adalah aplikasi berbasis website yang berfungsi sebagai **asisten perawatan kulit pintar**.  
Pengguna dapat mengunggah foto wajah mereka atau memanfaatkan kamera secara real-time untuk melakukan pemindaian kulit.  

Aplikasi ini akan menganalisis tipe kulit dan mendeteksi berbagai permasalahan seperti **jerawat, komedo, dan kemerahan**.  
Hasil analisis tersebut kemudian digunakan untuk memberikan **rekomendasi produk skincare** yang disesuaikan dengan kebutuhan kulit pengguna.  

Selain itu, **Velora** juga dilengkapi dengan fitur **chatbot konsultasi interaktif** yang bisa menjawab pertanyaan seputar skincare, mulai dari:  
- Urutan pemakaian produk  
- Keamanan bahan aktif  
- Kombinasi produk yang cocok  

Semua fitur didesain untuk menghadirkan pengalaman konsultasi dan perawatan kulit secara **holistik, cepat, dan akurat**.

---

## Arsitektur Aplikasi

Velora dibangun dengan teknologi modern yang menggabungkan **frontend, backend, AI, dan database**.

- **Frontend**: HTML, CSS, JavaScript  
- **Backend**: Laravel (PHP)  
- **AI’s API**: Flask + Gemini untuk analisis gambar  
- **Database**: MySQL  

Alur utama aplikasi:
1. **Pengguna** mengunggah foto atau menggunakan kamera.  
2. **Frontend** menampilkan tampilan dan mengirim data ke server.  
3. **Backend (Laravel)** memproses request, berinteraksi dengan **API AI (Flask, Gemini)** dan database.  
4. **Database (MySQL)** menyimpan data pengguna & hasil analisis.  
5. **Response** dikirim kembali ke frontend untuk ditampilkan.  

---

## Fitur Utama

✅ Pemindaian kulit real-time  
✅ Analisis jenis kulit & deteksi masalah (jerawat, komedo, kemerahan)  
✅ Rekomendasi produk skincare personal  
✅ Chatbot konsultasi interaktif  
✅ Tampilan modern, cepat, dan user-friendly  

---

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE). 


