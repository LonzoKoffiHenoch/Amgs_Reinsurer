import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "@/Composables/alert";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

export default function useActivityRates() {
    const activity = ref([]);
    const activities = ref([]);
    const loading = ref(false);
    const getActivitiesFromReinsurer = (pays) => {
        console.log(JSON.stringify(pays));
        loading.value = true;
        axios
            .get(
                route("activities.getreas", {
                    pays: JSON.stringify(pays),
                })
            )
            .then((response) => {
                activities.value = response.data.data;
                loading.value = false;
            })
            .catch((error) => {
                console.log(error);
            });
    };
    const getActivities = async (pays) => {
        loading.value = true;

        axios
            .get(
                route("activities.get", {
                    pays: pays,
                })
            )
            .then((response) => {
                activities.value = response.data.data;
                loading.value = false;
            })
            .catch((error) => {
                console.log(error);
            });
    };

    return {
        activity,
        activities,
        loading,
        getActivities,
        getActivitiesFromReinsurer,
    };
}
