<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="UTF-8">
  <title>Horòscop Interactiu</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Iconify per als icones zodiacals -->
  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
  <!-- (Opcional) Libreria de banderas per mostrar banderes -->
  <!--
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.6.6/css/flag-icons.min.css"
        integrity="sha512-24Zy11IuCZ4HiYIZhf8sS0oZkYaoARDhorkRCibArHNn1jJOMAAjQyaw6Id/78cZ/F5MSv2fEvAr0vzRBKn2hA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
  -->
  <style>
    :root {
      --primary: #212121;
      --secondary: #757575;
      --accent: #009688;
      --bg-color: #FAFAFA;
      --card-bg: #ffffff;
      --header-bg: linear-gradient(135deg, #455A64, #37474F);
      --navbar-bg: #263238;
    }

    * {
      box-sizing: border-box;
      transition: all 0.3s ease;
    }

    body {
      background: var(--bg-color);
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
      color: var(--primary);
      line-height: 1.6;
    }

    /* Navbar */
    .navbar {
      background: var(--navbar-bg);
      padding: 12px 0;
    }

    .navbar-brand {
      font-weight: 500;
      color: #fff !important;
      font-size: 1.5rem;
    }

    /* Header */
    .header-section {
      padding: 60px 20px;
      text-align: center;
      background: var(--header-bg);
      color: #fff;
      margin-bottom: 30px;
    }

    .header-section h1 {
      font-size: 2.8rem;
      margin-bottom: 10px;
      position: relative;
      display: inline-block;
    }

    .header-section h1::after {
      content: '';
      position: absolute;
      width: 60%;
      height: 4px;
      background: var(--accent);
      bottom: -10px;
      left: 20%;
      border-radius: 2px;
    }

    .header-section p {
      font-size: 1.2rem;
    }

    .container {
      margin-bottom: 40px;
    }

    /* Tarjetas (cards) */
    .card {
      position: relative;
      border: none;
      border-radius: 12px;
      background: var(--card-bg);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
      overflow: hidden;
    }

    /* Línea vertical de acento */
    .card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: var(--accent);
    }

    .card-custom:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
    }

    .card-body {
      padding: 20px;
    }

    .card-title {
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--primary);
      margin-bottom: 12px;
    }

    .card-text {
      font-size: 1rem;
      color: var(--secondary);
    }

    /* Formularios y botones */
    .form-label {
      font-weight: 600;
    }

    .form-select,
    .btn {
      border-radius: 6px;
      font-size: 1rem;
    }

    .form-select {
      border: 1px solid #ccc;
    }

    .btn-primary {
      background-color: var(--accent);
      border: none;
      padding: 10px 20px;
      font-weight: 600;
    }

    .btn-primary:hover {
      background-color: #00796b;
    }

    /* Selector de idioma */
    #lang {
      border: 1px solid #ccc;
    }

    /* Footer */
    .footer {
      text-align: center;
      padding: 20px 0;
      font-size: 1rem;
      color: #fff;
      background: var(--navbar-bg);
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Indicador de carga */
    #loading {
      margin-top: 20px;
    }

    /* Sección de consulta personalizada */
    #custom-result .card {
      margin-top: 15px;
    }

    /* Mini menú de periodos */
    .period-nav .nav-link {
      color: #555;
      padding: 6px 12px;
      border-radius: 6px;
      margin-right: 5px;
      cursor: pointer;
    }

    .period-nav .nav-link.active {
      background-color: var(--accent);
      color: #fff;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#"><i class="bi bi-moon-stars"></i> Horòscop </a>
    </div>
  </nav>

  <!-- Header -->
  <div class="header-section">
    <div class="container">
      <h1>Horòscop</h1>
      <p>Prediccions</p>
    </div>
  </div>

  <div class="container">
    <!-- Selecció global d'idioma -->
    <div class="row my-4">
      <div class="col-12 text-end">
        <label for="lang" class="form-label me-2">Idioma:</label>
        <!-- Es pot mostrar també la bandera si s'activa la llibreria (veure comentari al head) -->
        <select id="lang" class="form-select d-inline-block w-auto">
          @foreach(['es'=>'Castellà','ca'=>'Català','pt'=>'Portuguès','it'=>'Italià','fr'=>'Francès','de'=>'Alemany','nl'=>'Holandès','pl'=>'Polonès','ru'=>'Rus'] as $code => $name)
            <option value="{{ $code }}">{{ $name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <!-- Secció: Horòscops (amb mini menú de periodos) -->
    <section class="mb-5">
      <!-- Títol que es modificarà segons el període -->
      <h3 id="main-title" class="mb-3" style="font-weight: 600;">Horòscops d'avui</h3>
      
      <!-- Mini menú de periodos -->
      <ul class="nav period-nav mb-3" id="period-nav">
        <li class="nav-item">
          <a class="nav-link active" data-time="today">Avui</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-time="yesterday">Ahir</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-time="week">Setmana</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-time="month">Mes</a>
        </li>
      </ul>

      <!-- Grid on es mostren les prediccions -->
      <div id="daily-grid" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        <!-- Les targetes es carregaran per JavaScript -->
      </div>
    </section>

    <!-- Secció: Consulta personalitzada -->
    <section class="mb-5">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title mb-3">Consulta personalitzada</h3>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="custom-sign" class="form-label">Signa</label>
              <select id="custom-sign" class="form-select">
                @foreach(['aquarius','pisces','aries','taurus','gemini','cancer','leo','virgo','libra','scorpio','sagittarius','capricorn'] as $s)
                  <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="custom-time" class="form-label">Període</label>
              <select id="custom-time" class="form-select">
                @foreach(['today'=>'Avui','yesterday'=>'Ahir','week'=>'Setmana','month'=>'Mes'] as $t => $label)
                  <option value="{{ $t }}">{{ $label }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="text-center mt-4">
            <button id="custom-search-btn" class="btn btn-primary">
              <i class="bi bi-search"></i> Consultar
            </button>
          </div>
          <!-- Resultat de la consulta personalitzada -->
          <div id="custom-result" class="mt-4" style="display:none;"></div>
        </div>
      </div>
    </section>

    <!-- Indicador de càrrega -->
    <div id="loading" class="text-center" style="display:none;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregant...</span>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      © 2025 Horòscop Interactiu. Tots els drets reservats.
    </div>
  </footer>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", async () => {
      // Definició dels signes (per a cada targeta) i els seus icones
      const signs = [
        { name: "aquarius", icon: "mdi:zodiac-aquarius" },
        { name: "pisces", icon: "mdi:zodiac-pisces" },
        { name: "aries", icon: "mdi:zodiac-aries" },
        { name: "taurus", icon: "mdi:zodiac-taurus" },
        { name: "gemini", icon: "mdi:zodiac-gemini" },
        { name: "cancer", icon: "mdi:zodiac-cancer" },
        { name: "leo", icon: "mdi:zodiac-leo" },
        { name: "virgo", icon: "mdi:zodiac-virgo" },
        { name: "libra", icon: "mdi:zodiac-libra" },
        { name: "scorpio", icon: "mdi:zodiac-scorpio" },
        { name: "sagittarius", icon: "mdi:zodiac-sagittarius" },
        { name: "capricorn", icon: "mdi:zodiac-capricorn" }
      ];

      // Mapping per canviar el títol segons el període
      const titleMapping = {
        today: "Horòscops d'avui",
        yesterday: "Horòscops d'ahir",
        week: "Horòscops de la setmana",
        month: "Horòscops del mes"
      };

      const langSelector = document.getElementById("lang");
      const dailyGrid = document.getElementById("daily-grid");
      const mainTitle = document.getElementById("main-title");
      let currentTime = "today";
      let activeRequestId = 0;

      // Funció per mostrar placeholders mentre es carrega la informació
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
          </div>`;
      }

      // Funció per netejar la grid i mostrar placeholders
      function clearGrid() {
        dailyGrid.innerHTML = signs.map(() => loadingCard()).join("");
      }

      // Carrega les prediccions de totes les targetes
      async function loadDailyHoroscope(lang) {
        const requestId = ++activeRequestId;
        clearGrid();

        // Actualitzem el títol segons el període seleccionat
        mainTitle.textContent = titleMapping[currentTime] || "Horòscops";

        try {
          const res = await fetch(`/horoscope/all?lang=${lang}&time=${currentTime}`);
          const data = await res.json();

          if (requestId !== activeRequestId) return;

          // Convertim el resultat en un objecte on la clau és el signe (minúscules)
          const predictionsBySign = Object.fromEntries(
            data.map(item => [item.sign.toLowerCase(), item.prediction])
          );

          let cardsHtml = '';
          // Recorrer tots els signes per mostrar la predicció de cadascun
          signs.forEach(sign => {
            const prediction = predictionsBySign[sign.name] || 'No hi ha predicció disponible.';
            cardsHtml += `
              <div class="col">
                <div class="card card-custom h-100">
                  <div class="card-body">
                    <h5 class="card-title">
                      <span class="iconify" data-icon="${sign.icon}"></span> ${sign.name}
                    </h5>
                    <p class="card-text">${prediction}</p>
                  </div>
                </div>
              </div>`;
          });

          dailyGrid.innerHTML = cardsHtml;
        } catch (error) {
          console.error("Error al carregar els horòscops:", error);
        }
      }

      // Gestió del mini menú de períodes
      const periodLinks = document.querySelectorAll("#period-nav .nav-link");
      periodLinks.forEach(link => {
        link.addEventListener("click", e => {
          e.preventDefault();
          periodLinks.forEach(l => l.classList.remove("active"));
          link.classList.add("active");

          currentTime = link.dataset.time;
          loadDailyHoroscope(langSelector.value);
        });
      });

      // Lògica per la consulta personalitzada (sense modificacions)
      const customSignSelector = document.getElementById("custom-sign");
      const customTimeSelector = document.getElementById("custom-time");
      const customResult = document.getElementById("custom-result");

      async function loadCustomPrediction(sign, lang, time) {
        customResult.style.display = "block";
        customResult.innerHTML = `
          <div class="alert alert-info" role="alert">
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Carregant...
          </div>`;

        try {
          const res = await fetch(`/api/horoscope?sign=${sign}&lang=${lang}&time=${time}`);
          const data = await res.json();
          customResult.innerHTML = `
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">
                  <span class="iconify" data-icon="mdi:zodiac-${data.sign.toLowerCase()}"></span>
                  ${data.sign} (${data.time})
                </h4>
                <p class="card-text">${data.prediction}</p>
              </div>
            </div>`;
        } catch (error) {
          customResult.innerHTML = `
            <div class="alert alert-danger" role="alert">
              Error al carregar la predicció.
            </div>`;
        }
      }

      document.getElementById("custom-search-btn").addEventListener("click", () => {
        const sign = customSignSelector.value;
        const lang = langSelector.value;
        const time = customTimeSelector.value;
        loadCustomPrediction(sign, lang, time);
      });

      // Carrega inicial de les targetes amb els valors per defecte
      await loadDailyHoroscope(langSelector.value);

      // Quan canvia l'idioma, es recarrega la grid i, si existeix, la consulta personalitzada
      langSelector.addEventListener("change", async () => {
        const lang = langSelector.value;
        await loadDailyHoroscope(lang);
        if (customResult.style.display !== "none" && customResult.innerHTML.trim() !== "") {
          const sign = customSignSelector.value;
          const time = customTimeSelector.value;
          await loadCustomPrediction(sign, lang, time);
        }
      });
    });
  </script>
</body>

</html>
