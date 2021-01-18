# Language API Para PocketMine
Language api para servidores de minecraft pe (Pocket Edition)

## ¿Como Utilizar La API?

- Añade la instancia del lenguage:
```PHP
use Language\Language;
$language = Language::getInstance();
```

- Funciones del API:
```PHP
$language->setTranslate($his, $player, "example.text", [$player->getName()]); //Obtiene la traduccion
$language->getLanguage($player); //Sirve para obtener el lenguage de algun jugador
```
### ¿Cómo agregar el idioma en su plugin?
```TXT
- Añadir un archivo de formato de lenguage en los datos de tu plugin con esta SkyWars/languages/eng.yml
- Añadir un prefix
- Aqui un ejemplo
  - eng.yml > example.plugin: "translated by {%0}"
  - spa.yml > example.plugin: "traducido por {%0}"
  
