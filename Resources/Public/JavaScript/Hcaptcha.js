function setHcaptchaHiddenFieldValue(response) {
    let activeFormCaptchaIFrame = document.querySelectorAll('iframe[data-hcaptcha-response="' + response + '"]')[0];
    let activeFormCaptchaHiddenFieldId = activeFormCaptchaIFrame.parentElement.nextSibling.id;
    document.getElementById(activeFormCaptchaHiddenFieldId).value = response;
}
