<template>
  <Authenticated>
    <form>
      <input id="input" type="file" @change="upload"/>
    </form>
    <button class="p-2 mt-2 text-white bg-primary rounded-xl" @click.prevent="soumettre">Uploader le fichier</button>
  </Authenticated>
</template>

<script setup>
import readXlsxFile from "@/read-excel-file.min";
import {useForm} from "@inertiajs/inertia-vue3";
import {useSwalError, useSwalSuccess,} from "@/Composables/alert";
import Authenticated from "@/Layouts/Authenticated.vue";

const form = useForm({
  excel: null,
});
const upload = () => {
  const input = document.getElementById("input");
  readXlsxFile(input.files[0]).then(function (data) {
    form.excel = data;

    const i = 0;
    document.getElementById("tbl-data").innerHTML = "";
    data.map((row) => {
      if (i === 0) {
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

function generateTableHead(table, data) {
  let thead = table.createTHead();
  let row = thead.insertRow();
  for (let key of data) {
    let td = document.createElement("td");
    if (key === " " || key == null) {
      key = " ";
    }
    td.classList.add("tableoneline", "text-sm");
    let text = document.createTextNode(key);
    td.appendChild(text);
    row.appendChild(td);
  }
}

function generateTableRows(table, data) {
  let newRow = table.insertRow(-1);
  data.map((row) => {
    if (row === "" || row == null) {
      row = " ";
    }
    let newCell = newRow.insertCell();
    let newtext = document.createTextNode(row);
    newCell.appendChild(newtext);
  });
}

const soumettre = () => {
  form.post(route("business.excel"), {
    onSuccess: (page) => {
      console.log(page)
      document.getElementById("formulaire").reset();
      form.reset();
      useSwalSuccess("Affaire uploadée avec succès!");
    },
    onError: () => {
      useSwalError("Une erreur s'est produite.");
    },
  });
};
</script>

