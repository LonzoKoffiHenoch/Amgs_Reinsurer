import { ref } from "vue";
import { useSwalConfirm } from "@/Composables/alert";

export default function utils(form) {
    const calcul = ref(0);
    const closer = ref(true);
    const changeCurrency = (type) => {
        const listCurrency =
            document.getElementsByClassName("contient_monnaie");
        for (let index = 0; index < listCurrency.length; index++) {
            if (listCurrency[index].value !== 0) {
                const res = parseFloat(
                    listCurrency[index].value
                        .replace(/\s/g, "")
                        .replace(/,/g, ".")
                );
                listCurrency[index].value = new Intl.NumberFormat("fr-FR", {
                    currency: type,
                    style: "currency",
                }).format(res);
            }
        }
    };

    const checkPercentage = (values, type, model) => {
        let regex = /^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)$/; //regex de verification
        if (!regex.test(document.getElementById(values).value)) {
            document.getElementById(values).value = "";
        }
        if (model === "currency") {
            document.getElementById(values).value = new Intl.NumberFormat(
                "fr-FR",
                {
                    currency: type,
                    style: "currency",
                }
            ).format(document.getElementById(values).value);
        }
        if (model === "percent") {
            document.getElementById(values).value += " %";
        }
    };

    const checkPart = (type) => {
        if (type !== "fermer") {
            calcul.value = 0;
            for (let index = 0; index < form.reinsurer.length; index++) {
                calcul.value += parseFloat(form.reinsurer[index].part_accepte);
            }
            if (calcul.value < form.part_offerte) {
                form.reinsurer.push({
                    ppw: 30,
                });
            }
            if (calcul.value > form.part_offerte) {
                useSwalConfirm(
                    "Veuillez reduire la part du dernier reassureur "
                );
            }
        } else {
            if (type === "fermer" && calcul.value === form.part_offerte) {
                closer.value = false;
            }
        }
    };

    const destroyCurrency = (value, type) => {
        if (type !== "percent") {
            if (document.getElementById(value).value !== 0) {
                document.getElementById(value).value = parseFloat(
                    document
                        .getElementById(value)
                        .value.replace(/\s/g, "")
                        .replace(/,/g, ".")
                );
            }
        }
        if (type === "percent") {
            document.getElementById(value).value = document
                .getElementById(value)
                .value.replace(" %", "");
        }
    };

    const calculationPremium = (index) => {
        form.reinsurer[index].prime_reassurance =
            (form.prime * form.reinsurer[index].part_accepte) / 100;
        form.reinsurer[index].prime_reçu =
            form.reinsurer[index].prime_reassurance;
        changeCurrency(form.monnaie);
    };

    const formatAsPercentage = (number) => {
        return new Intl.NumberFormat("default", {
            style: "percent",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format(number / 100);
    };
    return {
        calcul,
        changeCurrency,
        checkPercentage,
        checkPart,
        destroyCurrency,
        calculationPremium,
        formatAsPercentage,
    };
}
