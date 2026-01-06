import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import DataTableCore from 'datatables.net-dt';
import { DataTable } from 'datatables.net-vue3';
import 'datatables.net-fixedcolumns';
import Toast from 'vue-toastification';
import "vue-toastification/dist/index.css";
import _Toast from './Resources/_Toast.vue';
import UserIndex from './components/user/UserIndex.vue';
import CloseIcon from "./components/icons/CloseIcon.vue";
import UserCreate from './components/user/UserCreate.vue';


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
DataTable.use(DataTableCore);

const app = createApp({});

app.use(Toast, {
    position: "top-center",
    timeout: 3000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    draggable: true,
    draggablePercent: 0.6,
    hideProgressBar: true,
    icon: true,
    closeButton: CloseIcon,
});

app.component("DataTable", DataTable);
app.component('UserIndex', UserIndex);
app.component('UserCreate', UserCreate);
app.mount('#app');
