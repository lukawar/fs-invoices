<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, usePage  } from '@inertiajs/vue3';
import { defineProps, ref, watchEffect } from "vue";
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    invoices: Object 
});

const currentInvoice = ref(null);
const editDialog = ref(false);
const deleteDialog = ref(false);
const newInvoiceDialog = ref(false);
const page = usePage();
const snackbar = ref({
    visible: false,
    text: "",
    color: "green"
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

const headers = [
    {
        title: "Numer faktury",
        key: "number",
    },
    {
        title: "NIP kupującego",
        key: "buyer_nip",
    },
    {
        title: "NIP sprzedającego",
        key: "seller_nip",
    },
    {
        title: "Nazwa produktu",
        key: "product_name",
    },
    {
        title: "Ilość",
        key: "amount",
    },
    {
        title: "Cena",
        key: "product_price",
        value: item => formatCurrency(item.product_price),
    },
    {
        title: "Kwota",
        key: "value",
        value: item => formatCurrency(item.value),
    },
    {
        title: "Data wystawienia",
        key: "created_at",
        value: item => formatDate(item.created_at),
    },
    {
        title: "Data edycji",
        key: "updated_at",
        value: item => formatDate(item.updated_at),
    },
    { key: 'actions', align: 'end', sortable: false },
];

const editInvoice = (invoice) => {
    currentInvoice.value = { ...invoice };
    editDialog.value = true;
};

const deleteInvoice = (invoice) => {
    currentInvoice.value = invoice;
    deleteDialog.value = true;
};

const confirmDelete = () => {
    router.delete(`/invoices/${currentInvoice.value.id}`, {
        onSuccess: () => {
            deleteDialog.value = false;
        }
    });
};

const saveInvoice = () => {
    router.patch(`/invoices/${currentInvoice.value.id}`, currentInvoice.value, {
        onSuccess: () => {
            editDialog.value = false;
        }
    });
};

const newInvoice = ref({
    number: "",
    buyer_nip: "",
    seller_nip: "",
    product_name: "",
    amount: "",
    product_price: ""
});

const createInvoice = () => {
    router.post("/invoices", newInvoice.value, {
        onSuccess: () => {
            newInvoiceDialog.value = false;
            snackbar.value.text = "Faktura została wystawiona!";
            snackbar.value.visible = true;
            newInvoice.value = { number: "", buyer_nip: "", seller_nip: "", product_name: "", amount: "", product_price: "" };
        }
    });
};

watchEffect(() => {
    if (page.props.flash?.success) {
        snackbar.value.text = page.props.flash.success;
        snackbar.value.visible = true;
    }
});

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
            <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <v-btn color="primary" class="ml-4" @click="newInvoiceDialog = true">Wystaw nową fakturę</v-btn>
                    <v-data-table 
                        :items="invoices.data"
                        :headers="headers">

                        <template v-slot:item.actions="{ item }">
                            <v-btn variant="outlined" @click="editInvoice(item)">Edytuj</v-btn> &nbsp;
                            <v-btn color="red" variant="outlined" @click="deleteInvoice(item)">Usuń</v-btn>
                        </template>

                    </v-data-table>

                    <Pagination :pagination="invoices.meta" />

                </div>
            </div>
        </div>

        <!-- modals-->
        <v-dialog v-model="newInvoiceDialog" max-width="500px">
            <v-card>
                <v-card-title>Wystaw nową fakturę</v-card-title>
                <v-card-text>
                    <v-text-field v-model="newInvoice.number" label="Numer faktury"></v-text-field>
                    <v-text-field v-model="newInvoice.buyer_nip" label="NIP kupującego"></v-text-field>
                    <v-text-field v-model="newInvoice.seller_nip" label="NIP sprzedającego"></v-text-field>
                    <v-text-field v-model="newInvoice.product_name" label="Nazwa produktu"></v-text-field>
                    <v-text-field v-model="newInvoice.amount" label="Ilość" type="number"></v-text-field>
                    <v-text-field v-model="newInvoice.product_price" label="Cena" type="number"></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn text @click="newInvoiceDialog = false">Anuluj</v-btn>
                    <v-btn color="primary" @click="createInvoice">Zapisz</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="editDialog" max-width="500px">
            <v-card>
                <v-card-title>Edycja faktury</v-card-title>
                <v-card-text>
                    <v-text-field v-model="currentInvoice.number" label="Numer faktury"></v-text-field>
                    <v-text-field v-model="currentInvoice.buyer_nip" label="NIP kupującego"></v-text-field>
                    <v-text-field v-model="currentInvoice.seller_nip" label="NIP sprzedającego"></v-text-field>
                    <v-text-field v-model="currentInvoice.product_name" label="Nazwa produktu"></v-text-field>
                    <v-text-field v-model="currentInvoice.amount" label="Ilość"></v-text-field>
                    <v-text-field v-model="currentInvoice.product_price" label="Cena"></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn text @click="editDialog = false">Anuluj</v-btn>
                    <v-btn color="primary" @click="saveInvoice">Zapisz</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="deleteDialog" max-width="400px">
            <v-card>
                <v-card-title>Usuń fakturę</v-card-title>
                <v-card-text>
                    Czy na pewno chcesz usunąć fakturę "{{ currentInvoice?.number }}"?
                </v-card-text>
                <v-card-actions>
                    <v-btn text @click="deleteDialog = false">Anuluj</v-btn>
                    <v-btn color="red" @click="confirmDelete">Usuń</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-snackbar v-model="snackbar.visible" :timeout="3000" :color="snackbar.color">
            {{ snackbar.text }}
        </v-snackbar>

    </AuthenticatedLayout>
</template>