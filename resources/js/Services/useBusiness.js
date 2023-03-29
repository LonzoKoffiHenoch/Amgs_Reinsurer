import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "@/Composables/alert";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

export default function useBusiness() {
    const business = ref([]);
    const businesses = ref([]);
    const loading = ref(false);

    const createBusiness = async (form) => {
        form.post(route("business.store"), {
            onSuccess: (page) => {
                useSwalSuccess("Affaire ajouté avec succès!");
                form.reset();
            },
            onError: (errors) => {
                useSwalError("Une erreur s'est produite.");
            },
        });
    };
    const showReinsurerUnderBusiness = async () => {
        axios
            .get(route("business.get"))
            .then((response) => {
                business.value = response.data.affaires;
                showreas.splice(0, showreas.length);
                for (let index = 0; index < business.value.length; index++) {
                    showreas.push(false);
                }
            })
            .catch((error) => {
                console.log(error);
            });
    };
    const deleteBusiness = (id, showreas) => {
        loading.value = true;
        Inertia.delete(route("business.delete", { affaire: id }), {
            onSuccess: (response) => {
                showReinsurerUnderBusiness(showreas);
                useSwalSuccess("l'affaire a été supprimée avec succès!");
                loading.value = false;
            },
            onError: (error) => {
                useSwalError(error.message ?? "Une erreur a été rencontrée");
            },
        });
    };
    const destroyBusiness = (affaire, showreas) => {
        const message = `Vous êtes sur le point de supprimer l'affaire "${affaire.nom_assure}", voulez-vous continuer?`;
        useSwalConfirm(message, "Confirmer", "Non, annuler", () => {
            deleteBusiness(affaire.id, showreas);
        });
    };
    const updateBusiness = async (form) => {
        form.post(route("businesse.update", { affaire: props.affaires.id }), {
            onSuccess: (page) => {
                useSwalSuccess("Affaire ajouté avec succès!");
            },
            onError: (errors) => {
                useSwalError("Une erreur s'est produite.");
            },
        });
    };
    return {
        business,
        businesses,
        loading,
        createBusiness,
        updateBusiness,
        destroyBusiness,
    };
}
