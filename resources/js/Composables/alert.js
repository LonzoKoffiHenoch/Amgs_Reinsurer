import Swal from "sweetalert2";

export function useSwalSuccess(message) {
    Swal.fire({
        toast: true,
        icon: "success",
        title: message,
        animation: false,
        position: "top-end",
        showConfirmButton: false,
        timer: 4000,
    });
}

export function useSwalError(message, timer = 4000) {
    Swal.fire({
        toast: true,
        icon: "error",
        title: message,
        position: "top-end",
        showConfirmButton: false,
        timer: timer ?? 4000,
    });
}

export function useSwalConfirm(message, confirm = "Oui, continuer.", cancel = "Non, fermer.", callback) {
    Swal.fire({
        html: message,
        icon: "warning",
        buttonsStyling: true,
        showCancelButton: true,
        confirmButtonText: confirm,
        cancelButtonText: cancel,
        customClass: {
            confirmButton: "btn bg-secondary",
            cancelButton: "btn bg-primary",
        },
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        } else if (result.isDenied) {
            Swal.close();
        }
    });
}
