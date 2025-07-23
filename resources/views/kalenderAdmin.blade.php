<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Kalender Kegiatan Desa</title>

  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #ffe4e1, #fffaf0);
      color: #333;
      margin: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
    }

    h1 {
      color: #d84315;
      font-weight: 700;
      font-size: 2.5em;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
      margin-bottom: 10px;
    }

    #calendar {
      max-width: 1000px;
      width: 100%;
      background: #ffffffcc;
      padding: 25px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      backdrop-filter: blur(6px);
    }

    .fc-event {
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .fc-event:hover {
      transform: scale(1.03);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 9990;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.5);
      animation: fadeIn 0.3s ease-in-out;
    }

    .modal-content {
      background-color: #fff;
      margin: 5% auto;
      padding: 30px;
      border-radius: 12px;
      width: 90%;
      max-width: 600px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.2);
      animation: slideUp 0.3s ease-out;
      position: relative;
    }

    .close {
      position: absolute;
      top: 12px;
      right: 16px;
      color: #999;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover {
      color: #000;
    }

    .modal-content p,
    .modal-content label,
    .modal-content input,
    .modal-content textarea {
      width: 100%;
      margin: 10px 0;
      font-size: 1rem;
    }

    .modal-content input,
    .modal-content textarea {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    button.create-btn {
      background-color: #d84315;
      color: white;
      padding: 10px 18px;
      font-size: 1em;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      box-shadow: 0 3px 6px rgba(0,0,0,0.15);
      cursor: pointer;
      margin-bottom: 20px;
      transition: background-color 0.3s;
    }

    button.create-btn:hover {
      background-color: #c2370f;
    }

    button.submit-btn {
      background-color: #4CAF50;
      color: white;
      padding: 10px 16px;
      border: none;
      border-radius: 6px;
      font-size: 1em;
      cursor: pointer;
      margin-top: 15px;
    }

    .modal-footer {
      text-align: right;
      margin-top: 20px;
    }

    .modal-footer .btn-primary {
      background-color: #204ed5ff;
      color: white;
      border: none;
      padding: 10px 18px;
      font-size: 1em;
      border-radius: 8px;
      cursor: pointer;
      margin-right: 10px;
      transition: background-color 0.3s;
    }

    .modal-footer .btn-primary:hover {
      background-color: #080f6fff;
    }

    .modal-footer .btn-danger {
      background-color: #e53935;
      color: white;
      border: none;
      padding: 10px 18px;
      font-size: 1em;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .modal-footer .btn-danger:hover {
      background-color: #700404ff;
    }


    @keyframes fadeIn {
      from {opacity: 0;}
      to {opacity: 1;}
    }

    @keyframes slideUp {
      from {transform: translateY(30px); opacity: 0;}
      to {transform: translateY(0); opacity: 1;}
    }
  </style>
</head>
<body>

  <h1>Kalender Kegiatan Desa</h1>

  <button class="create-btn" onclick="openCreateModal()">+ Buat Kegiatan</button>

  <div id="calendar"></div>

  <!-- Modal Detail Kegiatan -->
  <div id="eventModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="document.getElementById('eventModal').style.display='none'" title="Tutup">&times;</span>
      <h2 id="eventTitle" style="text-align: center; margin-bottom: 15px;"></h2>
      <p><strong>Tanggal:</strong> <span id="eventDate"></span></p>
      <p><strong>Lokasi:</strong> <span id="eventLokasi"></span></p>
      <p><strong>Jenis Peserta:</strong> <span id="eventJenisPeserta"></span></p>
      <p><strong>Jumlah Peserta:</strong> <span id="eventJumlahPeserta"></span></p>
      <p><strong>Keterangan:</strong> <span id="eventKeterangan"></span></p>
      <p><strong>Deskripsi:</strong> <span id="eventDescription"></span></p>

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
        <input type="text" name="title" required>

        <label>Tanggal Mulai:</label>
        <input type="date" name="start" required>

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
        tanggalSelesai: form.end,
        lokasi: form.lokasi,
        jenisPeserta: form.jenisPeserta,
        jumlahPeserta: form.jumlahPeserta,
        keterangan: form.keterangan,
        deskripsi: form.description
      };


      try {
        const response = await fetch("http://127.0.0.1:8000/api/admin/create-kegiatan", {
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
        initialView: 'dayGridMonth',
        events: async function(fetchInfo, successCallback, failureCallback) {
          try {
            const response = await fetch("http://127.0.0.1:8000/api/admin/kegiatan", {
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

          selectedEventId = info.event.extendedProps.id;
          const props = info.event.extendedProps;
          const startDate = new Date(info.event.start);
          const endDate = info.event.end ? new Date(info.event.end) : null;

          const formatter = new Intl.DateTimeFormat('id-ID', {
              day: 'numeric',
              month: 'long',
              year: 'numeric'
          });

          let tanggalFormatted = formatter.format(startDate);
          if (endDate && endDate.toDateString() !== startDate.toDateString()) {
            tanggalFormatted += ` s.d ${formatter.format(endDate)}`;
          }

          document.getElementById('eventTitle').textContent = info.event.title;
          document.getElementById('eventDate').textContent = tanggalFormatted;
          document.getElementById('eventLokasi').textContent = props.lokasi || 'Tidak disebutkan';
          document.getElementById('eventJenisPeserta').textContent = props.jenisPeserta || 'Umum';
          document.getElementById('eventJumlahPeserta').textContent = props.jumlahPeserta || 'Tanpa Batas';
          document.getElementById('eventKeterangan').textContent = props.keterangan || '-';
          document.getElementById('eventDescription').textContent = props.description || '(Tidak ada deskripsi)';

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

      const konfirmasi = confirm("Apakah kamu yakin ingin menghapus kegiatan ini?");
      if (!konfirmasi) return;

      try {
        const response = await fetch(`http://127.0.0.1:8000/api/admin/delete-kegiatan/${selectedEventId}`, {
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


    // Tutup modal saat klik di luar konten
    window.onclick = function(event) {
      document.querySelectorAll('.modal').forEach(modal => {
        if (event.target == modal) modal.style.display = "none";
      });
    }
  </script>

</body>
</html>
