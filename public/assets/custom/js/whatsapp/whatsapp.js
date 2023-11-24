
let isConnected = false;
const check = () => {
    const checkInterval = setInterval(() => {
        if (!isConnected) {
            $.get("whatsapp/check/instance", (response, status) => {
                if (response.instance_data.user.length !== 0) {
                    isConnected = true;
                    clearInterval(checkInterval);
                    $(".qrDivision").html(
                        `<b><img draggable="false" src="${connectedImage}"><h3 class="instanceReady">Connected</h3></b>`
                    );
                }
            });
        }
    }, 3000);
}

let createInterval;

const createInstance = () => {
    if (!isConnected) {
        $.post("whatsapp/create/instance", (response, status) => {
            $(".qrLoadingSpinner").hide();
            if (response.error) {
                clearInterval(createInterval);
                swal('Error', response.message, 'error');
                return false;
            }

            if (response.qrcode !== '') {
                $(".instanceReady, .generateButton").hide();
                $("#qrcode, #qrcode-container").show();
                $("#qrImage").attr('src', response.qrcode);
            }
        });
    }
}

$(document).ready(() => {
    $(".generateButton").on('click', (e) => {
        e.preventDefault();
        $(".generateButton").hide();
        $(".qrLoadingSpinner").show();
        check();
        createInstance();
        createInterval = setInterval(createInstance, 20000);
    });
});
