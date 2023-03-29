<template>
    <MyModal :closeable="true" :show="showBusinesseModal" @close="setIsOpened(false)">
        <template #content>
            <div class="fixed inset-0 p-4 overflow-y-auto">
                <div class="flex justify-between">
                    <h3 class="text-2xl font-bold">Enregistrer une affaire</h3>
                    <div class="flex gap-8 left">
                        <button
                            class="text-xl w-8 h-8 transition-all hover:bg-primary hover:rounded-[100%] hover:w-8 hover:h-8 p-[0.15rem] hover:p-[0.15rem] hover:text-white"
                            @click="setIsOpened(false)">
                            x
                        </button>
                    </div>
                </div>
                <form @submit.prevent="storeBusiness()">
                    
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
                            <VueSelect v-model="form.pays_assure" :options="country" class="text-[0.90rem]"
                                       label="label"
                                       @option:selected="
                                    getTransferorFromCountry;changing()
                                ">
                            </VueSelect>
                        </div>
                        <!-- {{ form.transferors_id }} -->
                        <!-- Cedante -->
                        <div class="space-y-2">
                            <Label for="Cedante" value="Choisir la cedante"/>
                            <VueSelect v-model="form.transferors_id" :options="getTransferorFromCountry"
                                       class="text-[0.75rem] cedantSelectionner" label="raison_social"
                                       placeholder="Choisir la cedante">
                            </VueSelect>
                        </div>
                        
                        <!-- branche -->
                        <div class="space-y-2">
                            <Label for="Branches" value="Branche"/>
                            <VueSelect v-model="form.branche" :options="branche" :value="branche.id"
                                       class="text-[0.90rem]"
                                       label="label">
                            </VueSelect>
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
                                    class="w-full text-center border-gray-600 rounded-md"
                                    name="monnaie"
                                    @change="getCurrency(form.monnaie)">
                                <option :selected="true" value="USD">Dollars</option>
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
                                       withIcon @focus="deleteCurrency('capitaux_100', form.monnaie)"
                                       @focusout="checkingPercentage('capitaux_100', form.monnaie, 'currency')"/>
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
                                       withIcon @focus="deleteCurrency('Prime', form.monnaie)"
                                       @focusout="checkingPercentage('Prime', form.monnaie, 'currency')"/>
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
                                       withIcon @focus="deleteCurrency('Commission_cedante', 'percent')"
                                       @focusout="checkingPercentage('Commission_cedante', '', 'percent')"/>
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
                                       withIcon @focus="deleteCurrency('part_offerte', 'percent')"
                                       @focusout="checkingPercentage('part_offerte', '', 'percent')"/>
                            </InputIconWrapper>
                        </div>
                        <div class="col-span-2 my-2 bg-white">
                            <h2 class="pl-4 mb-0 text-white bg-primary hover:bg-secondary">
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
                                        @click.prevent="addReins()">
                                        Ajouter un Reassureur
                                    </button>
                                    <div class="space-y-2">
                                        <Label for="part_offerte" value="Prime reverser"/>
                                        <InputIconWrapper>
                                            <template #icon>
                                                <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                            </template>
                                            <Input id="part_offerte" v-model="form.prime_reverser" autofocus
                                                   class="block w-full"
                                                   placeholder="Prime à recevoir" required
                                                   type="text"
                                                   withIcon @focus="deleteCurrency('part_offerte', 'percent')"
                                                   @focusout="checkingPercentage('part_offerte', '', 'percent')"/>
                                        </InputIconWrapper>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex">
                        <button class="justify-end p-2 mt-4 text-white rounded-md bg-secondary "
                                @submit="storeBusiness()">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </template>
    </MyModal>
    
    
    <MyModal :closeable="closeable" :show="showrein" maxWidth="5xl" @close="setIsCloser(false)">
        <template #content>
            <div v-for="(reas,index) in form.reinsurer" v-bind:key="index"
                 class="grid grid-cols-8 gap-4 -m-[0.3rem]">
                <hr class="col-span-9 mt-4"/>
                
                <!-- Reassureur -->
                <div class="col-span-2 col-start-1 space-y-2">
                    <div class="space-y-2">
                        <Label for="Réassureur" value="Réassureur"/>
                        <div class="flex flex-col">
                            <VueSelect v-model="form.reinsurer[index].raison_social" :options="reinsurer">
                            </VueSelect>
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
                               @focus="deleteCurrency('part_accepte' + [index], 'percent')"
                               @focusout="checkingPercentage('part_accepte' + [index], '', 'percent'); calculer(index); checkingParts()"/>
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
                               @focus="deleteCurrency('commission_reassurance' + [index], 'percent')"
                               @focusout="checkingPercentage('commission_reassurance' + [index], '', 'percent')"/>
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
                               withIcon @focus="deleteCurrency('prime_reçu' + [index], form.monnaie)"
                               @focusout="checkingPercentage('prime_reçu' + [index], form.monnaie, 'currency')"/>
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
                               required type="date" withIcon
                               @focusout="checkingParts()"/>
                    </InputIconWrapper>
                </div>
            </div>
            
            <button v-if="showrein === true" class="p-1 px-2 mt-2 text-white rounded-md bg-primary"
                    @click.prevent="checkCloseModalReinsurer()">
                Fermer
            </button>
            {{ calcul }} || {{ form.part_offerte }}
        </template>
    </MyModal>

</template>

<script setup>
import MyModal from "@/Components/DialogModal.vue";
import VueSelect from "vue-select";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import {computed, onMounted, onUpdated, reactive, ref} from "vue";
import {UserIcon} from "@heroicons/vue/outline";
import usingForm from "@/Composables/form.js";
import utils from "@/Services/utils";
import useBranche from "@/Services/API/useBranche";
import useBusiness from "@/Services/useBusiness";


const props = defineProps(['showBusinesseModal', 'closeable', 'reinsurer', 'pays', 'cedante', 'reinsurer']);
const {form} = usingForm();
const country = ref([]);
const getTransferors = ref([]);
const transferorsItems = ref([]);
const showrein = ref(false);
const emit = defineEmits(["toggle", "showreins"]);

function setIsOpened(value) {
    emit("toggle", value);
}

const addReins = () => {
    showrein.value = true
}


const {branche, getBranche} = useBranche();


const {calcul, closer, changeCurrency, checkPercentage, checkPart, destroyCurrency, calculationPremium} = utils(form);
const getCurrency = (type) => {
    changeCurrency(type)
};
const checkingPercentage = (values, type, model) => {
    checkPercentage(values, type, model);
};
const checkingParts = (type) => {
    checkPart(type);
};
const deleteCurrency = (value, type) => {
    destroyCurrency(value, type);
};
const calculer = (index) => {
    calculationPremium(index);
};

const checkCloseModalReinsurer = () => {
    if (calcul.value == form.part_offerte) showrein.value = false;
}
const changing = () => {
    if (document.getElementsByClassName("vs__selected")[1]) {
        form.transferors_id = "";
    }
};

const getTransferorFromCountry = computed(() => {
    return getTransferors.value.filter(function (entry) {
        return entry.pays_id === form.pays_assure.id;
    });
});

const {createBusiness} = useBusiness();
onMounted(() => {
    country.value = JSON.parse(props.pays);
    getTransferors.value = JSON.parse(props.cedante);
    getBranche();
    console.log(getTransferors.value)
    
});
const storeBusiness = () => {
    createBusiness(form);
    setIsOpened(false);
};
onUpdated(() => {
    console.log(props.transferors)
})
</script>

