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

    /* Modal styling */
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
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
      margin: 6% auto;
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

    .modal-content p {
      margin: 10px 0;
      line-height: 1.6;
    }

    .modal-content strong {
      color: #444;
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

  <h1>📅 Kalender Kegiatan Desa Takmung</h1>
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
    </div>
  </div>

  <!-- FullCalendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: async function(fetchInfo, successCallback, failureCallback) {
          try {
            const response = await fetch("http://127.0.0.1:8000/api/kalender/events", {
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
      var modal = document.getElementById('eventModal');
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>

</body>
</html>
