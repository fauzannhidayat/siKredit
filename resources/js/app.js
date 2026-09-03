import Alpine from 'alpinejs';
import focus from '@alpinejs/focus'
import { formTagihan } from './components/form-tagihan';
import { customerSearch } from './components/customer-search';

window.Alpine = Alpine;

Alpine.plugin(focus)
Alpine.data('formTagihan', formTagihan);
Alpine.data('customerSearch', customerSearch);

Alpine.start();