# Raspberry Pi API scaffold (belum menggerakkan motor)

API ini adalah kerangka penerima perintah. **Jangan hubungkan ke mesin nyata sebelum `driver_adapter.py` diimplementasikan dan diuji sesuai tipe motor/driver kamu.** Tipe Raspberry Pi dan driver belum disebutkan, jadi program ini sengaja fail-closed: perintah tidak dianggap berhasil jika adapter belum siap.

## Kontrak API
- `POST /api/control`
- Header: `Authorization: Bearer <secret>`
- JSON `{"action":"start","mode":"target_shooting","speed":"medium","interval_seconds":2,"direction":"center","request_id":"..."}`
- STOP: `{"action":"stop","request_id":"..."}`
- Configure: seperti start tetapi `action` bernilai `configure`.

## Menjalankan untuk pengembangan
1. Gunakan Raspberry Pi pada Wi-Fi/jaringan lokal tepercaya dan tetapkan IP lokal tetap/reservasi DHCP.
2. Buat virtual environment Python, instal `requirements.txt`.
3. Set environment `PINGPONG_API_TOKEN` ke secret acak panjang yang sama dengan `RASPBERRY_PI_TOKEN` di `.env` Laravel.
4. Implementasikan `driver_adapter.py` berdasarkan motor, driver, catu daya, limit switch, dan wiring yang sebenarnya.
5. Jalankan service hanya pada jaringan privat; batasi akses firewall agar hanya server Laravel yang bisa mengakses port API.
6. Jangan expose port ini langsung ke internet. Gunakan HTTPS/VPN jika kendali jarak jauh diperlukan.

Contoh token acak (buat sendiri, jangan pakai contoh publik): `python -c "import secrets; print(secrets.token_urlsafe(48))"`

**Keselamatan:** wajib sediakan emergency-stop fisik yang memutus/menghentikan penggerak dengan cara yang sesuai desain listrik. Tombol web tidak menggantikan emergency stop fisik. Implementasikan interlock, batas kecepatan, timeout watchdog, dan kondisi default motor OFF sebelum penggunaan nyata.
