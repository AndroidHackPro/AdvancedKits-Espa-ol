<?php

namespace AdvancedKits\lang;

use AdvancedKits\Main;
use pocketmine\utils\Config;

class LangManager{

    const LANG_VERSION = 0;

    private $ak;
    private $defaults;
    private $data;

    public function __construct(Main $ak){
        $this->ak = $ak;
        $this->defaults = [
            "lang-version" => 0,
            "in-game" => "Corre este comando en el juego (CrafteoLife)",
            "av-kits" => "Kits disponibles: {%0}",
            "no-kit" => "El Kit {%0} no existe",
            "reload" => "Configuraciones de los Kits recargada",
            "sel-kit" => "Kit seleccionado: {%0}",
            "cant-afford" => "No puedes permitirte el lujo de este Kit: {%0}",
            "one-per-life" => "Solo puedes tener un Kit por vida",
            "cooldown1" => "El Kit {%0} se está enfriando en este momento para su uso",
            "cooldown2" => "Podrás volver a usar éste Kit en {%0}",
            "no-perm" => "No tienes permiso para usar éste Kit {%0}, porque pertenece a otro rango",
            "cooldown-format1" => "{%0} minutos",
            "cooldown-format2" => "{%0} horas y {%1} minutos",
            "cooldown-format3" => "{%0} horas",
            "no-sign-on-kit" => "En éste cartel, el kit no está especificado",
            "no-perm-sign" => "No tienes permiso para crear carteles de Kit"
        ];
        $this->data = new Config($this->ak->getDataFolder()."lang.properties", Config::PROPERTIES, $this->defaults);
        if($this->data->get("lang-version") != self::LANG_VERSION){
            $this->ak->getLogger()->alert("Translation file is outdated. The old file has been renamed and a new one has been created");
            @rename($this->ak->getDataFolder()."lang.properties", $this->ak->getDataFolder()."lang.properties.old");
            $this->data = new Config($this->ak->getDataFolder()."lang.properties", Config::PROPERTIES, $this->defaults);
        }
    }

    public function getTranslation(string $dataKey, ...$args) : string{
        if(!isset($this->defaults[$dataKey])){
            $this->ak->getLogger()->error("Invalid datakey $dataKey passed to method LangManager::getTranslation()");
            return "";
        }
        $str = $this->data->get($dataKey, $this->defaults[$dataKey]);
        foreach($args as $key => $arg){
            $str = str_replace("{%".$key."}", $arg, $str);
        }
        return $str;
    }

}
