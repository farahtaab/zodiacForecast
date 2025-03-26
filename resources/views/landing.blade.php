<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Horòscop Diari | Descobreix el teu destí</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
  <script defer>
    document.addEventListener("DOMContentLoaded", async () => {
      const signs = ["aquarius","pisces","aries","taurus","gemini","cancer","leo","virgo","libra","scorpio","sagittarius","capricorn"];
      const time = "today";
      const grid = document.getElementById("daily-grid");
      const langSelector = document.getElementById("lang");
      const customLangSelector = document.getElementById("custom-lang");
      let currentLang = langSelector.value;
      let activeRequestId = 0;

      function loadingCard(sign) {
        return `<div class='bg-white rounded-xl shadow p-4 animate-pulse'>
                  <div class='h-5 bg-gray-300 rounded w-1/2 mb-2'></div>
                  <div class='h-3 bg-gray-200 rounded w-full mb-1'></div>
                  <div class='h-3 bg-gray-200 rounded w-5/6'></div>
                </div>`;
      }

      function clearGrid() {
        grid.innerHTML = signs.map(sign => loadingCard(sign)).join("");
      }

      async function loadDailyHoroscope(lang) {
        const requestId = ++activeRequestId;
        clearGrid();

        const responses = await Promise.allSettled(
          signs.map(sign => 
            fetch(`/api/horoscope?sign=${sign}&lang=${lang}&time=${time}`).then(res => res.json())
          )
        );

        if (requestId !== activeRequestId) return;

        grid.innerHTML = "";
        responses.forEach((res, i) => {
          const data = res.status === "fulfilled" ? res.value : null;
          if (!data) return;
          const card = document.createElement("div");
          card.className = "bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition flex flex-col justify-between h-full";
          card.innerHTML = `
            <div>
              <h3 class="text-xl font-semibold capitalize mb-2 flex items-center gap-2">
                <i class="fas fa-star text-yellow-400"></i> ${data.sign}
              </h3>
              <p class="text-sm text-gray-600">${data.prediction}</p>
            </div>
          `;
          grid.appendChild(card);
        });
      }

      await loadDailyHoroscope(currentLang);

      langSelector.addEventListener("change", async (e) => {
        currentLang = e.target.value;
        customLangSelector.value = currentLang;
        await loadDailyHoroscope(currentLang);
      });

      document.getElementById("search-btn").addEventListener("click", () => {
        const sign = document.getElementById("sign").value;
        const selectedLang = customLangSelector.value;
        const selectedTime = document.getElementById("time").value;

        const result = document.getElementById("result");
        result.innerHTML = '<p class="text-gray-500 italic">Carregant...</p>';

        fetch(`/api/horoscope?sign=${sign}&lang=${selectedLang}&time=${selectedTime}`)
          .then(res => res.json())
          .then(data => {
            result.innerHTML = `
              <div class="bg-white p-6 rounded-lg shadow-md animate-fade-in">
                <h4 class="text-lg font-bold capitalize mb-2 flex items-center gap-2">
                  <i class="fas fa-sun text-orange-400"></i> ${data.sign} (${data.time})
                </h4>
                <p>${data.prediction}</p>
              </div>
            `;
          })
          .catch(() => {
            result.innerHTML = '<p class="text-red-500">Error al carregar la predicció.</p>';
          });
      });
    });
  </script>
  <style>
    .animate-fade-in {
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="bg-gradient-to-br from-indigo-100 to-white min-h-screen font-sans">
  <header class="text-center py-12 bg-white shadow">
    <h1 class="text-5xl font-extrabold text-indigo-800 mb-2 tracking-tight">Horòscop Diari</h1>
    <p class="text-xl text-gray-600">Descobreix què et deparen els astres avui</p>
  </header>

  <main class="max-w-7xl mx-auto px-4 py-10">
    <section>
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Prediccions d'avui</h2>
        <select id="lang" class="p-2 rounded border text-sm">
          <option value="es">Castellà</option>
          <option value="ca">Català</option>
          <option value="pt">Portuguès</option>
          <option value="it">Italià</option>
          <option value="fr">Francès</option>
          <option value="de">Alemany</option>
          <option value="nl">Holandès</option>
          <option value="pl">Polonès</option>
          <option value="ru">Rus</option>
        </select>
      </div>
      <div id="daily-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"></div>
    </section>

    <section class="mt-20">
      <h2 class="text-2xl font-bold text-gray-700 mb-4">Consulta personalitzada</h2>
      <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
        <select id="sign" class="p-3 rounded border">
          <option value="aquarius">Aquarius</option>
          <option value="pisces">Pisces</option>
          <option value="aries">Aries</option>
          <option value="taurus">Taurus</option>
          <option value="gemini">Gemini</option>
          <option value="cancer">Cancer</option>
          <option value="leo">Leo</option>
          <option value="virgo">Virgo</option>
          <option value="libra">Libra</option>
          <option value="scorpio">Scorpio</option>
          <option value="sagittarius">Sagittarius</option>
          <option value="capricorn">Capricorn</option>
        </select>
        <select id="time" class="p-3 rounded border">
          <option value="today">Avui</option>
          <option value="yesterday">Ahir</option>
          <option value="week">Setmana</option>
          <option value="month">Mes</option>
        </select>
        <select id="custom-lang" class="p-3 rounded border">
          <option value="es">Castellà</option>
          <option value="ca">Català</option>
          <option value="pt">Portuguès</option>
          <option value="it">Italià</option>
          <option value="fr">Francès</option>
          <option value="de">Alemany</option>
          <option value="nl">Holandès</option>
          <option value="pl">Polonès</option>
          <option value="ru">Rus</option>
        </select>
        <button id="search-btn" class="bg-indigo-600 text-white p-3 rounded hover:bg-indigo-700 transition flex items-center justify-center gap-2">
          <i class="fas fa-search"></i> Consultar
        </button>
      </div>
      <div id="result" class="mt-6"></div>
    </section>
  </main>

  <footer class="text-center text-sm text-gray-400 mt-16 mb-6">
    &copy; <script>document.write(new Date().getFullYear());</script> Horòscop Diari. Tots els drets reservats.
  </footer>
</body>
</html>