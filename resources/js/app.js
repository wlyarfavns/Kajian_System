import './bootstrap';
import * as Turbo from "@hotwired/turbo";
import Alpine from 'alpinejs';

// Optimalkan performa cache Turbo dengan Alpine
document.addEventListener("turbo:before-render", () => {
    // Kosongkan cache untuk mencegah duplikasi event listeners Alpine
    let alpineElements = document.querySelectorAll('[x-data]');
    alpineElements.forEach(el => {
        if(el.__x) {
            delete el.__x;
        }
    });
});

window.Alpine = Alpine;
Alpine.start();
