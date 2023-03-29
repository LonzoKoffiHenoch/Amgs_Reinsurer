import { ref } from "vue";

export default function useApi() {
    const countries = ref([]);
    const branches = ref([]);
    const transferors = ref([]);
    const activities = ref([]);

    const getCountry = async () => {
        await axios
            .get(route("api.getPays"))
            .then((response) => {
                countries.value = response.data.pays;
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const getBranche = async () => {
        await axios
            .get(route("api.getBranche"))
            .then((response) => {
                branches.value = response.data.branche;
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const getTransferor = async () => {
        await axios
            .get(route("api.getAllTransferor"))
            .then((response) => {
                transferors.value = response.data.transferors;
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const getActivity = async () => {
        await axios
            .get(route("api.getActivities"))
            .then((response) => {
                console.log(response.data);
                activities.value = response.data.activities;
            })
            .catch((error) => {
                console.log(error);
            });
    };

    return {
        countries,
        branches,
        transferors,
        activities,
        getCountry,
        getBranche,
        getTransferor,
        getActivity,
    };
}
