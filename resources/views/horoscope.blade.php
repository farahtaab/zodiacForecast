<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>🌙 Horòscop Interactiu</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(120deg, #fdfbfb, #ebedee);
            margin: 0;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        label {
            font-weight: 600;
        }

        select, button {
            padding: 0.6rem;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        button {
            background-color: #4f46e5;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        button:hover {
            background-color: #4338ca;
        }

        .prediction {
            background: #f4f4f4;
            border-left: 4px solid #4f46e5;
            padding: 1rem;
            border-radius: 8px;
            font-size: 1.1rem;
        }

        .loading {
            text-align: center;
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>🔮 Horòscop interactiu</h1>

        <div class="form-group">
            <label for="sign">Signa:</label>
            <select id="sign">
                @foreach(['aquarius','pisces','aries','taurus','gemini','cancer','leo','virgo','libra','scorpio','sagittarius','capricorn'] as $s)
                    <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                @endforeach
            </select>

            <label for="lang">Idioma:</label>
            <select id="lang">
                @foreach(['es'=>'Castellà','ca'=>'Català','pt'=>'Portuguès','it'=>'Italià','fr'=>'Francès','de'=>'Alemany','nl'=>'Holandès','pl'=>'Polonès','ru'=>'Rus'] as $code => $name)
                    <option value="{{ $code }}">{{ $name }}</option>
                @endforeach
            </select>

            <label for="time">Període:</label>
            <select id="time">
                @foreach(['today'=>'Avui','yesterday'=>'Ahir','week'=>'Setmana','month'=>'Mes'] as $t => $label)
                    <option value="{{ $t }}">{{ $label }}</option>
                @endforeach
            </select>

            <button onclick="loadHoroscope()">🔍 Consultar</button>
        </div>

        <div id="result" class="prediction" style="display:none;"></div>
        <div id="loading" class="loading" style="display:none;">Carregant horòscop...</div>
    </div>

    <script>
        function loadHoroscope() {
            const sign = document.getElementById('sign').value;
            const lang = document.getElementById('lang').value;
            const time = document.getElementById('time').value;

            document.getElementById('result').style.display = 'none';
            document.getElementById('loading').style.display = 'block';

            fetch(`/api/horoscope?sign=${sign}&lang=${lang}&time=${time}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('result').innerText = data.prediction;
                    document.getElementById('result').style.display = 'block';
                })
                .catch(err => {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('result').innerText = 'Error al carregar la predicció.';
                    document.getElementById('result').style.display = 'block';
                });
        }

        // Carrega inicial
        window.onload = loadHoroscope;
    </script>

</body>
</html>
