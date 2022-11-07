window.addEventListener("MsgSuccess", event => {
    iziToast.success({
        title: 'OK',
        message: event.detail.title,
        position: 'topLeft',
    });
});

window.addEventListener("MsgWarning", event => {
    iziToast.warning({
        title: 'Caution',
        message: event.detail.title,
        position: 'topLeft',
    });
});

window.addEventListener("MsgConfirmation", event => {
    iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: 'once',
        id: 'question',
        zindex: 999999,
        title: 'Hey',
        message: event.detail.title,
        position: 'center',
        buttons: [
            ['<button><b>YES</b></button>', function (instance, toast) {
                window.livewire.emit('confirmAction', event.detail.id)
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            }, true],
            ['<button>NO</button>', function (instance, toast) {
                window.livewire.emit('CancelAction', event.detail.id)
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            }],
        ],
    });
});
