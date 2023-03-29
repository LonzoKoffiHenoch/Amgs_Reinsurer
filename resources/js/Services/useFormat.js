export default function useFormat() {
    const formatAsPercentage = (number = 0) => {
        return new Intl.NumberFormat("fr-FR", {
            style: "percent",
            maximumFractionDigits: 2,
        }).format(number);
    };

    const formatAsMonney = (number = 0, monney = "XOF") => {
        return new Intl.NumberFormat("fr-FR", {
            currency: monney,
            style: "currency",
        }).format(Math.round(number));
    };
    return {
        formatAsPercentage,
        formatAsMonney,
    };
}
