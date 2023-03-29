<template>
    <MyModal :closeable="true" :form="form" :show="show" @close="setIsOpened(false)">
        <template #content>
            <div class="fixed inset-0 p-4 overflow-y-auto">
                <div class="flex justify-between">
                    <h3 class="text-2xl font-bold">Créer une affaire</h3>
                    <div class="flex gap-8 left">
                        <button
                            class="text-xl w-8 h-8 transition-all hover:bg-primary hover:rounded-[100%] hover:w-8 hover:h-8 p-[0.15rem] hover:p-[0.15rem] hover:text-white"
                            @click="setIsOpened(false)">
                            x
                        </button>
                    </div>
                </div>
                <form @submit.prevent="soumettre">
                    <hr class="mb-4"/>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- assuré -->
                        <div class="space-y-2">
                            <Label for="nomAssure" value="Nom de l'assuré"/>
                            <InputIconWrapper>
                                <template #icon>
                                    <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                </template>
                                <Input id="nomAssure" v-model="form.nom_assure" autocomplete="nomAssure" autofocus
                                       class="block w-full" placeholder="Nom de l'assuré" required type="text"
                                       withIcon/>
                            </InputIconWrapper>
                        </div>
                        
                        <!-- Date reception Affaire -->
                        <div class="space-y-2">
                            <Label for="DateReception" value="Date de reception de l'affaire"/>
                            <InputIconWrapper>
                                <template #icon>
                                    <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                </template>
                                <Input id="DateReception" v-model="form.date_reception" autocomplete="name" autofocus
                                       class="block w-full" required type="date" withIcon/>
                            </InputIconWrapper>
                        </div>
                        <!-- Pays @option:selecting="search"-->
                        <div class="space-y-2">
                            <Label for="Pays" value="Pays de l'assuré"/>
                            <v-select v-model="form.pays_assure" :options="country" class="text-[0.90rem]" label="label"
                                      @option:selected="Vcedante, changing()">
                            </v-select>
                        </div>
                        
                        <!-- Cedante -->
                        <div class="space-y-2">
                            <Label for="Cedante" value="Choisir la cedante"/>
                            <v-select v-model="form.transferors_id" :options="Vcedante"
                                      class="text-[0.75rem] cedantSelectionner" label="raison_social"
                                      placeholder="Choisir la cedante">
                            </v-select>
                        </div>
                        
                        <!-- branche -->
                        <div class="space-y-2">
                            <Label for="Branches" value="Branche"/>
                            <InputIconWrapper>
                                <template #icon>
                                    <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                </template>
                                <Input id="Branche" v-model="form.branche" autocomplete="branche" autofocus
                                       class="block w-full"
                                       placeholder="Branche" required type="text" withIcon/>
                            </InputIconWrapper>
                        </div>
                        
                        <!-- Date effet -->
                        <div class="space-y-2">
                            <Label for="DateEffet" value="Date d'effet"/>
                            <InputIconWrapper>
                                <template #icon>
                                    <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                </template>
                                <Input id="DateEffet" v-model="form.date_effet" autocomplete="name" autofocus
                                       class="block w-full" placeholder="Date d'effet" required type="date"
                                       withIcon/>
                            </InputIconWrapper>
                        </div>
                        
                        <!-- Date echeance -->
                        <div class="space-y-2">
                            <Label for="DateEcheance" value="Date d'echeance"/>
                            <InputIconWrapper>
                                <template #icon>
                                    <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                </template>
                                <Input id="DateEchance" v-model="form.date_echeance" autocomplete="name" autofocus
                                       class="block w-full" placeholder="Date d'echeance" required type="date"
                                       withIcon/>
                            </InputIconWrapper>
                        </div>
                        
                        <!-- monnaie -->
                        <div class="w-full space-y-2">
                            <Label for="monnaie" value="Choisir la monnaie"/>
                            <select id="monnaie" v-model="form.monnaie"
                                    class="w-full text-center border-gray-600 rounded-md "
                                    name="monnaie"
                                    @change="changeMonnaie(form.monnaie)">
                                <option :selected="true" value="USD">
                                    Dollars
                                </option>
                                <option value="EUR">Euro</option>
                                <option value="XOF">Fcfa</option>
                                <option value="GBP">Livres</option>
                            </select>
                        </div>
                        
                        <!-- Capitaux à 100% -->
                        <div class="space-y-2">
                            <Label for="capitaux_100" value="Capitaux"/>
                            <InputIconWrapper>
                                <template #icon>
                                    <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                </template>
                                <Input id="capitaux_100" v-model="form.capitaux" autofocus
                                       class="block w-full contient_monnaie"
                                       placeholder="Capitaux à 100%" required
                                       type="text"
                                       withIcon @focus="deleteMonnaie('capitaux_100', form.monnaie)"
                                       @focusout="verifPourcentage('capitaux_100', form.monnaie, 'currency')"/>
                            </InputIconWrapper>
                        </div>
                        
                        <!-- Prime à 100% -->
                        <div class="space-y-2">
                            <Label for="Prime" value="Prime à 100%"/>
                            <InputIconWrapper>
                                <template #icon>
                                    <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                </template>
                                <Input id="Prime" v-model="form.prime" autofocus class="block w-full contient_monnaie"
                                       placeholder="Entrez la prime" required
                                       type="text"
                                       withIcon @focus="deleteMonnaie('Prime', form.monnaie)"
                                       @focusout="verifPourcentage('Prime', form.monnaie, 'currency')"/>
                            </InputIconWrapper>
                        </div>
                        
                        <!-- Commission Cedente -->
                        <div class="space-y-2">
                            <Label for="Commission_cedante" value="Commission de la cedante"/>
                            <InputIconWrapper>
                                <template #icon>
                                    <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                </template>
                                <Input id="Commission_cedante" v-model="form.commission_cedante" autofocus
                                       class="block w-full" placeholder="Commission de la cédante"
                                       required
                                       type="text"
                                       withIcon @focus="deleteMonnaie('Commission_cedante', 'percent')"
                                       @focusout="verifPourcentage('Commission_cedante', '', 'percent')"/>
                            </InputIconWrapper>
                        </div>
                        <!-- Part offert -->
                        <div class="space-y-2">
                            <Label for="part_offerte" value="Part Offerte"/>
                            <InputIconWrapper>
                                <template #icon>
                                    <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                </template>
                                <Input id="part_offerte" v-model="form.part_offerte" autofocus class="block w-full"
                                       placeholder="Entrez la part offerte" required
                                       type="text"
                                       withIcon @focus="deleteMonnaie('part_offerte', 'percent')"
                                       @focusout="verifPourcentage('part_offerte', '', 'percent')"/>
                            </InputIconWrapper>
                        </div>
                        <div class="col-span-2 my-2 bg-white">
                            <h2 class="pl-4 mb-0 text-white bg-primary hover:bg-secondary ">
                                <Button
                                    class="relative flex justify-between w-full py-2 text-base text-center text-white transition border-0 rounded-none accordion-button focus:outline-none"
                                    type="button" @click.prevent="form.res = !form.res">
                                    <span class="text-xl">Reassureurs</span>
                                    <span v-if="form.res" class="px-2 text-3xl">-</span>
                                    <span v-else class="px-2 text-3xl">+</span>
                                </Button>
                            </h2>
                            
                            <!-- demande d'information -->
                            <div v-if="form.res">
                                <div class="grid grid-cols-2 gap-4 mt-2">
                                    <!-- Nom du reassureurs offert -->
                                    <button
                                        class="w-auto p-1 mt-3 bg-white rounded-md text-secondary hover:bg-primary hover:text-white"
                                        @click.prevent="showrein = true">
                                        Ajouter un Reassureur
                                    </button>
                                    <div class="space-y-2">
                                        <Label for="part_offerte" value="Prime à recevoir"/>
                                        <InputIconWrapper>
                                            <template #icon>
                                                <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                            </template>
                                            <Input id="part_offerte" v-model="form.prime_reverser" autofocus
                                                   class="block w-full"
                                                   placeholder="Prime reverser" required
                                                   type="text"
                                                   withIcon @focus="deleteMonnaie('part_offerte', 'percent')"
                                                   @focusout="verifPourcentage('part_offerte', '', 'percent')"/>
                                        </InputIconWrapper>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex">
                        <button class="justify-end p-2 mt-4 text-white rounded-md bg-secondary " @submit="soumettre">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </template>
    </MyModal>
    <MyModal :closeable="closeable" :show="showrein" maxWidth="w-2" @close="setIsCloser(false)">
        <template #content>
            <div v-for="(reinsu, index) in form.reinsurer"
                 v-bind:key="index"
                 class="grid xl:grid-cols-8 gap-2 -m-[0.3rem] sm:grid sm:grid-cols-1 lg:grid lg:grid-cols-4 ">
                <div class="flex justify-between gap-2 mt-4 xl:col-span-8">
                    <hr class="self-center w-full xl:col-span-8"/>
                    <div>
                        <button v-if="showrein == true"
                                class="items-end w-6 h-6 text-sm text-center text-white rounded-md bg-primary hover:bg-black "
                                @click.prevent="del(index)">
                            x
                        </button>
                    </div>
                </div>
                <!-- Reassureur -->
                <div class="col-span-2 col-start-1 space-y-2">
                    <div class="space-y-2">
                        <Label for="Réassureur" value="Réassureur"/>
                        <div class="flex flex-col">
                            <v-select v-model="form.reinsurer[index].raison_social" :options="reinsurer">
                            </v-select>
                        </div>
                    </div>
                </div>
                <!-- Part Accepté -->
                <div class="space-y-2">
                    <Label :for="'part_accepte' + [index]" value="Entrez la part acceptée"/>
                    <InputIconWrapper>
                        <template #icon>
                            <UserIcon aria-hidden="true" class="w-5 h-5"/>
                        </template>
                        <Input :id="'part_accepte' + [index]" v-model="form.reinsurer[index].part_accepte" autofocus
                               class="block w-full text-xs part_accepte"
                               placeholder="Part Accepté" required
                               type="text"
                               withIcon @change="calculer(index)"
                               @focus="deleteMonnaie('part_accepte' + [index], 'percent')"
                               @focusout="verifPourcentage('part_accepte' + [index], '', 'percent'); calculer(index);"/>
                    </InputIconWrapper>
                </div>
                <!-- commission_reassurance -->
                <div class="space-y-2">
                    <Label for="Commission_reassurance" value="Commision de réassurance"/>
                    <InputIconWrapper>
                        <template #icon>
                            <UserIcon aria-hidden="true" class="w-5 h-5"/>
                        </template>
                        <Input :id="'commission_reassurance' + [index]"
                               v-model="form.reinsurer[index].commission_reassurance"
                               class="block w-full text-xs part_accepte"
                               required
                               type="text"
                               withIcon
                               @focus="deleteMonnaie('commission_reassurance' + [index], 'percent')"
                               @focusout="verifPourcentage('commission_reassurance' + [index], '', 'percent')"/>
                    </InputIconWrapper>
                </div>
                
                <!-- Prime reception Affaire -->
                <div class="space-y-2">
                    <Label for="prime_reassurance" value="Prime reassureur"/>
                    <InputIconWrapper>
                        <template #icon>
                            <UserIcon aria-hidden="true" class="w-5 h-5"/>
                        </template>
                        <Input :id="'prime_reassurance' + [index]" v-model="form.reinsurer[index].prime_reassurance"
                               autofocus
                               class="block w-full text-xs contient_monnaie"
                               readonly="readonly" required type="text"
                               withIcon/>
                    </InputIconWrapper>
                </div>
                
                <!-- Date reception Affaire -->
                <div class="space-y-2">
                    <Label :for="'prime_reçu' + [index]" value="Prime à recevoir"/>
                    <InputIconWrapper>
                        <template #icon>
                            <UserIcon aria-hidden="true" class="w-5 h-5"/>
                        </template>
                        <Input :id="'prime_reçu' + [index]" v-model="form.reinsurer[index].prime_a_reverser" autofocus
                               class="block w-full text-xs contient_monnaie"
                               required
                               type="text"
                               withIcon @focus="deleteMonnaie('prime_reçu' + [index], form.monnaie)"
                               @focusout="verifPourcentage('prime_reçu' + [index], form.monnaie, 'currency')"/>
                    </InputIconWrapper>
                </div>
                <!-- PPW -->
                <div class="space-y-2">
                    <Label for="ppw" value="PPW"/>
                    <InputIconWrapper>
                        <template #icon>
                            <UserIcon aria-hidden="true" class="w-5 h-5"/>
                        </template>
                        <Input id="ppw" v-model="form.reinsurer[index].ppw" autocomplete="name" autofocus
                               class="block w-full text-xs" required type="number" withIcon/>
                    </InputIconWrapper>
                </div>
                
                <!-- Date Accept -->
                <div class="space-y-2">
                    <Label for="date_accept" value="Date acceptation"/>
                    <InputIconWrapper>
                        <template #icon>
                            <UserIcon aria-hidden="true" class="w-5 h-5"/>
                        </template>
                        <Input id="date_accept" v-model="form.reinsurer[index].date_accept" autofocus
                               class="block w-full text-xs part_accepte"
                               required type="date" withIcon @focusout="verif()"/>
                    </InputIconWrapper>
                </div>
            </div>
            <div>
                <button v-if="showrein == true" class="p-1 px-2 mt-2 text-white rounded-md bg-secondary hover:bg-black "
                        @click.prevent="add()">
                    ajouter un reassureur
                </button>
                <button v-if="showrein == true" class="p-1 px-2 mt-2 ml-5 text-white rounded-md bg-primary"
                        @click.prevent="showrein = false">
                    Fermer
                </button>
            </div>
        </template>
    </MyModal>
</template>
<script></script>
<script setup>
import vSelect from "vue-select";

import MyModal from "@/Components/DialogModal.vue";
import {
    useSwalSuccess,
    useSwalError,
    useSwalConfirm,
} from "../../Composables/alert";
import {useForm} from "@inertiajs/inertia-vue3";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import {ref, reactive, onMounted, computed} from "vue";
import AddReinsurer from "./Form/FormAddReinsurer.vue";
import usingForm from "@/Composables/form.js";

import {
    UserIcon,
    MailIcon,
    LockClosedIcon,
    UserAddIcon,
} from "@heroicons/vue/outline";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    showrein: {
        type: Boolean,
        default: false,
    },
    
    closeable: {
        type: Boolean,
        default: true,
    },
    reinsurer: Array,
    pays: Object,
    // cedante: Array,
    cedante: Object,
    formValues: Object,
});
const {form} = usingForm();
const ced = ref([]);
const country = ref([]);

const calcul = ref(0);
const emit = defineEmits(["toggler", "closer"]);

function setIsOpened(value) {
    emit("toggler", value);
}

function setIsCloser(value) {
    emit("closer", value);
}

const add = () => {
    form.reinsurer.push({
        ppw: 30,
    });
};
const del = (index) => {
    form.reinsurer.splice(index, 1);
};
const calculer = (index) => {
    form.reinsurer[index].prime_reassurance =
        (form.prime * form.reinsurer[index].part_accepte) / 100;
    form.reinsurer[index].prime_a_reverser = form.reinsurer[index].prime_reassurance;
    changeMonnaie(form.monnaie);
};
const verif = (type) => {
    if (!(type === "fermer")) {
        calcul.value = 0;
        for (let index = 0; index < form.reinsurer.length; index++) {
            calcul.value += parseFloat(form.reinsurer[index].part_accepte);
        }
        if (calcul.value < form.part_offerte) {
            add();
        }
        if (calcul.value > form.part_offerte) {
            useSwalConfirm("Veuillez reduire la part du dernier reassureur ");
        }
    } else {
        if (!(type === "fermer" && calcul.value === form.part_offerte)) {
            return;
        }
        setIsCloser(false);
    }
    // console.log(calcul.value);
};
const remove = () => {
    this.form.reinsurer.pop();
};

const verifPourcentage = (values, type, model) => {
    //console.log(value);
    //let regex = /^[0-9]{1,50}$/; //regex de verification
    let regex = /^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)$/; //regex de verification
    
    if (!regex.test(document.getElementById(values).value)) {
        document.getElementById(values).value = "";
        console.log(type);
    }
    if (model == "currency") {
        document.getElementById(values).value = new Intl.NumberFormat("fr-FR", {
            currency: type,
            style: "currency",
        }).format(document.getElementById(values).value);
        //console.log(document.getElementById(value).value);
    }
    if (model === "percent") {
        document.getElementById(values).value += " %";
    }
};

const changeMonnaie = (type) => {
    const list_champ_monnaie =
        document.getElementsByClassName("contient_monnaie");
    for (let index = 0; index < list_champ_monnaie.length; index++) {
        if (list_champ_monnaie[index].value != 0) {
            //form.capitaux = form.capitaux.replace(form.monnaie, "");
            
            const res = parseFloat(
                list_champ_monnaie[index].value
                    .replace(/\s/g, "")
                    .replace(/,/g, ".")
            );
            //console.log(res);
            list_champ_monnaie[index].value = new Intl.NumberFormat("fr-FR", {
                currency: type,
                style: "currency",
            }).format(res);
        }
    }
};
const deleteMonnaie = (value, type) => {
    if (type != "percent") {
        if (document.getElementById(value).value != 0) {
            document.getElementById(value).value = parseFloat(
                document
                    .getElementById(value)
                    .value.replace(/\s/g, "")
                    .replace(/,/g, ".")
            );
        }
    }
    if (type == "percent") {
        //console.log("tedst");
        document.getElementById(value).value = document
            .getElementById(value)
            .value.replace(" %", "");
    }
};

//props.cedante = computed(() => JSON.parse(props.cedante));
const Vcedante = computed(() => {
    ced.value = JSON.parse(props.cedante).filter(function (entry) {
        if (form.pays_assure.id == null) {
            return entry.pays_id === 45;
        }
        return entry.pays_id === form.pays_assure.id;
    });
    return ced.value;
});
const changing = () => {
    if (document.getElementsByClassName("vs__selected")[1]) {
        form.transferors_id = "";
    }
};
onMounted(() => {
    country.value = JSON.parse(props.pays);
});
const soumettre = () => {
    form.post(route("business.store"), {
        onSuccess: (page) => {
            useSwalSuccess("Affaire ajouté avec succès!");
            setIsOpened(false);
            form.reset();
        },
        onError: (errors) => {
            useSwalError("Une erreur s'est produite.");
            preserveState: true;
        },
    });
};
</script>

