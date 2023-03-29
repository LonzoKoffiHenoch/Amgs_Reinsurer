import { ref } from "vue";
export default function useBranche() {
    const branche = ref([]);

    const getBranche = async () => {
        await axios
            .get(route("api.getBranche"))
            .then((response) => {
                branche.value = response.data.branche;
            })
            .catch((error) => {
                console.log(error);
            });
    };
    return { branche, getBranche };
}
