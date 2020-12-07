function setHcaptchaHiddenFieldValue(response) {
    let activeFormCaptchaIFrame = document.querySelectorAll('iframe[data-hcaptcha-response="' + response + '"]')[0];
    let activeFormCaptchaHiddenFieldId = activeFormCaptchaIFrame.parentElement.nextElementSibling.id;
    document.getElementById(activeFormCaptchaHiddenFieldId).value = response;
}

function renderHcpatchaWidget() {
    let forms = document.querySelectorAll('form');
    Array.prototype.forEach.call(forms, function (form) {
        form.addEventListener('input', (e) => {
            let widget = form.querySelector('.h-captcha');
            if (widget && !widget.firstChild) {
                hcaptcha.render(widget.getAttribute('id'));
                let btn = form.querySelector('button[data-captcha-forceload]');
                if (btn) {
                    btn.style.display = 'none';
                }
            }
        });
    });
}

function forceRenderHcpatchaWidget(btn) {
    hcaptcha.render(btn.getAttribute('data-captcha-forceload'));
    btn.style.display = 'none';
}
