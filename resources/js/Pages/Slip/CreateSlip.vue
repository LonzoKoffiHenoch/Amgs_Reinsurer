<template>
    <div class="absolute top-1/2 left-1/2 z-50">
        <spinner v-if="loader" class=""></spinner>
    </div>
    <div class="flex flex-row min-h-screen justify-center items-start">
        <div
            class="border-2 my-8 rounded-t-xl pb-3 border-gray-300 shadow-xl bg-white dark:bg-dark-eval-1 dark:border-dark-eval-1 w-1/2">
            <h2 class="text-3xl text-center bg-primary p-2 font-bold text-white rounded-t-xl mb-2">Création d'un
                bordereau
                WPVT</h2>
            <form class="p-8 ">
                
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-2 sm:grid-cols-1">
                    
                    
                    <!-- Date reception Affaire -->
                    <div class="space-y-2 ">
                        <Label for="DateReception" value="Date de réception de l'affaire"/>
                        <InputIconWrapper class="font-bold text-black">
                            <template #icon>
                                <UserIcon aria-hidden="true" class="w-5 h-5"/>
                            </template>
                            <Input id="DateReception" v-model="form.date_reception" autocomplete="name" autofocus
                                   class="block w-full bg-gray-100" required type="date" withIcon/>
                        </InputIconWrapper>
                    </div>
                    
                    
                    <!--                 Activité -->
                    <!--                <div class="space-y-2">
                                        <Label for="Activity" value="Choisir l'activité"/>
                                        <v-select v-model="form.activity" :options="activities"
                                                  class="text-[0.70rem] cedantSelectionner" label="activity"
                                                  placeholder="Choisir l'activité">
                                        </v-select>
                                    </div>-->
                    
                    <div class="space-y-2 mt-4 ">
                        <Label for="" value=""/>
                        <input id="input"
                               class="block w-full text-sm file:p-2 file:text-white file:rounded-xl file:border-0  file:bg-primary "
                               type="file"
                               @change="upload"/>
                    </div>
                </div>
            
            
            </form>
            <button class="p-2 mt-2 ml-8 text-white bg-primary rounded-xl" @click.prevent="soumettre">Enregistrer le
                bordereau
            </button>
            <table id="tbl-data"
                   class="border border-separate border-solid divide-gray-300 table-fixed border-spacing-2 border-slate-500 scroll">
            </table>
        
        
        </div>
    </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";

export default {
    layout: AuthenticatedLayout,
};
</script>
<script setup>
import readXlsxFile from "@/read-excel-file.min";
import {useForm} from "@inertiajs/inertia-vue3";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import {useSwalConfirm, useSwalError, useSwalSuccess} from "@/Composables/alert";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import vSelect from "vue-select";
import useApi from "@/Services/API/useApi"
import {onMounted, computed, ref, onBeforeMount} from "vue";
import Spinner from "@/Shared/Spinner.vue";

const loader = ref(false)
const form = useForm({
    nom_assure: null,
    date_reception: null,
    monnaie: null,
    transferor_id: null,
    pays_assure: {id: null},
    
    slip: [],
});
const tableFormat = () => {
    dataTable = new DataTable("#dataTable");
}
const upload = () => {
    const input = document.getElementById("input");
    readXlsxFile(input.files[0]).then(function (data) {
        form.slip = data;
        
        var i = 0;
        document.getElementById("tbl-data").innerHTML = "";
        data.map((row, index) => {
            if (i == 0) {
                let table = document.getElementById("tbl-data");
                generateTableHead(table, row);
            }
            if (i > 0) {
                let table = document.getElementById("tbl-data");
                generateTableRows(table, row);
            }
        });
    });
};
const sendDataWithError = () => {
    form.post(route('slip.uploadwithouterror'), {
        onSuccess: (page) => {
            console.log(page);
            loader.value = false
            form.reset();
            useSwalSuccess("Borderau uploadé avec succès!");
        },
        onError: (errors) => {
        }
    });
}

const soumettre = () => {
    loader.value = true
    form.post(route("slip.upload"), {
        onSuccess: (page) => {
            console.log(page);
            loader.value = false
            form.reset();
            useSwalSuccess("Borderau uploadé avec succès!");
        },
        onError: (errors) => {
            loader.value = false
            let errorMessage = "";
            for (const [key, error] of Object.entries(errors)) {
                console.log(error)
                errorMessage += error + '<br>'
                
            }
            useSwalConfirm(errorMessage, 'Oui Corriger', 'Non Annuler', () => {
                sendDataWithError();
            });
            
        },
    });
};

</script>

