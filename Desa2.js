// MENU MOBILE

const menuBtn =
  document.querySelector('.menu-btn');

const navLinks =
  document.querySelector('.nav-links');

menuBtn.addEventListener('click', () => {

  navLinks.classList.toggle('show');

});

// CLOSE MENU ON LINK CLICK

document.querySelectorAll('.nav-links a')
  .forEach(link => {

    link.addEventListener('click', () => {

      navLinks.classList.remove('show');

    });

  });

// FORM SUBMIT

const form =
  document.getElementById('form');

const success =
  document.getElementById('success');

form.addEventListener('submit', (e) => {

  e.preventDefault();

  success.innerText =
    '✅ Pesan Anda telah berhasil dikirim. Terima kasih telah menghubungi Pemerintah Desa Gumingsir.';

  form.reset();

  setTimeout(() => {
    success.innerText = '';
  }, 6000);

});

// CHART APBDes 2026 — data dari Website Resmi Desa Gumingsir

const ctx =
  document.getElementById('apbdesChart');

new Chart(ctx, {

  type: 'bar',

  data: {

    labels: [
      'Pendapatan Desa',
      'Total Belanja',
      'Pemberdayaan Masyarakat',
      'Belanja Pembangunan'
    ],

    datasets: [{

      label: 'APBDes Desa Gumingsir 2026 (Rupiah)',

      data: [
        697052000,     // Total Pendapatan Desa 2026
        2366079300,    // Total Belanja Desa 2026
        124646000,     // Pemberdayaan Masyarakat
        1314876300     // Belanja Pembangunan / Infrastruktur
      ],

      backgroundColor: [
        '#1f8a70',    // hijau — pendapatan
        '#0b1f3a',    // navy — total belanja
        '#f4b400',    // kuning — pemberdayaan
        '#123c69'     // biru tua — pembangunan
      ],

      borderRadius: 10,

      borderSkipped: false

    }]

  },

  options: {

    responsive: true,

    animation: {
      duration: 1000,
      easing: 'easeOutQuart'
    },

    plugins: {

      legend: {
        display: true,
        labels: {
          font: {
            family: 'Poppins',
            size: 13
          }
        }
      },

      tooltip: {
        callbacks: {
          label: function (context) {
            const val = context.parsed.y;
            return ' Rp ' + val.toLocaleString('id-ID');
          }
        }
      }

    },

    scales: {

      y: {

        ticks: {

          callback: function (value) {

            if (value >= 1000000000) {
              return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
            }

            return 'Rp ' + (value / 1000000).toFixed(0) + ' Jt';

          },

          font: {
            family: 'Poppins',
            size: 11
          }

        },

        grid: {
          color: 'rgba(0,0,0,0.06)'
        }

      },

      x: {

        ticks: {

          font: {
            family: 'Poppins',
            size: 11
          }

        },

        grid: {
          display: false
        }

      }

    }

  }

});

// SCROLL REVEAL ANIMASI RINGAN

const observer = new IntersectionObserver((entries) => {

  entries.forEach(entry => {

    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    }

  });

}, { threshold: 0.12 });

document.querySelectorAll('.card, .stat-card, .gallery img')
  .forEach(el => observer.observe(el));
