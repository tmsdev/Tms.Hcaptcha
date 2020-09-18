function setHcaptchaHiddenFieldValue(response) {
    let activeFormCaptchaIFrame = document.querySelectorAll('iframe[data-hcaptcha-response="' + response + '"]')[0];
    let activeFormCaptchaHiddenFieldId = activeFormCaptchaIFrame.parentElement.nextElementSibling.id;
    document.getElementById(activeFormCaptchaHiddenFieldId).value = response;
}
