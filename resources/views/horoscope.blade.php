<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="UTF-8">
  <title>Horòscop Interactiu</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Iconify per als icones zodiacals -->
  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
  <style>
    body {
      background: #f0f2f5;
    }

    .card-custom:hover {
      transform: translateY(-5px);
      transition: transform 0.3s ease;
    }

    .card-custom {
      transition: transform 0.3s ease;
    }
  </style>
</head>

<body>
  <!-- Barra de Navegació -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
    <div class="container">
      <a class="navbar-brand" href="#">
        <i class="bi bi-moon-stars-fill"></i> Horòscop Interactiu
      </a>
    </div>
  </nav>

  <div class="container">
    <!-- Formulari per consultar horòscop -->
    <div class="card mb-4 shadow-sm">
      <div class="card-body">
        <h3 class="card-title mb-3">Consulta el teu horòscop</h3>
        <div class="row g-3">
          <div class="col-md-4">
            <label for="sign" class="form-label">Signa</label>
            <select id="sign" class="form-select">
              @foreach(['aquarius','pisces','aries','taurus','gemini','cancer','leo','virgo','libra','scorpio','sagittarius','capricorn'] as $s)
                <option value="{{ $s }}">{{ ucfirst($s) }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="lang" class="form-label">Idioma</label>
            <select id="lang" class="form-select">
              @foreach(['es'=>'Castellà','ca'=>'Català','pt'=>'Portuguès','it'=>'Italià','fr'=>'Francès','de'=>'Alemany','nl'=>'Holandès','pl'=>'Polonès','ru'=>'Rus'] as $code => $name)
                <option value="{{ $code }}">{{ $name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="time" class="form-label">Període</label>
            <select id="time" class="form-select">
              @foreach(['today'=>'Avui','yesterday'=>'Ahir','week'=>'Setmana','month'=>'Mes'] as $t => $label)
                <option value="{{ $t }}">{{ $label }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="mt-4 text-center">
          <button id="search-btn" class="btn btn-primary">
            <i class="bi bi-search"></i> Consultar
          </button>
        </div>
      </div>
    </div>

    <!-- Resultat de predicció personalitzada -->
    <div id="result" class="mb-4" style="display:none;"></div>

    <!-- Grid per mostrar els horòscops diaris -->
    <div id="daily-grid" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"></div>

    <!-- Indicador de "Loading" -->
    <div id="loading" class="text-center" style="display:none;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregant...</span>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center text-muted py-3 mt-5 border-top">
    © 2025 Horòscop Interactiu. Tots els drets reservats.
  </footer>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", async () => {
      const signs = [{
          name: "aquarius",
          icon: "mdi:zodiac-aquarius"
        },
        {
          name: "pisces",
          icon: "mdi:zodiac-pisces"
        },
        {
          name: "aries",
          icon: "mdi:zodiac-aries"
        },
        {
          name: "taurus",
          icon: "mdi:zodiac-taurus"
        },
        {
          name: "gemini",
          icon: "mdi:zodiac-gemini"
        },
        {
          name: "cancer",
          icon: "mdi:zodiac-cancer"
        },
        {
          name: "leo",
          icon: "mdi:zodiac-leo"
        },
        {
          name: "virgo",
          icon: "mdi:zodiac-virgo"
        },
        {
          name: "libra",
          icon: "mdi:zodiac-libra"
        },
        {
          name: "scorpio",
          icon: "mdi:zodiac-scorpio"
        },
        {
          name: "sagittarius",
          icon: "mdi:zodiac-sagittarius"
        },
        {
          name: "capricorn",
          icon: "mdi:zodiac-capricorn"
        }
      ];

      const grid = document.getElementById("daily-grid");
      const langSelector = document.getElementById("lang");
      const signSelector = document.getElementById("sign");
      const timeSelector = document.getElementById("time");
      const result = document.getElementById("result");
      const loadingIndicator = document.getElementById("loading");

      let currentLang = langSelector.value;
      let activeRequestId = 0;

      function loadingCard() {
        return `
          <div class="col">
            <div class="card card-custom">
              <div class="card-body">
                <h5 class="card-title placeholder-glow">
                  <span class="placeholder col-6"></span>
                </h5>
                <p class="card-text placeholder-glow">
                  <span class="placeholder col-7"></span>
                  <span class="placeholder col-4"></span>
                  <span class="placeholder col-4"></span>
                  <span class="placeholder col-6"></span>
                  <span class="placeholder col-8"></span>
                </p>
              </div>
            </div>
          </div>
        `;
      }

      function clearGrid() {
        grid.innerHTML = signs.map(() => loadingCard()).join("");
      }

      async function loadDailyHoroscope(lang) {
        const requestId = ++activeRequestId;
        clearGrid();

        try {
          const res = await fetch(`/horoscope/all?lang=${lang}&time=today`);
          const data = await res.json();

          if (requestId !== activeRequestId) return;

          const predictionsBySign = Object.fromEntries(data.map(item => [item.sign.toLowerCase(), item.prediction]));

          let cardsHtml = '';
          signs.forEach(sign => {
            const prediction = predictionsBySign[sign.name] || 'No prediction available.';
            cardsHtml += `
              <div class="col">
                <div class="card card-custom h-100 shadow-sm">
                  <div class="card-body">
                    <h5 class="card-title">
                      <span class="iconify" data-icon="${sign.icon}"></span> ${sign.name}
                    </h5>
                    <p class="card-text">${prediction}</p>
                  </div>
                </div>
              </div>
            `;
          });
          grid.innerHTML = cardsHtml;

        } catch (error) {
          console.error("Error loading horoscopes:", error);
        }
      }

      async function loadCustomPrediction(sign, lang, time) {
        result.style.display = "block";
        result.innerHTML = `<div class="alert alert-info" role="alert">
          <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
          Carregant...
        </div>`;

        try {
          const res = await fetch(`/api/horoscope?sign=${sign}&lang=${lang}&time=${time}`);
          const data = await res.json();

          result.innerHTML = `
            <div class="card shadow-sm">
              <div class="card-body">
                <h4 class="card-title">
                  <span class="iconify" data-icon="mdi:zodiac-${data.sign.toLowerCase()}"></span>
                  ${data.sign} (${data.time})
                </h4>
                <p class="card-text">${data.prediction}</p>
              </div>
            </div>
          `;
        } catch (error) {
          result.innerHTML = `<div class="alert alert-danger" role="alert">
            Error al carregar la predicció.
          </div>`;
        }
      }

      // Inicial: carregar horòscops
      await loadDailyHoroscope(currentLang);

      langSelector.addEventListener("change", async () => {
        currentLang = langSelector.value;
        await loadDailyHoroscope(currentLang);

        if (result.style.display !== "none") {
          const sign = signSelector.value;
          const time = timeSelector.value;
          await loadCustomPrediction(sign, currentLang, time);
        }
      });

      document.getElementById("search-btn").addEventListener("click", () => {
        const sign = signSelector.value;
        const lang = langSelector.value;
        const time = timeSelector.value;
        loadCustomPrediction(sign, lang, time);
      });
    });
  </script>
</body>

</html>
