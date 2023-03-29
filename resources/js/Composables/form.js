import { useForm } from "@inertiajs/inertia-vue3";

export default function FormValues() {
    const form = useForm({
        nom_assure: "",
        date_reception: "",
        transferors_id: "",
        pays_assure: {
            id: 45,
            label: "Côte d’Ivoire",
        },
        branche: "",
        date_effet: "",
        date_echeance: "",
        monnaie: "XOF",
        capitaux: "",
        prime: "",
        commission_cedante: "",
        part_offerte: "",
        res: "",
        calcul: "",
        prime_reverser: "",
        prime_reçu: "",
        reinsurer: [
            {
                ppw: 30,
                raison_social: "",
            },
        ],
    });
    return { form };
}
