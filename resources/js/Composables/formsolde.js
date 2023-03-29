import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";

export default function FormValues() {
    const formsolde = useForm({
        business: [],
    });
    return { formsolde };
}
