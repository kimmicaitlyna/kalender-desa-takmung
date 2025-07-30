<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kalender Kegiatan Desa Takmung</title>
  
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/id.global.min.js"></script>
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
      font-size: 2.2em;
      color: #2c3e50;
      font-weight: 600;
      margin-bottom: 25px;
    }

    #calendar {
      max-width: 1000px;
      width: 100%;
      background: #ffffff;
      padding: 20px;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .fc-event {
      background-color: #1976d2 !important;
      border: none;
      color: #fff !important;
      padding: 5px;
      border-radius: 6px;
      font-size: 0.85em;
      transition: all 0.2s ease-in-out;
    }

    .fc-event:hover {
      background-color: #1565c0 !important;
      transform: scale(1.03);
      cursor: pointer;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      overflow: auto;
    }

    .modal-content {
      background: white;
      margin: 8% auto;
      padding: 25px 30px;
      border-radius: 12px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      animation: slideUp 0.3s ease-out;
      position: relative;
    }

    .close {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 26px;
      font-weight: bold;
      color: #999;
      cursor: pointer;
    }

    .close:hover {
      color: #000;
    }

    .modal-content h2 {
      text-align: center;
      font-size: 1.5em;
      color: #2c3e50;
      margin-bottom: 20px;
    }

    .modal-content p {
      margin: 12px 0;
      font-size: 0.95em;
      line-height: 1.6;
    }

    .modal-content strong {
      color: #34495e;
    }

    @keyframes slideUp {
      from { transform: translateY(30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 1.8em;
        text-align: center;
      }

      .modal-content {
        padding: 20px;
        margin-top: 20%;
      }
    }
  </style>
</head>
<body>

  <h1>Kalender Kegiatan Desa Takmung</h1>
  <div id="calendar"></div>

  <div id="eventModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="document.getElementById('eventModal').style.display='none'" title="Tutup">&times;</span>
      <h2 id="eventTitle">Judul Kegiatan</h2>
      <p><strong>Tanggal:</strong> <span id="eventDate"></span></p>
      <p><strong>Lokasi:</strong> <span id="eventLokasi"></span></p>
      <p><strong>Jenis Peserta:</strong> <span id="eventJenisPeserta"></span></p>
      <p><strong>Jumlah Peserta:</strong> <span id="eventJumlahPeserta"></span></p>
      <p><strong>Keterangan:</strong> <span id="eventKeterangan"></span></p>
      <p><strong>Deskripsi:</strong> <span id="eventDescription"></span></p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

  <script>
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
            const response = await fetch("https://kalender.takmung.site/api/kalender/events");
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

    window.onclick = function(event) {
      const modal = document.getElementById('eventModal');
      if (event.target === modal) {
        modal.style.display = "none";
      }
    }
  </script>

</body>
</html>
