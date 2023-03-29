<template>
    <form @submit.prevent="storeActivity()">
        
        <div class="space-y-2">
            <Label for="Cedante" value="Choisir la cedante"/>
            <VueSelect v-model="form.pays" :options="props.pays" class="text-[0.75rem]"
                       label="label" multiple
                       placeholder="Choisir le pays">
            </VueSelect>
        
        
        </div>
        <div class="space-y-2 mt-4 col-span-2">
            <select v-model="form.activity">
                <option value="vehicule">vehicule</option>
                <option value="batiment">batiment</option>
            </select>
        </div>
        
        <div class="space-y-2 mt-4 col-span-2">
            <Label for="" value=""/>
            <input id="input"
                   class="block w-full text-sm file:p-2 file:text-white file:rounded-xl file:border-0  file:bg-primary "
                   type="file"
                   @change="upload"/>
        </div>
        
        <button class="justify-end p-2 mt-4 text-white rounded-md bg-secondary"
                @click.prevent="storeActivity()"
        >
            Enregistrer
        </button>
    </form>
</template>

<script setup>
import VueSelect from "vue-select";
import {useForm} from "@inertiajs/inertia-vue3";
import readXlsxFile from "@/read-excel-file.min";
import {useSwalError, useSwalSuccess} from "@/Composables/alert";


const props = defineProps({
    pays: Object
});
const form = useForm({
    activity: "",
    pays: {},
    values: {}
})


const tableFormat = () => {
    dataTable = new DataTable("#dataTable");
}
const upload = () => {
    const input = document.getElementById("input");
    readXlsxFile(input.files[0]).then(function (data) {
        form.values = data;
        
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
const storeActivity = () => {
    form.post(route("setting.upload.activity"), {
        onSuccess: (page) => {
            useSwalSuccess("Affaire ajouté avec succès!");
        },
        onError: (errors) => {
            useSwalError("Une erreur s'est produite.");
        },
    });
};
</script>
