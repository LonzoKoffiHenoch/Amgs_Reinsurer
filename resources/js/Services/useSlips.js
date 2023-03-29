import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../Composables/alert";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

export default function useSlips() {
    const slips = ref([]);

    const getSlips = async () => {
        let response = await axios.get(route("apiSlip.index"));
        slips.value = response.data.data;
    };
    const createSlip = async (form) => {
        form.post(route("slip.store"), {
            onSuccess: (page) => {
                useSwalSuccess("Affaire ajouté avec succès!");
                form.reset();
            },
            onError: (errors) => {
                useSwalError("Une erreur s'est produite.");
                true;
            },
        });
    };
    const showReinsurerUnderSlip = async () => {
        axios
            .get(route("slip.get"))
            .then((response) => {
                slip.value = response.data.affaires;
                showreas.splice(0, showreas.length);
                for (let index = 0; index < slip.value.length; index++) {
                    showreas.push(false);
                }
            })
            .catch((error) => {
                console.log(error);
            });
    };
    const deleteSlip = (id, showreas) => {
        Inertia.delete(route("slip.delete", { borderau: id }), {
            onSuccess: (response) => {
                //showReinsurerUnderSlip(showreas);
                useSwalSuccess("l'affaire a été supprimée avec succès!");
            },
            onError: (error) => {
                useSwalError(error.message ?? "Une erreur a été rencontrée");
            },
        });
    };

    const updateSlip = async (form) => {
        form.post(route("slipe.update", { borderau: slip.id }), {
            onSuccess: (page) => {
                useSwalSuccess("Affaire ajouté avec succès!");
            },
            onError: (errors) => {
                useSwalError("Une erreur s'est produite.");
                true;
            },
        });
    };
    const destroySlip = (slipVar, showreas) => {
        let message = `Vous êtes sur le point de supprimer l'affaire "${slipVar.label}", voulez-vous continuer?`;
        useSwalConfirm(message, () => {
            deleteSlip(slipVar.id, showreas);
        });
    };
    return { slips, createSlip, updateSlip, destroySlip, getSlips };
}
