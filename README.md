# Projecte de Horòscops

Aquest és un projecte web que proporciona prediccions diàries, setmanals, mensuals i passades dels horòscops per als 12 signes del zodíac. Els usuaris poden consultar prediccions dels horòscops per qualsevol signe i en diversos idiomes. Les prediccions es recuperen d'una API externa i es tradueixen automàticament mitjançant l'API de Google Translate.

## Tecnologies utilitzades

- **Laravel**: Framework PHP que s'utilitza per gestionar la lògica del backend i la interacció amb la base de dades.
- **Google Translate API**: S'utilitza per traduir les prediccions a diversos idiomes.
- **API d'astrologia externa**: Proporciona les prediccions dels horòscops per a cada signe i període.
- **Eloquent ORM**: S'utilitza per interactuar amb la base de dades en Laravel.
- **Frontend**: HTML i Blade (Motor de plantilles de Laravel) per mostrar les prediccions.

## Funcionalitats

- **Obtenció de prediccions**: Les prediccions es recuperen d'una API externa que ofereix horòscops basats en el signe i el període (avui, ahir, setmana, mes).
- **Traducció automàtica**: Les prediccions es tradueixen a diversos idiomes utilitzant l'API de Google Translate.
- **Filtratge per període**: Els usuaris poden filtrar les prediccions per diferents períodes: avui, ahir, setmana, mes.
- **Filtratge per signe**: Els usuaris poden consultar les prediccions de qualsevol signe del zodíac.
- **Multilingüisme**: Les prediccions estan disponibles en diversos idiomes com el català, castellà, anglès, francès, alemany, italià, portuguès, rus, polonès, etc.

## Com funciona

1. **Consulta de les prediccions**:
    - Els usuaris poden sol·licitar les prediccions per a qualsevol signe del zodíac (ex: Aquarius, Aries, Leo, etc.).
    - Les prediccions es poden filtrar per diferents períodes de temps: avui, ahir, setmana, mes.
    - Els usuaris també poden seleccionar l'idioma per obtenir les prediccions en l'idioma desitjat.

2. **Actualització automàtica de les prediccions**:
    - Les prediccions es poden actualitzar manualment mitjançant el comandament d'Artisan `php artisan horoscope:update`.
    - El comandament actualitza les prediccions per a tots els signes i períodes, i les tradueix a diversos idiomes.
    - La base de dades es manté actualitzada amb les últimes prediccions i idiomes disponibles.

3. **API pública**:
    - El projecte també ofereix una API RESTful que permet als usuaris obtenir prediccions de horòscops en format JSON, basant-se en el signe, idioma i període seleccionat.
