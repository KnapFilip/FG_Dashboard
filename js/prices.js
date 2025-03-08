document.addEventListener("DOMContentLoaded", function () {
    function calculateTotalPrice() {
        let total = 1500; // Základní cena

        // Přídavné funkce
        let addons = {
            "login": 250,
            "admin": 200,
            "shop": 500,
            "db": 50,
            "hosting": 50,
            "domain": 50,
            "contact_form": 50,
            "other": 100 // Každý další požadavek je +100 Kč
        };

        for (let id in addons) {
            let element = document.getElementById(id);
            if (element && element.checked) {
                total += addons[id];
            }
        }

        // Počet dalších požadavků oddělených čárkou
        let otherTextarea = document.getElementById("other_text");
        if (otherTextarea) {
            let otherRequests = otherTextarea.value.split(",").filter(item => item.trim() !== "").length;
            total += otherRequests * 100;
        }

        // Aktualizace výsledné ceny
        let totalPriceInput = document.getElementById("total_price");
        totalPriceInput.value = total + " Kč";
    }

    // Přidání event listenerů na všechny checkboxy, textarea a selecty
    document.querySelectorAll("input[type=checkbox], textarea, select").forEach(element => {
        element.addEventListener("change", calculateTotalPrice);
    });

    // Zavolání výpočtu ceny při načtení stránky
    calculateTotalPrice();
});
