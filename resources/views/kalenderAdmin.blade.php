<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kalender Kegiatan Desa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- FullCalendar CSS & JS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/id.global.min.js"></script>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f7f9fc;
      margin: 0;
      padding: 20px;
      color: #333;
    }

    h1 {
      text-align: center;
      font-size: 2.2em;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .btn {
      padding: 10px 18px;
      font-size: 1em;
      font-weight: 600;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      transition: 0.2s;
    }

    .btn-primary {
      background-color: #1976d2;
      color: white;
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

    .btn-create {
      display: inline-block;
      margin: 20px 0;
      background-color: #1976d2;
      color: #fff;
      border: none;
      padding: 10px 18px;
      font-weight: 600;
      font-size: 1em;
      border-radius: 8px;
      cursor: pointer;
    }

    .btn-create:hover {
      background-color: #125ea9;
    }

    .logout-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      background-color: #c60000;
      color: #fff;
      border: none;
      padding: 10px 16px;
      font-weight: 600;
      border-radius: 8px;
      cursor: pointer;
    }

    #calendar {
      max-width: 1000px;
      margin: auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .fc-event {
      background-color: #1976d2 !important;
      color: white !important;
      border: none;
      border-radius: 6px;
      padding: 4px 8px;
      font-size: 0.9em;
    }

    .modal {
      display: none;
      position: fixed;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.4);
      z-index: 1000;
      overflow-y: auto;
    }

    .modal-content {
      background-color: #fff;
      margin: 5% auto;
      padding: 30px;
      border-radius: 12px;
      width: 95%;
      max-width: 600px;
      position: relative;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    .modal-content label {
      display: block;
      margin-top: 12px;
      font-weight: 500;
    }

    .modal-content input,
    .modal-content textarea {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      font-size: 0.95em;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    .modal-content textarea {
      resize: vertical;
    }

    .modal-footer {
      text-align: right;
      margin-top: 20px;
    }

    .close {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 26px;
      color: #888;
      cursor: pointer;
    }

    .close:hover {
      color: #000;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 1.8em;
      }

      .logout-btn {
        top: 10px;
        right: 10px;
        font-size: 0.9em;
        padding: 8px 14px;
      }
    }
  </style>
</head>
<body>

  <button class="logout-btn" id="logoutBtn">Logout</button>

  <h1>Kalender Kegiatan Desa</h1>

  <div style="text-align:center;">
    <button class="btn-create" onclick="openCreateModal()">+ Buat Kegiatan</button>
  </div>

  <div id="calendar"></div>

  <!-- Modals: Create and Edit/Detail -->
  <div id="createModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('createModal')">&times;</span>
      <h2>Buat Kegiatan Baru</h2>
      <form id="createForm">
        <label>Judul</label>
        <input type="text" name="title" required>

        <label>Tanggal Mulai</label>
        <input type="date" name="start" required>

        <label>Tanggal Selesai</label>
        <input type="date" name="end" required>

        <label>Lokasi</label>
        <input type="text" name="lokasi" required>

        <label>Jenis Peserta</label>
        <input type="text" name="jenisPeserta">

        <label>Jumlah Peserta</label>
        <input type="number" name="jumlahPeserta">

        <label>Keterangan</label>
        <input type="text" name="keterangan">

        <label>Deskripsi</label>
        <textarea name="description" rows="4"></textarea>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <div id="eventModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('eventModal')">&times;</span>
      <h2>Edit Kegiatan</h2>

      <label>Judul</label>
      <input type="text" id="eventTitleInput">

      <label>Tanggal Mulai</label>
      <input type="date" id="eventDateInput">

      <label>Tanggal Selesai</label>
      <input type="date" id="eventDateEndInput">

      <label>Lokasi</label>
      <input type="text" id="eventLokasiInput">

      <label>Jenis Peserta</label>
      <input type="text" id="eventJenisPesertaInput">

      <label>Jumlah Peserta</label>
      <input type="number" id="eventJumlahPesertaInput">

      <label>Keterangan</label>
      <input type="text" id="eventKeteranganInput">

      <label>Deskripsi</label>
      <textarea id="eventDescriptionInput" rows="4"></textarea>

      <div class="modal-footer">
        <button class="btn btn-primary" onclick="updateEvent()">Simpan Perubahan</button>
        <button class="btn btn-danger" onclick="deleteEvent()">Hapus Kegiatan</button>
      </div>
    </div>
  </div>

  <!-- JS Logic -->
  <script>
    const token = localStorage.getItem("adminToken");
    let selectedEventId = null;

    function openCreateModal() {
      document.getElementById('createModal').style.display = 'block';
    }

    function closeModal(modalId) {
      document.getElementById(modalId).style.display = 'none';
    }

    window.onclick = function(e) {
      if (e.target.classList.contains("modal")) {
        e.target.style.display = "none";
      }
    }

    document.getElementById("createForm").addEventListener("submit", async function(e) {
      e.preventDefault();
      const form = Object.fromEntries(new FormData(this).entries());

      const payload = {
        judul: form.title,
        tanggalMulai: form.start,
        tanggalSelesai: form.end,
        lokasi: form.lokasi,
        jenisPeserta: form.jenisPeserta || "Umum",
        jumlahPeserta: form.jumlahPeserta || "100",
        keterangan: form.keterangan || "-",
        deskripsi: form.description || "-"
      };

      try {
        const res = await fetch("https://kalender.takmung.site/api/admin/create-kegiatan", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + token
          },
          body: JSON.stringify(payload)
        });

        const result = await res.json();
        if (res.ok) {
          alert("Kegiatan berhasil dibuat.");
          location.reload();
        } else {
          alert("Gagal: " + result.message);
        }
      } catch {
        alert("Gagal menghubungi server.");
      }
    });

    function updateEvent() {
      const payload = {
        judul: document.getElementById("eventTitleInput").value,
        tanggalMulai: document.getElementById("eventDateInput").value,
        tanggalSelesai: document.getElementById("eventDateEndInput").value,
        lokasi: document.getElementById("eventLokasiInput").value,
        jenisPeserta: document.getElementById("eventJenisPesertaInput").value,
        jumlahPeserta: document.getElementById("eventJumlahPesertaInput").value,
        keterangan: document.getElementById("eventKeteranganInput").value,
        deskripsi: document.getElementById("eventDescriptionInput").value
      };

      fetch(`https://kalender.takmung.site/api/admin/update-kegiatan/${selectedEventId}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          "Authorization": "Bearer " + token
        },
        body: JSON.stringify(payload)
      })
      .then(res => res.json())
      .then(data => {
        alert("Berhasil diperbarui");
        location.reload();
      })
      .catch(() => alert("Gagal memperbarui data"));
    }

    function deleteEvent() {
      if (!confirm("Yakin ingin menghapus kegiatan ini?")) return;

      fetch(`https://kalender.takmung.site/api/admin/delete-kegiatan/${selectedEventId}`, {
        method: "DELETE",
        headers: { "Authorization": "Bearer " + token }
      })
      .then(res => res.json())
      .then(data => {
        alert("Kegiatan dihapus.");
        location.reload();
      })
      .catch(() => alert("Gagal menghapus kegiatan."));
    }

    document.getElementById("logoutBtn").addEventListener("click", () => {
      if (!confirm("Yakin ingin logout?")) return;

      fetch("https://kalender.takmung.site/api/admin/logout", {
        method: "POST",
        headers: { "Authorization": "Bearer " + token }
      }).then(res => res.json())
        .then(() => {
          localStorage.removeItem("adminToken");
          window.location.href = "/admin/login";
        }).catch(() => alert("Logout gagal."));
    });

    document.addEventListener('DOMContentLoaded', function () {
      const calendarEl = document.getElementById('calendar');

      const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'id',
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: ''
        },
        events: async function(fetchInfo, successCallback, failureCallback) {
          try {
            const res = await fetch("https://kalender.takmung.site/api/admin/kegiatan", {
              headers: { "Authorization": "Bearer " + token }
            });
            const data = await res.json();
            successCallback(data);
          } catch (err) {
            console.error("Fetch error:", err);
            failureCallback(err);
          }
        },
        eventClick: function(info) {
          const props = info.event.extendedProps;
          selectedEventId = info.event.id;

          document.getElementById("eventTitleInput").value = info.event.title;
          document.getElementById("eventDateInput").value = props.tanggalMulaiAsli;
          document.getElementById("eventDateEndInput").value = props.tanggalSelesaiAsli;
          document.getElementById("eventLokasiInput").value = props.lokasi;
          document.getElementById("eventJenisPesertaInput").value = props.jenisPeserta;
          document.getElementById("eventJumlahPesertaInput").value = props.jumlahPeserta;
          document.getElementById("eventKeteranganInput").value = props.keterangan;
          document.getElementById("eventDescriptionInput").value = props.description;

          document.getElementById("eventModal").style.display = "block";
        }
      });

      calendar.render();
    });
  </script>
</body>
</html>
