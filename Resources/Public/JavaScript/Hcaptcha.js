function setHcaptchaHiddenFieldValue(response) {
    let activeFormCaptchaIFrame = document.querySelectorAll('iframe[data-hcaptcha-response="' + response + '"]')[0];
    let activeFormCaptchaHiddenFieldId = activeFormCaptchaIFrame.parentElement.nextElementSibling.id;
    document.getElementById(activeFormCaptchaHiddenFieldId).value = response;
}

function renderHcaptchaWidget() {
    let forms = document.querySelectorAll('form');
    Array.prototype.forEach.call(forms, function (form) {
        form.addEventListener('input', function(e) {
            let widget = form.querySelector('.h-captcha');
            if (widget && !widget.firstChild) {
                hcaptcha.render(widget.getAttribute('id'));
                let btn = form.querySelector('button[data-captcha-forceload]');
                if (btn) {
                    btn.style.display = 'none';
                }
                // Make sure the trigger element get's focused again
                e.target.focus();
            }
        });
    });
}

function forceRenderHcaptchaWidget(btn) {
    hcaptcha.render(btn.getAttribute('data-captcha-forceload'));
    btn.style.display = 'none';
}

function loadHcaptchaApi(url, callback) {
    // Adding the script tag to the head as suggested before
    var head = document.head;
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url;
    script.async = false;

    // Then bind the event to the callback function.
    // There are several events for cross browser compatibility.
    script.onreadystatechange = callback;
    script.onload = callback;

    // Fire the loading
    head.appendChild(script);
}

loadHcaptchaApi('https://hcaptcha.com/1/api.js?render=explicit', renderHcaptchaWidget);
