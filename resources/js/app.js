import './bootstrap';

// SimpleBar, for more info and examples you can check out https://github.com/Grsmto/simplebar
import SimpleBar from "simplebar";
import './testchart.js';

// Template modules
// import CRM from "./modules/crm.js";

// Dark mode functionality
import DarkMode from "./modules/darkMode.js";

// Alpine.js
import Alpine from "alpinejs";
import focus from "@alpinejs/focus";


// Dark mode
new DarkMode();

window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.start();


let simplebarContainer = document.getElementById("simplebar");

if (simplebarContainer) {
    new SimpleBar(simplebarContainer);
}

