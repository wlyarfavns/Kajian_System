import './bootstrap';
import * as Turbo from "@hotwired/turbo";
import Alpine from 'alpinejs';

// Removed turbo:before-render hack that breaks Alpine JS v3
window.Alpine = Alpine;
Alpine.start();
