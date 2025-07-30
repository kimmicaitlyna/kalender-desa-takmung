<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Kalender Kegiatan Desa</title>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/id.global.min.js"></script>


  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
     body {
      font-family: 'Poppins', sans-serif;
      background: #f7f9fc;
      color: #333;
      margin: 0;
      padding: 30px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h1 {
      color: #444;
      font-weight: 600;
      font-size: 2.2em;
      margin-bottom: 20px;
      text-align: center;
    }

    #createModal, #eventModal {
      z-index: 1000;
    }

    .modal {
      display: none;
      position: fixed;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.5);
      overflow: auto;
      animation: fadeIn 0.3s ease-in-out;
    }

    .modal-content {
      background-color: #fff;
      border-radius: 12px;
      padding: 30px;
      width: 95%;
      max-width: 600px;
      margin: 50px auto;
      position: relative;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    label {
      margin-top: 15px;
      font-weight: 500;
      display: block;
    }

    input, textarea {
      margin-top: 5px;
      padding: 10px;
      font-size: 0.95em;
      border-radius: 6px;
      border: 1px solid #ccc;
      width: 100%;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
    }

    .submit-btn, .btn-primary, .btn-danger {
      padding: 10px 16px;
      font-size: 1em;
      font-weight: 500;
      border-radius: 8px;
      border: none;
      cursor: pointer;
    }

    .submit-btn {
      background-color: #388e3c;
      color: #fff;
      margin-top: 20px;
    }

    .btn-primary {
      background-color: #1976d2;
      color: white;
      margin-right: 10px;
    }

    .btn-primary:hover {
      background-color: #125ea9;
    }

    .btn-danger {
      background-color: #e53935;
      color: white;
    }

    .btn-danger:hover {
      background-color: #c62828;
    }

    .close {
      position: absolute;
      top: 12px;
      right: 20px;
      font-size: 26px;
      color: #aaa;
      cursor: pointer;
    }

    .close:hover {
      color: #000;
    }

    .fc-event {
      background-color: #1976d2 !important;
      border: none;
      color: white !important;
      padding: 5px 10px;
      border-radius: 6px;
      transition: 0.2s;
    }

    .fc-event:hover {
      background-color: #125ea9 !important;
      transform: scale(1.02);
    }

    #calendar {
      max-width: 1000px;
      width: 100%;
      background: #fff;
      padding: 20px;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      margin-top: 20px;
    }

    .create-btn {
      align-self: flex-end;
      background-color: #1976d2;
      color: #fff;
      border: none;
      padding: 10px 18px;
      font-weight: 600;
      font-size: 1em;
      border-radius: 8px;
      transition: background 0.3s;
      cursor: pointer;
      margin-bottom: 10px;
    }

    .create-btn:hover {
      background-color: #125ea9;
    }

    @media (max-width: 600px) {
      .modal-content {
        padding: 20px;
      }

      h1 {
        font-size: 1.8em;
      }

      .create-btn {
        width: 100%;
        text-align: center;
      }

      #calendar {
        padding: 15px;
      }
    }


  </style>
</head>
<body>

  <h1>Kalender Kegiatan Desa</h1>

  <div style="text-align: center; margin: 20px 0;">
    <button class="create-btn" onclick="openCreateModal()">+ Buat Kegiatan</button>
  </div>

  <div id="calendar"></div>

  <!-- Modal Detail Kegiatan -->
  <div id="eventModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="document.getElementById('eventModal').style.display='none'" title="Tutup">&times;</span>
      <h2><input type="text" class="form-control" id="eventTitleInput" name="eventTitle"></h2>
      <p><strong>Tanggal Mulai:</strong></p>
      <input type="date" class="form-control" id="eventDateInput" name="eventDate">
      <p><strong>Tanggal Selesai:</strong></p>
      <input type="date" class="form-control" id="eventDateEndInput" name="eventDateEnd">
      <p><strong>Lokasi:</strong></p>
      <input type="text" class="form-control" id="eventLokasiInput" name="lokasi">
      <p><strong>Jenis Peserta:</strong></p>
      <input type="text" class="form-control" id="eventJenisPesertaInput" name="eventJenisPeserta">
      <p><strong>Jumlah Peserta:</strong></p>
      <input type="text" class="form-control" id="eventJumlahPesertaInput" name="eventJumlahPeserta">
      <p><strong>Keterangan:</strong></p>
      <input type="text" class="form-control" id="eventKeteranganInput" name="eventKeterangan">
      <p><strong>Deskripsi:</strong></p>
      <input type="text" class="form-control" id="eventDescriptionInput" name="eventDescription">

      <div class="modal-footer" style="text-align: right; margin-top: 20px;">
        <button type="button" class="btn btn-primary">Simpan Perubahan</button>
        <button type="button" class="btn btn-danger">Hapus Kegiatan</button>
      </div>
    </div>
  </div>

  <!-- Modal Form Create Kegiatan -->
  <div id="createModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="document.getElementById('createModal').style.display='none'">&times;</span>
      <h2>Buat Kegiatan Baru</h2>
      <form id="createForm">
        <label>Judul:</label>
        <input type="text" name="title">

        <label>Tanggal Mulai:</label>
        <input type="date" name="start">

        <label>Tanggal Selesai:</label>
        <input type="date" name="end">

        <label>Lokasi:</label>
        <input type="text" name="lokasi">

        <label>Jenis Peserta:</label>
        <input type="text" name="jenisPeserta">

        <label>Jumlah Peserta:</label>
        <input type="number" name="jumlahPeserta">

        <label>Keterangan:</label>
        <input type="text" name="keterangan">

        <label>Deskripsi:</label>
        <textarea name="description" rows="4"></textarea>

        <button type="submit" class="submit-btn">Simpan</button>
      </form>
    </div>
  </div>

  <!-- FullCalendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

  <script>
    const token = localStorage.getItem("adminToken");
    let selectedEventId = null; 
    
    if (!token) {
        alert("Akses ditolak. Anda belum login.");
        window.location.href = "/admin/login";
    }

    function openCreateModal() {
      document.getElementById('createModal').style.display = 'block';
    }

    document.getElementById("createForm").addEventListener("submit", async function(e) {
      e.preventDefault();
      const formData = new FormData(e.target);
      const form = Object.fromEntries(formData.entries());

      const data = {
        judul: form.title,
        tanggalMulai: form.start,
        tanggalSelesai: form.end || form.start,
        lokasi: form.lokasi,
        jenisPeserta: form.jenisPeserta || "Umum",
        jumlahPeserta: form.jumlahPeserta || "1000",
        keterangan: form.keterangan || "-",
        deskripsi: form.description || "-"
      };

      if (!form.title) {
        alert("Judul wajib diisi.");
        return;
      }

      if (!form.start || !form.end) {
        alert("Tanggal wajib diisi.");
        return;
      }

      if (!form.lokasi) {
        alert("Lokasi wajib diisi.");
        return;
      }

      if (form.end < form.start) {
        alert("Tanggal selesai tidak boleh lebih awal dari tanggal mulai.");
        return;
      }

      try {
        const response = await fetch("https://kalender.takmung.site/api/admin/create-kegiatan", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + token
          },
          body: JSON.stringify(data)
        });

        const result = await response.json();
        if (response.ok) {
          alert("Kegiatan berhasil dibuat!");
          location.reload();
        } else {
          alert("Gagal menyimpan kegiatan: " + result.message);
        }
      } catch (error) {
        alert("Kesalahan koneksi.");
      }
    });

    document.addEventListener('DOMContentLoaded', function () {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'id',
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: ''
        },
        events: async function(fetchInfo, successCallback, failureCallback) {
          try {
            const response = await fetch("https://kalender.takmung.site/api/admin/kegiatan", {
              headers: { "Authorization": "Bearer " + token }
            });

            if (!response.ok) throw new Error("Gagal ambil data");

            const data = await response.json();
            successCallback(data);
          } catch (error) {
            console.error("Gagal memuat kegiatan:", error);
            failureCallback(error);
          }
        },
        eventClick: function(info) {
          info.jsEvent.preventDefault();

          selectedEventId = info.event.id;
          const props = info.event.extendedProps;
          const startDate = new Date(info.event.start);
          const endDate = info.event.end ? new Date(info.event.end) : null;

          const startISO = info.event.startStr;
          const endISO = info.event.endStr;


          document.getElementById('eventTitleInput').value = info.event.title;
          document.getElementById('eventDateInput').value = props.tanggalMulaiAsli ;
          document.getElementById('eventDateEndInput').value = props.tanggalSelesaiAsli; 
          document.getElementById('eventLokasiInput').value = props.lokasi;
          document.getElementById('eventJenisPesertaInput').value = props.jenisPeserta || 'Umum';
          document.getElementById('eventJumlahPesertaInput').value = props.jumlahPeserta || '1000';
          document.getElementById('eventKeteranganInput').value = props.keterangan || '-';
          document.getElementById('eventDescriptionInput').value = props.description || '-';

          document.getElementById('eventModal').style.display = 'block';
        }
      });

      calendar.render();
    });

    document.querySelector(".btn-danger").addEventListener("click", async function () {
      if (!selectedEventId) {
        alert("ID kegiatan tidak ditemukan.");
        return;
      }

      const konfirmasi = confirm("Apakah Anda yakin ingin menghapus kegiatan ini?");
      if (!konfirmasi) return;

      try {
        const response = await fetch(`https://kalender.takmung.site/api/admin/delete-kegiatan/${selectedEventId}`, {
          method: "DELETE",
          headers: {
            "Authorization": "Bearer " + token
          }
        });

        const result = await response.json();

        if (response.ok) {
          alert("Kegiatan berhasil dihapus.");
          location.reload();
        } else {
          alert("Gagal menghapus kegiatan: " + result.message);
        }
      } catch (error) {
        alert("Gagal menghubungi server.");
      }
    });

    document.querySelector(".btn-primary").addEventListener("click", async function () {
      if (!selectedEventId) {
        alert("ID kegiatan tidak ditemukan.");
        return;
      }

      const konfirmasi = confirm("Apakah Anda yakin ingin mengubah kegiatan ini?");
      if (!konfirmasi) return;

      const judul = document.getElementById("eventTitleInput").value;
      const tanggalMulai = document.getElementById("eventDateInput").value;
      const tanggalSelesai = document.getElementById("eventDateEndInput").value;
      const deskripsi = document.getElementById("eventDescriptionInput").value;
      const lokasi = document.getElementById("eventLokasiInput").value;
      const keterangan = document.getElementById("eventKeteranganInput").value;
      const jenisPeserta = document.getElementById("eventJenisPesertaInput").value;
      const jumlahPeserta = document.getElementById("eventJumlahPesertaInput").value;

      if (tanggalSelesai < tanggalMulai) {
        alert("Tanggal selesai tidak boleh lebih awal dari tanggal mulai.");
        return;
      }

      try {
        const response = await fetch(`https://kalender.takmung.site/api/admin/update-kegiatan/${selectedEventId}`, {
          method: "PUT",
          headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + token
          },
          body: JSON.stringify({
            judul,
            tanggalMulai,
            tanggalSelesai,
            deskripsi,
            lokasi,
            keterangan,
            jenisPeserta,
            jumlahPeserta
          })
        });

        const result = await response.json();

        if (response.ok) {
          alert("Kegiatan berhasil diupdate.");
          location.reload();
        } else {
          alert("Gagal mengupdate kegiatan: " + result.message);
        }
      } catch (error) {
        alert("Gagal menghubungi server.");
      }
    });


    // Tutup modal saat klik di luar konten
    window.onclick = function(event) {
      document.querySelectorAll('.modal').forEach(modal => {
        if (event.target == modal) modal.style.display = "none";
      });
    }
  </script>

</body>
</html>
