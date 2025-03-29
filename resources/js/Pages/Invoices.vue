<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { defineProps, ref } from "vue";
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    invoices: Object 
});

const formatDate = (date) => new Date(date).toLocaleDateString("pl-PL");

const formatCurrency = (amount) =>
    new Intl.NumberFormat("pl-PL", {
        style: "currency",
        currency: "PLN",
    }).format(amount);

const goToPage = (url) => {
    if (url) {
        router.get(url);
    }
};

const showModal = ref(false);
const showEditModal = ref(false);
const currentInvoice = ref(null);

const openModal = () => {
    showModal.value = true;
};

const openEditModal = (invoice) => {
    currentInvoice.value = { ...invoice };
    showEditModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    showEditModal.value = false;
    currentInvoice.value = null;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Lista faktur
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    
                    <!-- Tabela z fakturami -->
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">Nr faktury</th>
                                <th class="px-4 py-2 border">NIP kupującego</th>
                                <th class="px-4 py-2 border">NIP sprzedającego</th>
                                <th class="px-4 py-2 border">Nazwa produktu</th>
                                <th class="px-4 py-2 border">Ilość</th>
                                <th class="px-4 py-2 border">Cena</th>
                                <th class="px-4 py-2 border">Kwota</th>
                                <th class="px-4 py-2 border">Data wystawienia</th>
                                <th class="px-4 py-2 border">Data edycji</th>
                                <th class="px-1"></th>
                                <th class="px-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="invoice in invoices.data" :key="invoice.id" class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ invoice.number }}</td>
                                <td class="px-4 py-2 border">{{ invoice.buyer_nip }}</td>
                                <td class="px-4 py-2 border">{{ invoice.seller_nip }}</td>
                                <td class="px-4 py-2 border">{{ invoice.product_name }}</td>
                                <td class="px-4 py-2 border">{{ invoice.amount }}</td>
                                <td class="px-4 py-2 border">{{ formatCurrency(invoice.product_price) }}</td>
                                <td class="px-4 py-2 border">{{ formatCurrency(invoice.value) }}</td>
                                <td class="px-4 py-2 border">{{ formatDate(invoice.created_at) }}</td>
                                <td class="px-4 py-2 border">{{ formatDate(invoice.updated_at) }}</td>
                                <td class="px-1">
                                    <button @click="openEditModal(invoice)" class="mr-2 px-3 py-1 bg-yellow-500 text-white rounded">Edytuj</button>
                                </td>
                                <td class="px-1">
                                    <button class="px-3 py-1 bg-red-500 text-white rounded">Usuń</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <Pagination :pagination="invoices.meta" />

                </div>
            </div>
        </div>

        <!-- Modals -->
        <div v-if="showAddModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <h2 class="text-lg font-semibold">Dodaj fakturę</h2>
                <button @click="closeModal" class="absolute top-2 right-2 text-gray-600">Zamknij</button>
                <form>
                    <div class="mb-4">
                        <label for="number" class="block text-sm font-medium text-gray-700">Numer faktury</label>
                        <input type="text" id="number" v-model="newInvoice.number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="buyer_nip" class="block text-sm font-medium text-gray-700">NIP kupującego</label>
                        <input type="text" id="buyer_nip" v-model="newInvoice.buyer_nip" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="seller_nip" class="block text-sm font-medium text-gray-700">NIP sprzedającego</label>
                        <input type="text" id="seller_nip" v-model="newInvoice.seller_nip" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="product_name" class="block text-sm font-medium text-gray-700">Nazwa produktu</label>
                        <input type="text" id="product_name" v-model="newInvoice.product_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Ilość</label>
                        <input type="number" id="amount" v-model="newInvoice.amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="product_price" class="block text-sm font-medium text-gray-700">Cena produktu</label>
                        <input type="number" id="product_price" v-model="newInvoice.product_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">
                        Zapisz
                    </button>
                </form>
            </div>
        </div>

        <!-- Modal edycji faktury -->
        <div v-if="showEditModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <h2 class="text-lg font-semibold">Edytuj fakturę</h2>
                
                <form>
                    <div class="mb-4">
                        <label for="number" class="block text-sm font-medium text-gray-700">Numer faktury</label>
                        <input type="text" id="number" v-model="currentInvoice.number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="buyer_nip" class="block text-sm font-medium text-gray-700">NIP kupującego</label>
                        <input type="text" id="buyer_nip" v-model="currentInvoice.buyer_nip" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="seller_nip" class="block text-sm font-medium text-gray-700">NIP sprzedającego</label>
                        <input type="text" id="seller_nip" v-model="currentInvoice.seller_nip" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="product_name" class="block text-sm font-medium text-gray-700">Nazwa produktu</label>
                        <input type="text" id="product_name" v-model="currentInvoice.product_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Ilość</label>
                        <input type="number" id="amount" v-model="currentInvoice.amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="product_price" class="block text-sm font-medium text-gray-700">Cena produktu</label>
                        <input type="number" id="product_price" v-model="currentInvoice.product_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                
                    <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
                        Zapisz zmiany
                    </button>
                    <button @click="closeModal" class="mt-4 px-4 py-2 bg-red-500 text-white rounded">Zamknij</button>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>